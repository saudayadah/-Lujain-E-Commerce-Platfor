<?php

namespace App\Listeners;

use App\Events\PaymentCompleted;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPaymentNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(PaymentCompleted $event): void
    {
        $this->notificationService->notifyPaymentReceived($event->order);
    }
}

