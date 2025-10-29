<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderStatusNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(OrderStatusUpdated $event): void
    {
        match ($event->newStatus) {
            'confirmed' => $this->notificationService->notifyOrderConfirmed($event->order),
            'shipped' => $this->notificationService->notifyOrderShipped($event->order),
            'delivered' => $this->notificationService->notifyOrderDelivered($event->order),
            'cancelled' => $this->notificationService->notifyOrderCancelled($event->order),
            default => null,
        };
    }
}

