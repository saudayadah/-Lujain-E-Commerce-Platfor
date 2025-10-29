<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password {email?} {--password=}';
    protected $description = 'إعادة تعيين كلمة مرور الأدمن';

    public function handle()
    {
        $email = $this->argument('email') ?? env('ADMIN_EMAIL', 'admin@lujain.com');
        $password = $this->option('password') ?? $this->secret('أدخل كلمة المرور الجديدة:');

        if (empty($password)) {
            $this->error('❌ يجب إدخال كلمة مرور!');
            return 1;
        }

        $admin = User::where('email', $email)->first();

        if (!$admin) {
            $this->error("❌ لم يتم العثور على مستخدم بالبريد: {$email}");
            $this->info('💡 جرب تشغيل: php artisan db:seed --class=AdminUserSeeder');
            return 1;
        }

        $admin->update([
            'password' => Hash::make($password),
            'is_active' => true,
        ]);

        $this->info("✅ تم تحديث كلمة المرور بنجاح!");
        $this->line("📧 البريد الإلكتروني: {$email}");
        $this->line("🔐 كلمة المرور الجديدة: {$password}");

        return 0;
    }
}

