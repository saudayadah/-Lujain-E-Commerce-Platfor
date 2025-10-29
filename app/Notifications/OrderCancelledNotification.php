<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCancelledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Order $order;
    public string $reason;

    public function __construct(Order $order, string $reason = '')
    {
        $this->order = $order;
        $this->reason = $reason;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $locale = app()->getLocale();
        
        $mail = (new MailMessage)
            ->subject($locale === 'ar' ? 'تم إلغاء طلبك' : 'Your Order Has Been Cancelled')
            ->greeting($locale === 'ar' ? "مرحباً {$notifiable->name}" : "Hello {$notifiable->name}")
            ->line($locale === 'ar' 
                ? "تم إلغاء طلبك رقم #{$this->order->order_number}."
                : "Your order #{$this->order->order_number} has been cancelled."
            );

        if ($this->reason) {
            $mail->line($locale === 'ar' ? "السبب: {$this->reason}" : "Reason: {$this->reason}");
        }

        if ($this->order->payment_status === 'paid') {
            $mail->line($locale === 'ar' 
                ? "سيتم استرجاع المبلغ ({$this->order->total} ر.س) خلال 5-7 أيام عمل."
                : "The amount ({$this->order->total} SAR) will be refunded within 5-7 business days."
            );
        }

        return $mail
            ->action($locale === 'ar' ? 'عرض الطلب' : 'View Order', url("/orders/{$this->order->id}"))
            ->line($locale === 'ar' ? 'نعتذر عن أي إزعاج.' : 'We apologize for any inconvenience.');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'reason' => $this->reason,
            'message_ar' => "تم إلغاء طلبك #{$this->order->order_number}",
            'message_en' => "Your order #{$this->order->order_number} has been cancelled",
        ];
    }
}

