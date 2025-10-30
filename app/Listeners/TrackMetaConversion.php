<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Events\PaymentCompleted;
use App\Services\MetaPixelService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * تتبع التحويلات على Meta (Facebook/Instagram)
 * 
 * ملاحظة: هذا listener غير حرج (non-critical)
 * إذا فشل Meta Pixel API، نسجل الخطأ لكن لا نفشل الـ job
 */
class TrackMetaConversion implements ShouldQueue
{
    use InteractsWithQueue;

    protected MetaPixelService $metaPixelService;

    /**
     * عدد مرات إعادة المحاولة (قليلة لأنها non-critical)
     */
    public $tries = 2;

    /**
     * الوقت الأقصى لتنفيذ الـ job (بالثواني)
     */
    public $timeout = 30;

    /**
     * Queue priority (low because non-critical)
     */
    public $queue = 'low';

    public function __construct(MetaPixelService $metaPixelService)
    {
        $this->metaPixelService = $metaPixelService;
    }

    public function handle(OrderCreated|PaymentCompleted $event): void
    {
        try {
            $order = $event->order;

            // إرسال حدث الشراء إلى Meta
            if ($event instanceof PaymentCompleted) {
                $this->metaPixelService->trackPurchase($order);
            } else {
                $this->metaPixelService->trackInitiateCheckout($order);
            }

            // تحديث بيانات العميل في Meta
            $this->metaPixelService->updateCustomerData($order->user);
        } catch (\Exception $e) {
            // Log error but DON'T fail the job (non-critical tracking)
            \Log::warning('Meta Pixel tracking failed', [
                'order_id' => $event->order->id,
                'event_type' => get_class($event),
                'error' => $e->getMessage(),
            ]);

            // لا نُعيد رمي الخطأ - نسمح للـ job بالنجاح حتى لو فشل Meta
        }
    }

    /**
     * معالجة فشل الـ job بشكل نهائي
     */
    public function failed(OrderCreated|PaymentCompleted $event, \Throwable $exception): void
    {
        \Log::warning('Meta Pixel tracking permanently failed', [
            'order_id' => $event->order->id,
            'event_type' => get_class($event),
            'error' => $exception->getMessage(),
        ]);
    }
}

