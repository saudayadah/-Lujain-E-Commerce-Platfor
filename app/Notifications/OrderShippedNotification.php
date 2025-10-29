<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderShippedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Order $order;
    public string $trackingUrl;

    public function __construct(Order $order, string $trackingUrl = '')
    {
        $this->order = $order;
        $this->trackingUrl = $trackingUrl;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $locale = app()->getLocale();
        
        $mail = (new MailMessage)
            ->subject($locale === 'ar' ? 'تم شحن طلبك 📦' : 'Your Order Has Been Shipped 📦')
            ->greeting($locale === 'ar' ? "مرحباً {$notifiable->name}!" : "Hello {$notifiable->name}!")
            ->line($locale === 'ar' 
                ? "تم شحن طلبك رقم #{$this->order->order_number}!"
                : "Your order #{$this->order->order_number} has been shipped!"
            )
            ->line($locale === 'ar' 
                ? "سيصل طلبك خلال 1-3 أيام عمل."
                : "Your order will arrive within 1-3 business days."
            );

        if ($this->trackingUrl) {
            $mail->action($locale === 'ar' ? 'تتبع الشحنة' : 'Track Shipment', $this->trackingUrl);
        } else {
            $mail->action($locale === 'ar' ? 'عرض الطلب' : 'View Order', url("/orders/{$this->order->id}"));
        }

        return $mail->line($locale === 'ar' ? 'شكراً لثقتك بنا! 🌿' : 'Thank you for your trust! 🌿');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'tracking_url' => $this->trackingUrl,
            'message_ar' => "تم شحن طلبك #{$this->order->order_number}",
            'message_en' => "Your order #{$this->order->order_number} has been shipped",
        ];
    }
}

