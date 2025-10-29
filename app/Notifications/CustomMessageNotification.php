<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $locale = app()->getLocale();
        
        return (new MailMessage)
            ->subject($locale === 'ar' ? 'رسالة من لُجين الزراعية' : 'Message from Lujain Agricultural')
            ->greeting($locale === 'ar' ? "مرحباً {$notifiable->name}!" : "Hello {$notifiable->name}!")
            ->line($this->message)
            ->line($locale === 'ar' ? 'شكراً لك! 🌿' : 'Thank you! 🌿');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => $this->message,
        ];
    }
}

