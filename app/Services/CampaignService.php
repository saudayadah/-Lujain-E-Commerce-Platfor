<?php

namespace App\Services;

use App\Models\User;
use App\Models\Campaign;
use App\Models\CampaignTemplate;
use App\Models\CampaignCustomer;
use App\Models\CustomerSegment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use App\Jobs\SendCampaignMessage;

/**
 * خدمة الحملات التسويقية المتقدمة
 * تدعم الاستهداف الدقيق، تتبع التفاعل، والتحليلات المتقدمة
 */
class CampaignService
{
    protected NotificationService $notificationService;
    protected WhatsAppService $whatsAppService;
    protected SmsService $smsService;

    public function __construct(
        NotificationService $notificationService,
        WhatsAppService $whatsAppService,
        SmsService $smsService
    ) {
        $this->notificationService = $notificationService;
        $this->whatsAppService = $whatsAppService;
        $this->smsService = $smsService;
    }

    /**
     * إرسال حملة للعملاء المستهدفين
     */
    public function sendCampaign(
        Collection $customers,
        string $message,
        array $channels = ['whatsapp'],
        array $metadata = []
    ): array {
        $results = [
            'total' => $customers->count(),
            'sent' => 0,
            'failed' => 0,
            'details' => [],
        ];

        foreach ($customers as $customer) {
            try {
                $sent = false;

                // إرسال عبر WhatsApp
                if (in_array('whatsapp', $channels) && $customer->phone) {
                    $personalizedMessage = $this->personalizeMessage($message, $customer);
                    $sent = $this->whatsAppService->send($customer->phone, $personalizedMessage);
                }

                // إرسال عبر SMS (احتياطي أو إضافي)
                if (in_array('sms', $channels) && $customer->phone && (!$sent || in_array('both', $channels))) {
                    $personalizedMessage = $this->personalizeMessage($message, $customer);
                    $sent = $this->smsService->send($customer->phone, $personalizedMessage) || $sent;
                }

                // إرسال عبر Email
                if (in_array('email', $channels) && $customer->email) {
                    $personalizedMessage = $this->personalizeMessage($message, $customer);
                    $customer->notify(new \App\Notifications\CustomMessageNotification($personalizedMessage));
                    $sent = true;
                }

                if ($sent) {
                    $results['sent']++;
                    $results['details'][] = [
                        'customer_id' => $customer->id,
                        'status' => 'sent',
                    ];
                } else {
                    $results['failed']++;
                    $results['details'][] = [
                        'customer_id' => $customer->id,
                        'status' => 'failed',
                        'reason' => 'No valid contact method',
                    ];
                }

                // تأخير صغير لتجنب الحظر
                usleep(100000); // 0.1 ثانية
            } catch (\Exception $e) {
                $results['failed']++;
                $results['details'][] = [
                    'customer_id' => $customer->id,
                    'status' => 'failed',
                    'reason' => $e->getMessage(),
                ];
                
                Log::error("Campaign sending failed for customer #{$customer->id}: " . $e->getMessage());
            }
        }

        // حفظ الحملة في قاعدة البيانات
        if (isset($metadata['campaign_name'])) {
            $this->saveCampaign($metadata['campaign_name'], $message, $channels, $results);
        }

        return $results;
    }

    /**
     * تخصيص الرسالة للعميل
     */
    protected function personalizeMessage(string $message, User $customer): string
    {
        $replacements = [
            '{name}' => $customer->name,
            '{first_name}' => explode(' ', $customer->name)[0],
            '{email}' => $customer->email,
            '{phone}' => $customer->phone,
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $message);
    }

    /**
     * حفظ الحملة في قاعدة البيانات
     */
    protected function saveCampaign(string $name, string $message, array $channels, array $results): void
    {
        try {
            Campaign::create([
                'name' => $name,
                'message' => $message,
                'channels' => $channels,
                'total_recipients' => $results['total'],
                'sent_count' => $results['sent'],
                'failed_count' => $results['failed'],
                'status' => 'completed',
                'sent_at' => now(),
                'results' => $results,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to save campaign: " . $e->getMessage());
        }
    }

    /**
     * إرسال حملة ترويجية
     */
    public function sendPromotionalCampaign(
        Collection $customers,
        string $productName,
        float $discount,
        string $couponCode,
        array $channels = ['whatsapp']
    ): array {
        $message = "مرحباً {name}! 🎉\n\n";
        $message .= "عرض خاص لك على {$productName}\n";
        $message .= "خصم {$discount}% باستخدام الكود: {$couponCode}\n\n";
        $message .= "احصل عليه الآن من متجرنا 🌿\n";
        $message .= url('/products');

        return $this->sendCampaign($customers, $message, $channels, [
            'campaign_name' => "Promotional - {$productName}",
            'type' => 'promotional',
        ]);
    }

    /**
     * إرسال حملة لاستعادة العملاء الخاملين
     */
    public function sendWinBackCampaign(
        Collection $customers,
        float $discount = 15,
        array $channels = ['whatsapp']
    ): array {
        $message = "مرحباً {name}! 😊\n\n";
        $message .= "افتقدناك! نود أن نراك مجدداً في متجرنا.\n\n";
        $message .= "كهدية خاصة، احصل على خصم {$discount}% على طلبك القادم\n";
        $message .= "استخدم الكود: WELCOME{$discount}\n\n";
        $message .= "تسوق الآن 🌿\n";
        $message .= url('/');

        return $this->sendCampaign($customers, $message, $channels, [
            'campaign_name' => 'Win Back Campaign',
            'type' => 'win_back',
        ]);
    }

    /**
     * إرسال حملة للعملاء الجدد
     */
    public function sendWelcomeCampaign(
        Collection $customers,
        array $channels = ['whatsapp']
    ): array {
        $message = "مرحباً {name} في لُجين الزراعية! 🎉\n\n";
        $message .= "شكراً لك على طلبك الأول معنا!\n\n";
        $message .= "نحن سعداء بانضمامك لعائلتنا.\n";
        $message .= "استمتع بمنتجاتنا الطبيعية 🌿\n\n";
        $message .= "تابعنا على:\n";
        $message .= "📱 Instagram: @lujain_agricultural\n";
        $message .= "🌐 Website: " . url('/');

        return $this->sendCampaign($customers, $message, $channels, [
            'campaign_name' => 'Welcome Campaign',
            'type' => 'welcome',
        ]);
    }

    /**
     * إرسال حملة VIP للعملاء المميزين
     */
    public function sendVIPCampaign(
        Collection $customers,
        string $offer,
        array $channels = ['whatsapp']
    ): array {
        $message = "عزيزي {name} 👑\n\n";
        $message .= "كعميل VIP مميز، نقدم لك:\n\n";
        $message .= "✨ {$offer}\n\n";
        $message .= "هذا العرض حصري لك فقط!\n";
        $message .= "صالح حتى نهاية الأسبوع.\n\n";
        $message .= "شكراً لولائك 🌿\n";
        $message .= url('/vip-offers');

        return $this->sendCampaign($customers, $message, $channels, [
            'campaign_name' => 'VIP Campaign',
            'type' => 'vip',
        ]);
    }

    /**
     * إرسال تذكير بالسلة المهجورة
     */
    public function sendCartAbandonmentReminder(
        User $customer,
        array $cartItems,
        array $channels = ['whatsapp']
    ): bool {
        $message = "مرحباً {$customer->name}! 🛒\n\n";
        $message .= "لاحظنا أنك تركت بعض المنتجات في سلتك:\n\n";
        
        foreach (array_slice($cartItems, 0, 3) as $item) {
            $message .= "• {$item['name']}\n";
        }
        
        $message .= "\nلا تفوت الفرصة! أكمل طلبك الآن 🌿\n";
        $message .= url('/cart');

        try {
            if (in_array('whatsapp', $channels) && $customer->phone) {
                return $this->whatsAppService->send($customer->phone, $message);
            } elseif (in_array('sms', $channels) && $customer->phone) {
                return $this->smsService->send($customer->phone, $message);
            }
            return false;
        } catch (\Exception $e) {
            Log::error("Cart abandonment reminder failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * جدولة حملة
     */
    public function scheduleCampaign(
        string $name,
        string $segment,
        string $message,
        array $channels,
        \DateTime $scheduledAt
    ): Campaign {
        return Campaign::create([
            'name' => $name,
            'segment' => $segment,
            'message' => $message,
            'channels' => $channels,
            'status' => 'scheduled',
            'scheduled_at' => $scheduledAt,
        ]);
    }
}

