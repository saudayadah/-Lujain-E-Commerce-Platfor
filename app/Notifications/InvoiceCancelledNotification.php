<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceCancelledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Invoice $invoice;
    public string $reason;

    public function __construct(Invoice $invoice, string $reason = '')
    {
        $this->invoice = $invoice;
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
            ->subject($locale === 'ar' ? 'تم إلغاء الفاتورة' : 'Invoice Cancelled')
            ->greeting($locale === 'ar' ? "مرحباً {$notifiable->name}" : "Hello {$notifiable->name}")
            ->line($locale === 'ar'
                ? "تم إلغاء فاتورة طلبك رقم #{$this->invoice->order->order_number}"
                : "Invoice for your order #{$this->invoice->order->order_number} has been cancelled"
            )
            ->line($locale === 'ar' ? "رقم الفاتورة: {$this->invoice->invoice_number}" : "Invoice Number: {$this->invoice->invoice_number}");

        if ($this->reason) {
            $mail->line($locale === 'ar' ? "سبب الإلغاء: {$this->reason}" : "Cancellation Reason: {$this->reason}");
        }

        return $mail->line($locale === 'ar' ? 'نعتذر عن أي إزعاج.' : 'We apologize for any inconvenience.');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'invoice_id' => $this->invoice->id,
            'invoice_number' => $this->invoice->invoice_number,
            'reason' => $this->reason,
            'message_ar' => "تم إلغاء فاتورة رقم {$this->invoice->invoice_number}",
            'message_en' => "Invoice #{$this->invoice->invoice_number} has been cancelled",
        ];
    }
}

