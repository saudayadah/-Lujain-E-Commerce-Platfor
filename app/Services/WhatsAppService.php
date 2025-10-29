<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * WhatsApp Service - دعم متعدد لمقدمي خدمة واتساب
 * يدعم: Twilio, WhatsApp Business API, WATI, Ultramsg
 */
class WhatsAppService
{
    protected string $provider;
    protected array $config;

    public function __construct()
    {
        $this->provider = config('services.whatsapp.provider', 'ultramsg');
        $this->config = config("services.whatsapp.{$this->provider}", []);
    }

    /**
     * إرسال رسالة واتساب
     */
    public function send(string $phone, string $message): bool
    {
        if (!$this->isEnabled()) {
            Log::info("WhatsApp disabled. Message to {$phone}: {$message}");
            return true;
        }

        try {
            return match($this->provider) {
                'ultramsg' => $this->sendViaUltramsg($phone, $message),
                'twilio' => $this->sendViaTwilio($phone, $message),
                'wati' => $this->sendViaWati($phone, $message),
                'whatsapp_business' => $this->sendViaBusinessAPI($phone, $message),
                default => $this->sendViaLog($phone, $message),
            };
        } catch (\Exception $e) {
            Log::error('WhatsApp sending failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * إرسال رسالة مع قالب (Template)
     */
    public function sendTemplate(string $phone, string $templateName, array $params = []): bool
    {
        if (!$this->isEnabled()) {
            Log::info("WhatsApp template disabled. Template {$templateName} to {$phone}");
            return true;
        }

        try {
            return match($this->provider) {
                'ultramsg' => $this->sendTemplateViaUltramsg($phone, $templateName, $params),
                'twilio' => $this->sendTemplateViaTwilio($phone, $templateName, $params),
                'wati' => $this->sendTemplateViaWati($phone, $templateName, $params),
                'whatsapp_business' => $this->sendTemplateViaBusinessAPI($phone, $templateName, $params),
                default => false,
            };
        } catch (\Exception $e) {
            Log::error('WhatsApp template sending failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Ultramsg Provider
     */
    protected function sendViaUltramsg(string $phone, string $message): bool
    {
        $phone = $this->formatPhone($phone);
        $instanceId = $this->config['instance_id'];
        $token = $this->config['token'];

        $response = Http::post("https://api.ultramsg.com/{$instanceId}/messages/chat", [
            'token' => $token,
            'to' => $phone,
            'body' => $message,
        ]);

        return $response->successful();
    }

    protected function sendTemplateViaUltramsg(string $phone, string $templateName, array $params): bool
    {
        // Ultramsg doesn't support templates, send as regular message
        $message = $this->buildTemplateMessage($templateName, $params);
        return $this->sendViaUltramsg($phone, $message);
    }

    /**
     * Twilio WhatsApp Provider
     */
    protected function sendViaTwilio(string $phone, string $message): bool
    {
        $phone = $this->formatPhone($phone, '+');
        
        $response = Http::withBasicAuth(
            $this->config['account_sid'],
            $this->config['auth_token']
        )->asForm()->post(
            "https://api.twilio.com/2010-04-01/Accounts/{$this->config['account_sid']}/Messages.json",
            [
                'From' => 'whatsapp:' . $this->config['from_number'],
                'To' => 'whatsapp:' . $phone,
                'Body' => $message,
            ]
        );

        return $response->successful();
    }

    protected function sendTemplateViaTwilio(string $phone, string $templateName, array $params): bool
    {
        $phone = $this->formatPhone($phone, '+');
        
        $response = Http::withBasicAuth(
            $this->config['account_sid'],
            $this->config['auth_token']
        )->asForm()->post(
            "https://api.twilio.com/2010-04-01/Accounts/{$this->config['account_sid']}/Messages.json",
            [
                'From' => 'whatsapp:' . $this->config['from_number'],
                'To' => 'whatsapp:' . $phone,
                'ContentSid' => $templateName,
                'ContentVariables' => json_encode($params),
            ]
        );

        return $response->successful();
    }

    /**
     * WATI Provider
     */
    protected function sendViaWati(string $phone, string $message): bool
    {
        $phone = $this->formatPhone($phone);
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->config['api_key'],
        ])->post($this->config['api_url'] . '/api/v1/sendSessionMessage/' . $phone, [
            'messageText' => $message,
        ]);

        return $response->successful();
    }

    protected function sendTemplateViaWati(string $phone, string $templateName, array $params): bool
    {
        $phone = $this->formatPhone($phone);
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->config['api_key'],
        ])->post($this->config['api_url'] . '/api/v1/sendTemplateMessage', [
            'whatsappNumber' => $phone,
            'template_name' => $templateName,
            'broadcast_name' => 'order_notification',
            'parameters' => array_map(fn($value) => ['name' => $value['name'], 'value' => $value['value']], $params),
        ]);

        return $response->successful();
    }

    /**
     * WhatsApp Business API
     */
    protected function sendViaBusinessAPI(string $phone, string $message): bool
    {
        $phone = $this->formatPhone($phone);
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->config['access_token'],
        ])->post($this->config['api_url'] . '/' . $this->config['phone_number_id'] . '/messages', [
            'messaging_product' => 'whatsapp',
            'to' => $phone,
            'type' => 'text',
            'text' => [
                'body' => $message,
            ],
        ]);

        return $response->successful();
    }

    protected function sendTemplateViaBusinessAPI(string $phone, string $templateName, array $params): bool
    {
        $phone = $this->formatPhone($phone);
        
        $components = [];
        if (!empty($params)) {
            $components[] = [
                'type' => 'body',
                'parameters' => array_map(fn($value) => [
                    'type' => 'text',
                    'text' => $value,
                ], array_values($params)),
            ];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->config['access_token'],
        ])->post($this->config['api_url'] . '/' . $this->config['phone_number_id'] . '/messages', [
            'messaging_product' => 'whatsapp',
            'to' => $phone,
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => [
                    'code' => $this->config['language'] ?? 'ar',
                ],
                'components' => $components,
            ],
        ]);

        return $response->successful();
    }

    /**
     * Log Provider (للتطوير)
     */
    protected function sendViaLog(string $phone, string $message): bool
    {
        Log::info("WhatsApp to {$phone}: {$message}");
        return true;
    }

    /**
     * بناء رسالة من قالب
     */
    protected function buildTemplateMessage(string $templateName, array $params): string
    {
        $templates = [
            'order_created' => "مرحباً {{customer_name}}! 🎉\n\nتم إنشاء طلبك بنجاح\n\nرقم الطلب: {{order_number}}\nالمبلغ الإجمالي: {{total}} ر.س\n\nشكراً لثقتك بنا! 🌿",
            'order_confirmed' => "مرحباً {{customer_name}}! ✅\n\nتم تأكيد طلبك رقم {{order_number}}\n\nجاري تجهيز طلبك للشحن.\n\nشكراً لك! 🌿",
            'order_shipped' => "مرحباً {{customer_name}}! 📦\n\nتم شحن طلبك رقم {{order_number}}\n\nسيصلك خلال 1-3 أيام عمل.\n\nتتبع الشحنة: {{tracking_url}}\n\nشكراً لثقتك بنا! 🌿",
            'order_delivered' => "مرحباً {{customer_name}}! 🎉\n\nتم توصيل طلبك رقم {{order_number}} بنجاح!\n\nنتمنى أن تكون راضياً عن منتجاتنا.\n\nتقييمك يهمنا: {{review_url}}\n\nشكراً لك! 🌿",
            'payment_received' => "مرحباً {{customer_name}}! 💳\n\nتم استلام دفعتك بنجاح\n\nرقم الطلب: {{order_number}}\nالمبلغ: {{amount}} ر.س\n\nشكراً لك! 🌿",
        ];

        $message = $templates[$templateName] ?? $templateName;
        
        foreach ($params as $key => $value) {
            $message = str_replace('{{' . $key . '}}', $value, $message);
        }
        
        return $message;
    }

    /**
     * تنسيق رقم الهاتف
     */
    protected function formatPhone(string $phone, string $prefix = ''): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (substr($phone, 0, 1) === '0') {
            $phone = substr($phone, 1);
        }
        
        if (substr($phone, 0, 3) !== '966') {
            $phone = '966' . $phone;
        }
        
        return $prefix . $phone;
    }

    /**
     * التحقق من تفعيل الخدمة
     */
    protected function isEnabled(): bool
    {
        return config('services.whatsapp.enabled', false) && !empty($this->config);
    }

    // رسائل سريعة للطلبات
    public function sendOrderCreated(string $phone, string $customerName, string $orderNumber, float $total): bool
    {
        return $this->sendTemplate($phone, 'order_created', [
            'customer_name' => $customerName,
            'order_number' => $orderNumber,
            'total' => number_format($total, 2),
        ]);
    }

    public function sendOrderConfirmed(string $phone, string $customerName, string $orderNumber): bool
    {
        return $this->sendTemplate($phone, 'order_confirmed', [
            'customer_name' => $customerName,
            'order_number' => $orderNumber,
        ]);
    }

    public function sendOrderShipped(string $phone, string $customerName, string $orderNumber, string $trackingUrl = ''): bool
    {
        return $this->sendTemplate($phone, 'order_shipped', [
            'customer_name' => $customerName,
            'order_number' => $orderNumber,
            'tracking_url' => $trackingUrl ?: 'سيتم إرساله قريباً',
        ]);
    }

    public function sendOrderDelivered(string $phone, string $customerName, string $orderNumber, string $reviewUrl = ''): bool
    {
        return $this->sendTemplate($phone, 'order_delivered', [
            'customer_name' => $customerName,
            'order_number' => $orderNumber,
            'review_url' => $reviewUrl ?: url('/reviews'),
        ]);
    }

    public function sendPaymentReceived(string $phone, string $customerName, string $orderNumber, float $amount): bool
    {
        return $this->sendTemplate($phone, 'payment_received', [
            'customer_name' => $customerName,
            'order_number' => $orderNumber,
            'amount' => number_format($amount, 2),
        ]);
    }
}

