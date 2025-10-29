<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * خدمة Meta Pixel و Conversions API
 * للتكامل مع إعلانات فيسبوك وإنستجرام
 */
class MetaPixelService
{
    protected string $pixelId;
    protected string $accessToken;
    protected string $apiVersion;
    protected bool $enabled;

    public function __construct()
    {
        $this->pixelId = config('services.meta.pixel_id', '');
        $this->accessToken = config('services.meta.access_token', '');
        $this->apiVersion = config('services.meta.api_version', 'v18.0');
        $this->enabled = config('services.meta.enabled', false);
    }

    /**
     * تتبع حدث الشراء (Purchase)
     */
    public function trackPurchase(Order $order): bool
    {
        if (!$this->enabled || !$this->pixelId || !$this->accessToken) {
            Log::info("Meta Pixel disabled or not configured");
            return false;
        }

        try {
            $eventData = [
                'event_name' => 'Purchase',
                'event_time' => now()->timestamp,
                'event_source_url' => url("/orders/{$order->id}"),
                'action_source' => 'website',
                'user_data' => $this->getUserData($order->user),
                'custom_data' => [
                    'currency' => 'SAR',
                    'value' => (float) $order->total,
                    'content_type' => 'product',
                    'contents' => $this->getOrderContents($order),
                    'num_items' => $order->items->count(),
                    'order_id' => $order->order_number,
                ],
            ];

            return $this->sendEvent($eventData);
        } catch (\Exception $e) {
            Log::error("Meta Pixel trackPurchase failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تتبع بدء عملية الشراء (InitiateCheckout)
     */
    public function trackInitiateCheckout(Order $order): bool
    {
        if (!$this->enabled || !$this->pixelId || !$this->accessToken) {
            return false;
        }

        try {
            $eventData = [
                'event_name' => 'InitiateCheckout',
                'event_time' => now()->timestamp,
                'event_source_url' => url("/checkout"),
                'action_source' => 'website',
                'user_data' => $this->getUserData($order->user),
                'custom_data' => [
                    'currency' => 'SAR',
                    'value' => (float) $order->total,
                    'content_type' => 'product',
                    'contents' => $this->getOrderContents($order),
                    'num_items' => $order->items->count(),
                ],
            ];

            return $this->sendEvent($eventData);
        } catch (\Exception $e) {
            Log::error("Meta Pixel trackInitiateCheckout failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تتبع إضافة إلى السلة (AddToCart)
     */
    public function trackAddToCart(User $user, array $productData): bool
    {
        if (!$this->enabled || !$this->pixelId || !$this->accessToken) {
            return false;
        }

        try {
            $eventData = [
                'event_name' => 'AddToCart',
                'event_time' => now()->timestamp,
                'event_source_url' => url()->current(),
                'action_source' => 'website',
                'user_data' => $this->getUserData($user),
                'custom_data' => [
                    'currency' => 'SAR',
                    'value' => (float) $productData['price'],
                    'content_type' => 'product',
                    'content_ids' => [$productData['id']],
                    'content_name' => $productData['name'],
                ],
            ];

            return $this->sendEvent($eventData);
        } catch (\Exception $e) {
            Log::error("Meta Pixel trackAddToCart failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تتبع عرض المحتوى (ViewContent)
     */
    public function trackViewContent(User $user, array $productData): bool
    {
        if (!$this->enabled || !$this->pixelId || !$this->accessToken) {
            return false;
        }

        try {
            $eventData = [
                'event_name' => 'ViewContent',
                'event_time' => now()->timestamp,
                'event_source_url' => url()->current(),
                'action_source' => 'website',
                'user_data' => $this->getUserData($user),
                'custom_data' => [
                    'currency' => 'SAR',
                    'value' => (float) $productData['price'],
                    'content_type' => 'product',
                    'content_ids' => [$productData['id']],
                    'content_name' => $productData['name'],
                ],
            ];

            return $this->sendEvent($eventData);
        } catch (\Exception $e) {
            Log::error("Meta Pixel trackViewContent failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تحديث بيانات العميل في Meta
     */
    public function updateCustomerData(User $user): bool
    {
        if (!$this->enabled || !$this->pixelId || !$this->accessToken) {
            return false;
        }

        try {
            // إرسال بيانات العميل إلى Meta للمطابقة
            $userData = $this->getUserData($user);
            
            Log::info("Customer data updated in Meta for user #{$user->id}");
            return true;
        } catch (\Exception $e) {
            Log::error("Meta updateCustomerData failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * إرسال الحدث إلى Meta Conversions API
     */
    protected function sendEvent(array $eventData): bool
    {
        $url = "https://graph.facebook.com/{$this->apiVersion}/{$this->pixelId}/events";

        $response = Http::post($url, [
            'data' => [$eventData],
            'access_token' => $this->accessToken,
        ]);

        if ($response->successful()) {
            Log::info("Meta Pixel event sent: {$eventData['event_name']}");
            return true;
        }

        Log::error("Meta Pixel event failed: " . $response->body());
        return false;
    }

    /**
     * الحصول على بيانات المستخدم
     */
    protected function getUserData(User $user): array
    {
        return [
            'em' => $user->email ? hash('sha256', strtolower(trim($user->email))) : null,
            'ph' => $user->phone ? hash('sha256', preg_replace('/[^0-9]/', '', $user->phone)) : null,
            'fn' => $user->name ? hash('sha256', strtolower(trim(explode(' ', $user->name)[0]))) : null,
            'ln' => $user->name && str_contains($user->name, ' ') 
                ? hash('sha256', strtolower(trim(substr($user->name, strpos($user->name, ' ') + 1)))) 
                : null,
            'ct' => $user->city ?? null,
            'country' => 'sa',
            'external_id' => hash('sha256', (string) $user->id),
        ];
    }

    /**
     * الحصول على محتويات الطلب
     */
    protected function getOrderContents(Order $order): array
    {
        return $order->items->map(function ($item) {
            return [
                'id' => $item->product_id,
                'quantity' => $item->quantity,
                'item_price' => (float) $item->price,
            ];
        })->toArray();
    }

    /**
     * الحصول على Pixel ID للاستخدام في Frontend
     */
    public function getPixelId(): string
    {
        return $this->pixelId;
    }

    /**
     * توليد كود Pixel للصفحة
     */
    public function getPixelScript(): string
    {
        if (!$this->enabled || !$this->pixelId) {
            return '';
        }

        return <<<HTML
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{$this->pixelId}');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id={$this->pixelId}&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
HTML;
    }
}

