<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Events\PaymentCompleted;
use App\Services\MetaPixelService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * تتبع التحويلات على Meta (Facebook/Instagram)
 */
class TrackMetaConversion implements ShouldQueue
{
    use InteractsWithQueue;

    protected MetaPixelService $metaPixelService;

    public function __construct(MetaPixelService $metaPixelService)
    {
        $this->metaPixelService = $metaPixelService;
    }

    public function handle(OrderCreated|PaymentCompleted $event): void
    {
        $order = $event->order;

        // إرسال حدث الشراء إلى Meta
        if ($event instanceof PaymentCompleted) {
            $this->metaPixelService->trackPurchase($order);
        } else {
            $this->metaPixelService->trackInitiateCheckout($order);
        }

        // تحديث بيانات العميل في Meta
        $this->metaPixelService->updateCustomerData($order->user);
    }
}

