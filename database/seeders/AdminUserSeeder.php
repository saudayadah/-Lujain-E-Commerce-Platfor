<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@lujaiin.sa');
        $password = env('ADMIN_PASSWORD', 'password');

        // حذف أي مستخدمين أدمن سابقين
        User::where('role', 'admin')->delete();

        // إنشاء حساب أدمن جديد بالبيانات المحددة
        $admin = User::create([
            'name' => 'مدير النظام',
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'phone' => '+966500000000',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // تعيين الدور
        $admin->assignRole('admin');

        echo "✅ تم إنشاء حساب الأدمن بنجاح!\n";
        echo "📧 البريد الإلكتروني: {$email}\n";
        echo "🔐 كلمة المرور: {$password}\n";
        echo "\n⚠️ استخدم هذه البيانات لتسجيل الدخول الآن.\n";
    }
}

