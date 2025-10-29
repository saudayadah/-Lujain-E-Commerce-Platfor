<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CampaignTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'category',
        'subject',
        'content_ar',
        'content_en',
        'variables',
        'design_settings',
        'thumbnail',
        'is_active',
        'usage_count',
        'created_by',
    ];

    protected $casts = [
        'variables' => 'array',
        'design_settings' => 'array',
        'is_active' => 'boolean',
        'usage_count' => 'integer',
    ];

    // علاقة مع الحملات التي تستخدم هذا القالب
    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class, 'template_id');
    }

    // علاقة مع منشئ القالب
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // زيادة عداد الاستخدام
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    // الحصول على المحتوى باللغة المطلوبة
    public function getContent(string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'ar' ? $this->content_ar : $this->content_en;
    }

    // استبدال المتغيرات في المحتوى
    public function replaceVariables(string $content, array $variables = []): string
    {
        $defaultVariables = [
            '{{customer_name}}' => 'العميل',
            '{{store_name}}' => 'متجرنا',
            '{{order_number}}' => '#12345',
            '{{discount_code}}' => 'SAVE10',
            '{{expiry_date}}' => now()->addDays(7)->format('Y-m-d'),
            '{{product_name}}' => 'منتج مميز',
        ];

        $allVariables = array_merge($defaultVariables, $variables);

        foreach ($allVariables as $placeholder => $value) {
            $content = str_replace($placeholder, $value, $content);
        }

        return $content;
    }

    // الحصول على معاينة المحتوى مع البيانات التجريبية
    public function getPreview(string $locale = null): string
    {
        $content = $this->getContent($locale);

        return $this->replaceVariables($content, [
            '{{customer_name}}' => 'أحمد محمد',
            '{{store_name}}' => 'متجر الإلكترونيات',
            '{{order_number}}' => '#ORD-2024-001',
            '{{discount_code}}' => 'WELCOME15',
            '{{expiry_date}}' => now()->addDays(3)->format('Y-m-d'),
            '{{product_name}}' => 'هاتف ذكي سامسونج',
        ]);
    }

    // فئات القوالب المتاحة
    public static function getCategories(): array
    {
        return [
            'welcome' => 'رسائل ترحيب',
            'promotional' => 'عروض ترويجية',
            'abandoned_cart' => 'سلات مهجورة',
            'order_confirmation' => 'تأكيد الطلب',
            'shipping_notification' => 'إشعار شحن',
            'delivery_notification' => 'إشعار توصيل',
            'win_back' => 'استعادة العملاء',
            'birthday' => 'أعياد الميلاد',
            'seasonal' => 'عروض موسمية',
            'feedback' => 'طلب تقييم',
        ];
    }

    // أنواع القوالب المتاحة
    public static function getTypes(): array
    {
        return [
            'email' => 'بريد إلكتروني',
            'whatsapp' => 'واتساب',
            'sms' => 'رسائل نصية',
            'push' => 'إشعارات الدفع',
        ];
    }
}
