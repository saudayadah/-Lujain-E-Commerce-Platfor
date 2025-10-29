<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceivedNotification extends Notification implements ShouldQueue
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
            ->subject($locale === 'ar' ? 'تم استلام دفعتك بنجاح 💳' : 'Payment Received Successfully 💳')
            ->greeting($locale === 'ar' ? "مرحباً {$notifiable->name}!" : "Hello {$notifiable->name}!")
            ->line($locale === 'ar' 
                ? "تم استلام دفعتك للطلب رقم #{$this->order->order_number} بنجاح!"
                : "We've successfully received your payment for order #{$this->order->order_number}!"
            )
            ->line($locale === 'ar' ? "المبلغ: {$this->order->total} ر.س" : "Amount: {$this->order->total} SAR")
            ->line($locale === 'ar' ? "طريقة الدفع: {$this->getPaymentMethodName()}" : "Payment Method: {$this->getPaymentMethodName()}")
            ->action($locale === 'ar' ? 'عرض الفاتورة' : 'View Invoice', url("/orders/{$this->order->id}/invoice"))
            ->line($locale === 'ar' ? 'شكراً لك! 🌿' : 'Thank you! 🌿');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'amount' => $this->order->total,
            'message_ar' => "تم استلام دفعتك للطلب #{$this->order->order_number}",
            'message_en' => "Payment received for order #{$this->order->order_number}",
        ];
    }

    protected function getPaymentMethodName(): string
    {
        $locale = app()->getLocale();
        $methods = [
            'creditcard' => $locale === 'ar' ? 'بطاقة ائتمانية' : 'Credit Card',
            'moyasar' => $locale === 'ar' ? 'بطاقة ائتمانية' : 'Credit Card',
            'cod' => $locale === 'ar' ? 'الدفع عند الاستلام' : 'Cash on Delivery',
            'stcpay' => 'STC Pay',
            'applepay' => 'Apple Pay',
        ];

        return $methods[$this->order->payment_method] ?? $this->order->payment_method;
    }
}

