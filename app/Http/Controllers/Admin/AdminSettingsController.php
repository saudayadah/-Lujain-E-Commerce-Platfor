<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // معالجة الحقول النصية
        foreach ($request->except('_token', '_method', 'logo', 'hero_image', 'favicon') as $key => $value) {
            if ($value !== null) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'group' => $this->getGroupForKey($key)]
                );
            }
        }

        // معالجة الصور
        $this->handleImageUpload($request, 'logo', 'site_logo');
        $this->handleImageUpload($request, 'hero_image', 'hero_image');
        $this->handleImageUpload($request, 'favicon', 'site_favicon');

        return redirect()->back()->with('success', 'تم تحديث الإعدادات بنجاح');
    }

    private function handleImageUpload(Request $request, $inputName, $settingKey)
    {
        if ($request->hasFile($inputName)) {
            $request->validate([
                $inputName => 'image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
            ]);

            // حذف الصورة القديمة إن وجدت
            $oldSetting = Setting::where('key', $settingKey)->first();
            if ($oldSetting && $oldSetting->value && Storage::disk('public')->exists($oldSetting->value)) {
                Storage::disk('public')->delete($oldSetting->value);
            }

            // رفع الصورة الجديدة
            $path = $request->file($inputName)->store('settings', 'public');

            Setting::updateOrCreate(
                ['key' => $settingKey],
                ['value' => $path, 'group' => 'appearance', 'type' => 'image']
            );
        }
    }

    private function getGroupForKey($key)
    {
        return match (true) {
            str_starts_with($key, 'site_') => 'general',
            str_starts_with($key, 'contact_') => 'contact',
            str_starts_with($key, 'payment_') => 'payment',
            str_starts_with($key, 'sms_') => 'sms',
            str_starts_with($key, 'whatsapp_') => 'whatsapp',
            str_starts_with($key, 'hero_') => 'appearance',
            default => 'general',
        };
    }

    public function updatePaymentCredentials(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'sandbox_url' => 'required|url',
            'production_url' => 'required|url',
            'mode' => 'required|in:sandbox,production',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set("payment_{$key}", $value, 'string', 'payment');
        }

        return redirect()->back()->with('success', __('messages.admin.payment_credentials_updated'));
    }
}

