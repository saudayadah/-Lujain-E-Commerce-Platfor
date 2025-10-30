<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    protected NotificationService $notificationService;

    /**
     * عدد مرات إعادة المحاولة عند الفشل
     */
    public $tries = 3;

    /**
     * الوقت الأقصى لتنفيذ الـ job (بالثواني)
     */
    public $timeout = 60;

    /**
     * عدد الأخطاء المسموح بها قبل إيقاف الـ job
     */
    public $maxExceptions = 2;

    /**
     * الوقت بين المحاولات (بالثواني)
     */
    public $backoff = [10, 30, 60];

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(OrderCreated $event): void
    {
        try {
            $this->notificationService->notifyOrderCreated($event->order);
        } catch (\Exception $e) {
            \Log::error('SendOrderNotifications failed', [
                'order_id' => $event->order->id,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts(),
            ]);
            
            // إعادة رمي الخطأ للسماح بإعادة المحاولة
            throw $e;
        }
    }

    /**
     * معالجة فشل الـ job بشكل نهائي
     */
    public function failed(OrderCreated $event, \Throwable $exception): void
    {
        \Log::critical('SendOrderNotifications permanently failed', [
            'order_id' => $event->order->id,
            'order_number' => $event->order->order_number,
            'error' => $exception->getMessage(),
        ]);
    }
}

