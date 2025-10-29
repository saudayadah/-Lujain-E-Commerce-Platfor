<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderDeliveredNotification extends Notification implements ShouldQueue
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
            ->subject($locale === 'ar' ? 'تم توصيل طلبك 🎉' : 'Your Order Has Been Delivered 🎉')
            ->greeting($locale === 'ar' ? "مرحباً {$notifiable->name}!" : "Hello {$notifiable->name}!")
            ->line($locale === 'ar' 
                ? "تم توصيل طلبك رقم #{$this->order->order_number} بنجاح!"
                : "Your order #{$this->order->order_number} has been delivered successfully!"
            )
            ->line($locale === 'ar' 
                ? "نتمنى أن تكون راضياً عن منتجاتنا."
                : "We hope you're satisfied with our products."
            )
            ->action($locale === 'ar' ? 'تقييم المنتج' : 'Rate Product', url("/orders/{$this->order->id}/review"))
            ->line($locale === 'ar' ? 'شكراً لثقتك بنا! نتطلع لخدمتك مجدداً 🌿' : 'Thank you for your trust! We look forward to serving you again 🌿');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'message_ar' => "تم توصيل طلبك #{$this->order->order_number} بنجاح",
            'message_en' => "Your order #{$this->order->order_number} has been delivered successfully",
        ];
    }
}

