<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceGeneratedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Invoice $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $locale = app()->getLocale();

        return (new MailMessage)
            ->subject($locale === 'ar' ? 'فاتورتك جاهزة 📄' : 'Your Invoice is Ready 📄')
            ->greeting($locale === 'ar' ? "مرحباً {$notifiable->name}!" : "Hello {$notifiable->name}!")
            ->line($locale === 'ar'
                ? "تم إنشاء فاتورة لطلبك رقم #{$this->invoice->order->order_number}"
                : "An invoice has been generated for your order #{$this->invoice->order->order_number}"
            )
            ->line($locale === 'ar' ? "رقم الفاتورة: {$this->invoice->invoice_number}" : "Invoice Number: {$this->invoice->invoice_number}")
            ->line($locale === 'ar' ? "المبلغ: {$this->invoice->total_amount} ر.س" : "Amount: {$this->invoice->total_amount} SAR")
            ->action($locale === 'ar' ? 'عرض الفاتورة' : 'View Invoice', url("/invoices/{$this->invoice->id}"))
            ->line($locale === 'ar' ? 'شكراً لك! 🌿' : 'Thank you! 🌿');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'invoice_id' => $this->invoice->id,
            'invoice_number' => $this->invoice->invoice_number,
            'order_number' => $this->invoice->order->order_number,
            'amount' => $this->invoice->total_amount,
            'message_ar' => "تم إنشاء فاتورة رقم {$this->invoice->invoice_number}",
            'message_en' => "Invoice #{$this->invoice->invoice_number} has been generated",
        ];
    }
}

