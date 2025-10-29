<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $locale = app()->getLocale();
        
        return (new MailMessage)
            ->subject($locale === 'ar' ? 'تم تأكيد طلبك ✅' : 'Your Order Has Been Confirmed ✅')
            ->greeting($locale === 'ar' ? "مرحباً {$notifiable->name}!" : "Hello {$notifiable->name}!")
            ->line($locale === 'ar' 
                ? "تم تأكيد طلبك رقم #{$this->order->order_number} بنجاح!"
                : "Your order #{$this->order->order_number} has been confirmed!"
            )
            ->line($locale === 'ar' 
                ? "جاري تجهيز طلبك للشحن. سنقوم بإرسال إشعار آخر عند الشحن."
                : "We're preparing your order for shipment. You'll receive another notification when it ships."
            )
            ->action($locale === 'ar' ? 'تتبع الطلب' : 'Track Order', url("/orders/{$this->order->id}"))
            ->line($locale === 'ar' ? 'شكراً لثقتك بنا! 🌿' : 'Thank you for your trust! 🌿');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'message_ar' => "تم تأكيد طلبك #{$this->order->order_number}",
            'message_en' => "Your order #{$this->order->order_number} has been confirmed",
        ];
    }
}

