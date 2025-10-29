<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name_ar', 'value' => 'لُجين للعسل والعطارة', 'type' => 'string', 'group' => 'general', 'is_public' => true],
            ['key' => 'site_name_en', 'value' => 'Lujain Honey & Herbs', 'type' => 'string', 'group' => 'general', 'is_public' => true],
            ['key' => 'site_description', 'value' => 'متجرك الموثوق لأفضل أنواع العسل الطبيعي والبهارات والأعشاب والزيوت الطبيعية والتمور الفاخرة', 'type' => 'string', 'group' => 'general', 'is_public' => true],
            ['key' => 'contact_email', 'value' => 'info@lujain.sa', 'type' => 'string', 'group' => 'contact', 'is_public' => true],
            ['key' => 'contact_phone', 'value' => '+966 50 123 4567', 'type' => 'string', 'group' => 'contact', 'is_public' => true],
            ['key' => 'whatsapp_number', 'value' => '+966501234567', 'type' => 'string', 'group' => 'contact', 'is_public' => true],
            ['key' => 'contact_address', 'value' => 'المملكة العربية السعودية', 'type' => 'string', 'group' => 'contact', 'is_public' => true],
            ['key' => 'tax_rate', 'value' => '0.15', 'type' => 'string', 'group' => 'general', 'is_public' => true],
            
            // Appearance Settings (Images)
            ['key' => 'site_logo', 'value' => null, 'type' => 'image', 'group' => 'appearance', 'is_public' => true],
            ['key' => 'site_favicon', 'value' => null, 'type' => 'image', 'group' => 'appearance', 'is_public' => true],
            ['key' => 'hero_image', 'value' => null, 'type' => 'image', 'group' => 'appearance', 'is_public' => true],
            
            // Social Media Settings
            ['key' => 'social_facebook', 'value' => '', 'type' => 'string', 'group' => 'social', 'is_public' => true],
            ['key' => 'social_twitter', 'value' => '', 'type' => 'string', 'group' => 'social', 'is_public' => true],
            ['key' => 'social_instagram', 'value' => '', 'type' => 'string', 'group' => 'social', 'is_public' => true],
            ['key' => 'social_snapchat', 'value' => '', 'type' => 'string', 'group' => 'social', 'is_public' => true],
            
            // Shipping Settings
            ['key' => 'free_shipping_threshold', 'value' => '500', 'type' => 'integer', 'group' => 'shipping', 'is_public' => true],
            ['key' => 'shipping_fee', 'value' => '35', 'type' => 'integer', 'group' => 'shipping', 'is_public' => true],
            
            // Payment Settings
            ['key' => 'cod_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'payment', 'is_public' => false],
            ['key' => 'online_payment_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'payment', 'is_public' => false],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}

