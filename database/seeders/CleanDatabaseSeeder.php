<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CleanDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        echo "🧹 بدء تنظيف قاعدة البيانات...\n\n";

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        echo "1️⃣ حذف عناصر الطلبات...\n";
        DB::table('order_items')->truncate();
        echo "   ✅ تم\n\n";

        echo "2️⃣ حذف الطلبات...\n";
        DB::table('orders')->truncate();
        echo "   ✅ تم\n\n";

        echo "3️⃣ حذف المدفوعات...\n";
        DB::table('payments')->truncate();
        echo "   ✅ تم\n\n";

        echo "4️⃣ حذف الفواتير...\n";
        DB::table('invoices')->truncate();
        echo "   ✅ تم\n\n";

        echo "5️⃣ حذف حركات المخزون...\n";
        DB::table('inventory_movements')->truncate();
        echo "   ✅ تم\n\n";

        echo "6️⃣ حذف المنتجات...\n";
        DB::table('products')->truncate();
        echo "   ✅ تم\n\n";

        echo "7️⃣ حذف متغيرات المنتجات...\n";
        DB::table('product_variants')->truncate();
        echo "   ✅ تم\n\n";

        echo "8️⃣ حذف الكوبونات المستخدمة...\n";
        DB::table('coupon_user')->truncate();
        DB::table('coupons')->truncate();
        echo "   ✅ تم\n\n";

        echo "9️⃣ حذف قائمة الأمنيات...\n";
        DB::table('wishlists')->truncate();
        echo "   ✅ تم\n\n";

        echo "🔟 حذف التحققات الهاتفية...\n";
        DB::table('phone_verifications')->truncate();
        echo "   ✅ تم\n\n";

        echo "1️⃣1️⃣ حذف الحملات التسويقية...\n";
        DB::table('campaign_customers')->truncate();
        DB::table('campaigns')->truncate();
        echo "   ✅ تم\n\n";

        echo "1️⃣2️⃣ حذف تقسيم العملاء...\n";
        DB::table('customer_segments')->truncate();
        echo "   ✅ تم\n\n";

        echo "1️⃣3️⃣ حذف المستخدمين (ما عدا الأدمن)...\n";
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('users')->where('role', '!=', 'admin')->delete();
        DB::table('users')->whereNull('role')->delete();
        echo "   ✅ تم\n\n";

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        echo "1️⃣4️⃣ إعادة تعيين AUTO_INCREMENT...\n";
        $tables = [
            'order_items',
            'orders',
            'payments',
            'invoices',
            'inventory_movements',
            'products',
            'product_variants',
            'coupons',
            'wishlists',
            'phone_verifications',
            'campaigns',
            'customer_segments',
        ];
        
        foreach ($tables as $table) {
            DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = 1");
        }
        echo "   ✅ تم\n\n";

        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "✨ تم تنظيف قاعدة البيانات بنجاح!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        echo "✅ المحذوف:\n";
        echo "   - جميع المنتجات والمتغيرات\n";
        echo "   - جميع الطلبات والمدفوعات\n";
        echo "   - جميع الفواتير\n";
        echo "   - جميع الكوبونات\n";
        echo "   - جميع قوائم الأمنيات\n";
        echo "   - جميع الحملات التسويقية\n";
        echo "   - جميع المستخدمين (ما عدا الأدمن)\n\n";
        echo "✅ المحفوظ:\n";
        echo "   - الفئات (Categories)\n";
        echo "   - حساب الأدمن\n";
        echo "   - الإعدادات (Settings)\n";
        echo "   - الصلاحيات (Permissions)\n";
        echo "   - مناطق الشحن (Shipping Zones)\n\n";
    }
}

