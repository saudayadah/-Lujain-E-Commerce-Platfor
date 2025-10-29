<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification implements ShouldQueue
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
            ->subject($locale === 'ar' ? 'تم إنشاء طلبك بنجاح 🎉' : 'Your Order Has Been Created 🎉')
            ->greeting($locale === 'ar' ? "مرحباً {$notifiable->name}!" : "Hello {$notifiable->name}!")
            ->line($locale === 'ar' 
                ? "شكراً لك على طلبك! تم إنشاء الطلب رقم #{$this->order->order_number} بنجاح."
                : "Thank you for your order! Order #{$this->order->order_number} has been created successfully."
            )
            ->line($locale === 'ar' ? 'تفاصيل الطلب:' : 'Order Details:')
            ->line($locale === 'ar' ? "الإجمالي الفرعي: {$this->order->subtotal} ر.س" : "Subtotal: {$this->order->subtotal} SAR")
            ->line($locale === 'ar' ? "الضريبة: {$this->order->tax} ر.س" : "Tax: {$this->order->tax} SAR")
            ->line($locale === 'ar' ? "رسوم الشحن: {$this->order->shipping_fee} ر.س" : "Shipping: {$this->order->shipping_fee} SAR")
            ->line($locale === 'ar' ? "**المجموع الكلي: {$this->order->total} ر.س**" : "**Total: {$this->order->total} SAR**")
            ->action($locale === 'ar' ? 'عرض الطلب' : 'View Order', url("/orders/{$this->order->id}"))
            ->line($locale === 'ar' ? 'شكراً لثقتك بنا! 🌿' : 'Thank you for your trust! 🌿');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'total' => $this->order->total,
            'message_ar' => "تم إنشاء طلبك #{$this->order->order_number} بنجاح",
            'message_en' => "Your order #{$this->order->order_number} has been created successfully",
        ];
    }
}

