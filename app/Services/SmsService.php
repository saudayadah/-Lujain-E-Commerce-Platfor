<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected string $provider;
    protected array $config;

    public function __construct()
    {
        $this->provider = config('sms.default_provider', 'unifonic');
        $this->config = config("sms.providers.{$this->provider}", []);
    }

    public function sendOTP(string $phone, string $code): bool
    {
        $message = "كود التحقق الخاص بك في لُجين الزراعية هو: {$code}\nصالح لمدة 5 دقائق";
        
        return $this->send($phone, $message);
    }

    public function send(string $phone, string $message): bool
    {
        if (!$this->isEnabled()) {
            Log::info("SMS disabled. Message to {$phone}: {$message}");
            return true; // في وضع التطوير
        }

        try {
            return match($this->provider) {
                'unifonic' => $this->sendViaUnifo($phone, $message),
                'msegat' => $this->sendViaMsegat($phone, $message),
                'twilio' => $this->sendViaTwilio($phone, $message),
                '4jawaly' => $this->sendVia4Jawaly($phone, $message),
                default => $this->sendViaLog($phone, $message),
            };
        } catch (\Exception $e) {
            Log::error('SMS sending failed: ' . $e->getMessage());
            return false;
        }
    }

    protected function sendViaUnifo(string $phone, string $message): bool
    {
        $phone = $this->formatPhone($phone);
        
        $response = Http::post('https://el.cloud.unifonic.com/rest/SMS/messages', [
            'AppSid' => $this->config['app_sid'],
            'SenderID' => $this->config['sender_id'],
            'Recipient' => $phone,
            'Body' => $message,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return isset($data['success']) && $data['success'] === true;
        }

        Log::error('Unifonic SMS failed: ' . $response->body());
        return false;
    }

    protected function sendViaMsegat(string $phone, string $message): bool
    {
        $phone = $this->formatPhone($phone);
        
        $response = Http::get('https://www.msegat.com/gw/sendsms.php', [
            'userName' => $this->config['username'],
            'apiKey' => $this->config['api_key'],
            'numbers' => $phone,
            'userSender' => $this->config['sender_id'],
            'msg' => $message,
            'msgEncoding' => 'UTF8',
        ]);

        return $response->successful() && $response->body() === '1';
    }

    protected function sendViaTwilio(string $phone, string $message): bool
    {
        $phone = $this->formatPhone($phone, '+');
        
        $response = Http::withBasicAuth(
            $this->config['account_sid'],
            $this->config['auth_token']
        )->asForm()->post(
            "https://api.twilio.com/2010-04-01/Accounts/{$this->config['account_sid']}/Messages.json",
            [
                'From' => $this->config['from_number'],
                'To' => $phone,
                'Body' => $message,
            ]
        );

        return $response->successful();
    }

    protected function sendVia4Jawaly(string $phone, string $message): bool
    {
        $phone = $this->formatPhone($phone);
        
        $response = Http::post('https://api.4jawaly.com/api/v1/account/area/sms/send', [
            'username' => $this->config['username'],
            'password' => $this->config['password'],
            'sender' => $this->config['sender_id'],
            'mobile' => $phone,
            'message' => $message,
        ]);

        return $response->successful();
    }

    protected function sendViaLog(string $phone, string $message): bool
    {
        Log::info("SMS to {$phone}: {$message}");
        return true;
    }

    protected function formatPhone(string $phone, string $prefix = ''): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If starts with 0, remove it
        if (substr($phone, 0, 1) === '0') {
            $phone = substr($phone, 1);
        }
        
        // If doesn't start with country code, add 966
        if (substr($phone, 0, 3) !== '966') {
            $phone = '966' . $phone;
        }
        
        return $prefix . $phone;
    }

    protected function isEnabled(): bool
    {
        return config('sms.enabled', false) && !empty($this->config);
    }

    public function sendOrderConfirmation(string $phone, string $orderNumber): bool
    {
        $message = "شكراً لك! تم إنشاء طلبك #{$orderNumber} بنجاح في لُجين الزراعية. سنتواصل معك قريباً.";
        return $this->send($phone, $message);
    }

    public function sendOrderShipped(string $phone, string $orderNumber): bool
    {
        $message = "تم شحن طلبك #{$orderNumber} وسيصلك خلال 1-3 أيام. شكراً لثقتك بلُجين الزراعية.";
        return $this->send($phone, $message);
    }

    public function sendOrderDelivered(string $phone, string $orderNumber): bool
    {
        $message = "تم توصيل طلبك #{$orderNumber} بنجاح! نتمنى أن تكون راضياً عن منتجاتنا 🌿";
        return $this->send($phone, $message);
    }
}

