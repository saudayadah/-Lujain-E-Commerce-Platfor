<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * خدمة الإشعارات الموحدة
 * تجمع بين SMS، Email، WhatsApp
 */
class NotificationService
{
    protected SmsService $smsService;
    protected WhatsAppService $whatsAppService;

    public function __construct(SmsService $smsService, WhatsAppService $whatsAppService)
    {
        $this->smsService = $smsService;
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * إشعار إنشاء طلب جديد
     */
    public function notifyOrderCreated(Order $order): void
    {
        try {
            $user = $order->user;
            $phone = $user->phone ?? null;

            // إرسال عبر WhatsApp (الأولوية)
            if ($phone && config('services.whatsapp.enabled')) {
                $this->whatsAppService->sendOrderCreated(
                    $phone,
                    $user->name,
                    $order->order_number,
                    $order->total
                );
            }
            // احتياطي: إرسال SMS
            elseif ($phone && config('sms.enabled')) {
                $this->smsService->sendOrderConfirmation($phone, $order->order_number);
            }

            // إرسال البريد الإلكتروني دائماً
            if ($user->email) {
                $user->notify(new \App\Notifications\OrderCreatedNotification($order));
            }

            Log::info("Order created notification sent for order #{$order->order_number}");
        } catch (\Exception $e) {
            Log::error("Failed to send order created notification: " . $e->getMessage());
        }
    }

    /**
     * إشعار تأكيد الطلب
     */
    public function notifyOrderConfirmed(Order $order): void
    {
        try {
            $user = $order->user;
            $phone = $user->phone ?? null;

            if ($phone && config('services.whatsapp.enabled')) {
                $this->whatsAppService->sendOrderConfirmed(
                    $phone,
                    $user->name,
                    $order->order_number
                );
            } elseif ($phone && config('sms.enabled')) {
                $message = "تم تأكيد طلبك #{$order->order_number} بنجاح! جاري تجهيزه للشحن.";
                $this->smsService->send($phone, $message);
            }

            if ($user->email) {
                $user->notify(new \App\Notifications\OrderConfirmedNotification($order));
            }

            Log::info("Order confirmed notification sent for order #{$order->order_number}");
        } catch (\Exception $e) {
            Log::error("Failed to send order confirmed notification: " . $e->getMessage());
        }
    }

    /**
     * إشعار شحن الطلب
     */
    public function notifyOrderShipped(Order $order, string $trackingUrl = ''): void
    {
        try {
            $user = $order->user;
            $phone = $user->phone ?? null;

            if ($phone && config('services.whatsapp.enabled')) {
                $this->whatsAppService->sendOrderShipped(
                    $phone,
                    $user->name,
                    $order->order_number,
                    $trackingUrl
                );
            } elseif ($phone && config('sms.enabled')) {
                $this->smsService->sendOrderShipped($phone, $order->order_number);
            }

            if ($user->email) {
                $user->notify(new \App\Notifications\OrderShippedNotification($order, $trackingUrl));
            }

            Log::info("Order shipped notification sent for order #{$order->order_number}");
        } catch (\Exception $e) {
            Log::error("Failed to send order shipped notification: " . $e->getMessage());
        }
    }

    /**
     * إشعار توصيل الطلب
     */
    public function notifyOrderDelivered(Order $order): void
    {
        try {
            $user = $order->user;
            $phone = $user->phone ?? null;

            if ($phone && config('services.whatsapp.enabled')) {
                $this->whatsAppService->sendOrderDelivered(
                    $phone,
                    $user->name,
                    $order->order_number
                );
            } elseif ($phone && config('sms.enabled')) {
                $this->smsService->sendOrderDelivered($phone, $order->order_number);
            }

            if ($user->email) {
                $user->notify(new \App\Notifications\OrderDeliveredNotification($order));
            }

            Log::info("Order delivered notification sent for order #{$order->order_number}");
        } catch (\Exception $e) {
            Log::error("Failed to send order delivered notification: " . $e->getMessage());
        }
    }

    /**
     * إشعار استلام الدفع
     */
    public function notifyPaymentReceived(Order $order): void
    {
        try {
            $user = $order->user;
            $phone = $user->phone ?? null;

            if ($phone && config('services.whatsapp.enabled')) {
                $this->whatsAppService->sendPaymentReceived(
                    $phone,
                    $user->name,
                    $order->order_number,
                    $order->total
                );
            } elseif ($phone && config('sms.enabled')) {
                $message = "تم استلام دفعتك بنجاح للطلب #{$order->order_number} - المبلغ: {$order->total} ر.س";
                $this->smsService->send($phone, $message);
            }

            if ($user->email) {
                $user->notify(new \App\Notifications\PaymentReceivedNotification($order));
            }

            Log::info("Payment received notification sent for order #{$order->order_number}");
        } catch (\Exception $e) {
            Log::error("Failed to send payment received notification: " . $e->getMessage());
        }
    }

    /**
     * إشعار إلغاء الطلب
     */
    public function notifyOrderCancelled(Order $order, string $reason = ''): void
    {
        try {
            $user = $order->user;
            $phone = $user->phone ?? null;

            $message = "تم إلغاء طلبك #{$order->order_number}";
            if ($reason) {
                $message .= "\nالسبب: {$reason}";
            }

            if ($phone && config('services.whatsapp.enabled')) {
                $this->whatsAppService->send($phone, $message);
            } elseif ($phone && config('sms.enabled')) {
                $this->smsService->send($phone, $message);
            }

            if ($user->email) {
                $user->notify(new \App\Notifications\OrderCancelledNotification($order, $reason));
            }

            Log::info("Order cancelled notification sent for order #{$order->order_number}");
        } catch (\Exception $e) {
            Log::error("Failed to send order cancelled notification: " . $e->getMessage());
        }
    }

    /**
     * إرسال رسالة مخصصة
     */
    public function sendCustomMessage(User $user, string $message, array $channels = ['whatsapp', 'sms', 'email']): void
    {
        try {
            $phone = $user->phone ?? null;

            if (in_array('whatsapp', $channels) && $phone && config('services.whatsapp.enabled')) {
                $this->whatsAppService->send($phone, $message);
            }

            if (in_array('sms', $channels) && $phone && config('sms.enabled')) {
                $this->smsService->send($phone, $message);
            }

            if (in_array('email', $channels) && $user->email) {
                $user->notify(new \App\Notifications\CustomMessageNotification($message));
            }

            Log::info("Custom message sent to user #{$user->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send custom message: " . $e->getMessage());
        }
    }
}

