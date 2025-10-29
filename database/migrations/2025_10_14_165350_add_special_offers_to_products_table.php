<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // عروض خاصة محدودة الوقت
            $table->boolean('is_special_offer')->default(false)->after('is_featured');
            $table->datetime('special_offer_start')->nullable()->after('is_special_offer');
            $table->datetime('special_offer_end')->nullable()->after('special_offer_start');
            $table->decimal('special_discount_percentage', 5, 2)->nullable()->after('special_offer_end');

            // خصومات إضافية
            $table->boolean('is_flash_sale')->default(false)->after('special_discount_percentage');
            $table->datetime('flash_sale_start')->nullable()->after('is_flash_sale');
            $table->datetime('flash_sale_end')->nullable()->after('flash_sale_start');

            // تحسينات أخرى
            $table->string('badge_text')->nullable()->after('flash_sale_end');
            $table->string('badge_color', 7)->default('#10b981')->after('badge_text');
            $table->integer('priority')->default(0)->after('badge_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'is_special_offer',
                'special_offer_start',
                'special_offer_end',
                'special_discount_percentage',
                'is_flash_sale',
                'flash_sale_start',
                'flash_sale_end',
                'badge_text',
                'badge_color',
                'priority'
            ]);
        });
    }
};
