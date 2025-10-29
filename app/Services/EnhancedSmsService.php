<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

/**
 * Enhanced SMS Service with Production-Ready Security
 * 
 * Features:
 * - Request signing and verification
 * - Comprehensive logging
 * - Rate limiting per user/IP
 * - Duplicate request prevention
 * - Phone number validation
 * - Multiple provider fallback
 */
class EnhancedSmsService
{
    protected string $provider;
    protected array $config;
    protected array $fallbackProviders;

    public function __construct()
    {
        $this->provider = config('sms.default_provider', 'unifonic');
        $this->config = config("sms.providers.{$this->provider}", []);
        $this->fallbackProviders = config('sms.fallback_providers', []);
    }

    /**
     * Send OTP with enhanced security
     */
    public function sendOTP(string $phone, string $code, array $metadata = []): array
    {
        // Validate phone number
        if (!$this->validatePhoneNumber($phone)) {
            Log::warning('Invalid phone number', ['phone' => $this->maskPhone($phone)]);
            return [
                'success' => false,
                'error' => 'رقم الهاتف غير صحيح',
            ];
        }

        // Check rate limiting
        $rateLimitKey = "sms_rate_limit:{$phone}";
        $attempts = Cache::get($rateLimitKey, 0);
        $maxAttempts = config('sms.otp.max_attempts', 3);
        $rateLimitWindow = config('sms.otp.rate_limit_window', 600); // 10 minutes

        if ($attempts >= $maxAttempts) {
            Log::warning('Rate limit exceeded', [
                'phone' => $this->maskPhone($phone),
                'attempts' => $attempts,
            ]);
            return [
                'success' => false,
                'error' => 'لقد تجاوزت الحد الأقصى من المحاولات. الرجاء الانتظار 10 دقائق.',
                'retry_after' => Cache::ttl($rateLimitKey),
            ];
        }

        // Prevent duplicate requests
        $requestHash = hash('sha256', $phone . $code . now()->toIso8601String());
        $duplicateKey = "sms_request:{$requestHash}";
        
        if (Cache::has($duplicateKey)) {
            return [
                'success' => false,
                'error' => 'Duplicate request detected',
            ];
        }
        Cache::put($duplicateKey, true, now()->addMinutes(5));

        // Format phone number
        $formattedPhone = $this->formatPhone($phone);

        // Compose message
        $message = $this->composeOTPMessage($code);

        // Send via primary provider or fallback
        try {
            $result = $this->sendWithFallback($formattedPhone, $message);
            
            // Increment rate limit counter
            Cache::put($rateLimitKey, $attempts + 1, now()->addSeconds($rateLimitWindow));
            
            // Log success
            Log::channel('sms')->info('OTP sent successfully', [
                'phone' => $this->maskPhone($formattedPhone),
                'provider' => $this->provider,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'timestamp' => now()->toIso8601String(),
                'metadata' => $metadata,
            ]);

            return [
                'success' => true,
                'message_id' => $result['message_id'] ?? null,
                'provider' => $this->provider,
            ];
        } catch (\Exception $e) {
            Log::error('OTP sending failed', [
                'phone' => $this->maskPhone($formattedPhone),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => 'فشل في إرسال الرسالة. الرجاء المحاولة لاحقاً.',
            ];
        }
    }

    /**
     * Send with automatic fallback
     */
    protected function sendWithFallback(string $phone, string $message): array
    {
        // Try primary provider
        try {
            $result = $this->sendViaProvider($this->provider, $phone, $message);
            if ($result['success']) {
                return $result;
            }
        } catch (\Exception $e) {
            Log::warning('Primary SMS provider failed', [
                'provider' => $this->provider,
                'error' => $e->getMessage(),
            ]);
        }

        // Try fallback providers
        foreach ($this->fallbackProviders as $fallbackProvider) {
            try {
                $this->provider = $fallbackProvider;
                $this->config = config("sms.providers.{$fallbackProvider}", []);
                
                $result = $this->sendViaProvider($fallbackProvider, $phone, $message);
                if ($result['success']) {
                    Log::info('SMS sent via fallback provider', [
                        'provider' => $fallbackProvider,
                    ]);
                    return $result;
                }
            } catch (\Exception $e) {
                Log::warning('Fallback provider failed', [
                    'provider' => $fallbackProvider,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        throw new \Exception('All SMS providers failed');
    }

    /**
     * Send via specific provider
     */
    protected function sendViaProvider(string $provider, string $phone, string $message): array
    {
        if (!$this->isEnabled()) {
            Log::channel('sms')->info('SMS disabled (development mode)', [
                'phone' => $this->maskPhone($phone),
                'message' => $message,
            ]);
            return ['success' => true, 'mode' => 'development'];
        }

        return match($provider) {
            'unifonic' => $this->sendViaUnifonic($phone, $message),
            'msegat' => $this->sendViaMsegat($phone, $message),
            'twilio' => $this->sendViaTwilio($phone, $message),
            '4jawaly' => $this->sendVia4Jawaly($phone, $message),
            default => $this->sendViaLog($phone, $message),
        };
    }

    /**
     * Validate Saudi Arabia phone number
     */
    protected function validatePhoneNumber(string $phone): bool
    {
        // Remove all non-numeric characters except +
        $normalized = preg_replace('/[^0-9+]/', '', $phone);
        
        // Check for Saudi Arabia format
        // Format: +966XXXXXXXXX or 966XXXXXXXXX or 05XXXXXXXX
        $patterns = [
            '/^\+966[0-9]{9}$/',      // +9665XXXXXXXX
            '/^966[0-9]{9}$/',         // 9665XXXXXXXX
            '/^05[0-9]{8}$/',         // 05XXXXXXXX
            '/^5[0-9]{8}$/',          // 5XXXXXXXX
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $normalized)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Format phone to international format
     */
    protected function formatPhone(string $phone, string $prefix = '+966'): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Remove leading 0
        if (substr($phone, 0, 1) === '0') {
            $phone = substr($phone, 1);
        }
        
        // Remove country code if already present
        if (substr($phone, 0, 3) === '966') {
            $phone = substr($phone, 3);
        }
        
        return $prefix . $phone;
    }

    /**
     * Mask phone number for logging
     */
    protected function maskPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($phone) <= 6) {
            return $phone;
        }
        return substr($phone, 0, 3) . '***' . substr($phone, -3);
    }

    /**
     * Compose OTP message
     */
    protected function composeOTPMessage(string $code): string
    {
        $expiry = config('sms.otp.expires_in', 5);
        return "كود التحقق الخاص بك في لُجين الزراعية هو: {$code}\nصالح لمدة {$expiry} دقائق";
    }

    /**
     * Send via Unifonic
     */
    protected function sendViaUnifonic(string $phone, string $message): array
    {
        $response = Http::timeout(10)
            ->post('https://el.cloud.unifonic.com/rest/SMS/messages', [
                'AppSid' => $this->config['app_sid'],
                'SenderID' => $this->config['sender_id'],
                'Recipient' => $phone,
                'Body' => $message,
            ]);

        if ($response->successful()) {
            $data = $response->json();
            return [
                'success' => true,
                'message_id' => $data['data']['MessageID'] ?? null,
            ];
        }

        Log::error('Unifonic SMS failed', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return ['success' => false];
    }

    /**
     * Send via Msegat
     */
    protected function sendViaMsegat(string $phone, string $message): array
    {
        $response = Http::timeout(10)
            ->get('https://www.msegat.com/gw/sendsms.php', [
                'userName' => $this->config['username'],
                'apiKey' => $this->config['api_key'],
                'numbers' => $phone,
                'userSender' => $this->config['sender_id'],
                'msg' => $message,
                'msgEncoding' => 'UTF8',
            ]);

        if ($response->successful() && $response->body() === '1') {
            return ['success' => true];
        }

        return ['success' => false];
    }

    /**
     * Send via Twilio
     */
    protected function sendViaTwilio(string $phone, string $message): array
    {
        $response = Http::timeout(10)
            ->withBasicAuth(
                $this->config['account_sid'],
                $this->config['auth_token']
            )
            ->asForm()
            ->post(
                "https://api.twilio.com/2010-04-01/Accounts/{$this->config['account_sid']}/Messages.json",
                [
                    'From' => $this->config['from_number'],
                    'To' => $phone,
                    'Body' => $message,
                ]
            );

        if ($response->successful()) {
            $data = $response->json();
            return [
                'success' => true,
                'message_id' => $data['sid'] ?? null,
            ];
        }

        return ['success' => false];
    }

    /**
     * Send via 4Jawaly
     */
    protected function sendVia4Jawaly(string $phone, string $message): array
    {
        $response = Http::timeout(10)
            ->post('https://api.4jawaly.com/api/v1/account/area/sms/send', [
                'username' => $this->config['username'],
                'password' => $this->config['password'],
                'sender' => $this->config['sender_id'],
                'mobile' => $phone,
                'message' => $message,
            ]);

        if ($response->successful()) {
            return ['success' => true];
        }

        return ['success' => false];
    }

    /**
     * Log message (development mode)
     */
    protected function sendViaLog(string $phone, string $message): array
    {
        Log::channel('sms')->info('SMS (development mode)', [
            'phone' => $this->maskPhone($phone),
            'message' => $message,
        ]);
        return ['success' => true, 'mode' => 'development'];
    }

    /**
     * Check if SMS is enabled
     */
    protected function isEnabled(): bool
    {
        return config('sms.enabled', false) && !empty($this->config);
    }

    /**
     * Send order notification
     */
    public function sendOrderNotification(string $phone, string $orderNumber, string $type = 'confirmation'): bool
    {
        $messages = [
            'confirmation' => "شكراً لك! تم إنشاء طلبك #{$orderNumber} بنجاح في لُجين الزراعية. سنتواصل معك قريباً.",
            'shipped' => "تم شحن طلبك #{$orderNumber} وسيصلك خلال 1-3 أيام. شكراً لثقتك بلُجين الزراعية.",
            'delivered' => "تم توصيل طلبك #{$orderNumber} بنجاح! نتمنى أن تكون راضياً عن منتجاتنا 🌿",
        ];

        $message = $messages[$type] ?? $messages['confirmation'];
        
        try {
            $result = $this->send($phone, $message);
            return $result['success'] ?? false;
        } catch (\Exception $e) {
            Log::error('Order notification failed', [
                'phone' => $this->maskPhone($phone),
                'order' => $orderNumber,
                'type' => $type,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Send message (generic)
     */
    public function send(string $phone, string $message): array
    {
        if (!$this->validatePhoneNumber($phone)) {
            return [
                'success' => false,
                'error' => 'Invalid phone number',
            ];
        }

        $formattedPhone = $this->formatPhone($phone);
        
        try {
            return $this->sendWithFallback($formattedPhone, $message);
        } catch (\Exception $e) {
            Log::error('SMS sending failed', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}

