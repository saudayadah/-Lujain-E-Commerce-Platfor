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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // كود الكوبون (SUMMER25)
            $table->enum('type', ['percentage', 'fixed']); // نوع الخصم
            $table->decimal('value', 10, 2); // قيمة الخصم (25% أو 50 ر.س)
            $table->decimal('min_order_amount', 10, 2)->nullable(); // حد أدنى للطلب
            $table->decimal('max_discount', 10, 2)->nullable(); // حد أقصى للخصم
            $table->integer('usage_limit')->nullable(); // عدد الاستخدامات المسموح
            $table->integer('usage_count')->default(0); // عدد الاستخدامات الفعلية
            $table->integer('per_user_limit')->default(1); // عدد المرات لكل مستخدم
            $table->dateTime('starts_at')->nullable(); // تاريخ البداية
            $table->dateTime('expires_at')->nullable(); // تاريخ الانتهاء
            $table->boolean('is_active')->default(true); // مفعل/معطل
            $table->text('description')->nullable(); // وصف الكوبون
            $table->timestamps();
            
            $table->index('code');
            $table->index('is_active');
        });
        
        // جدول لتتبع استخدامات الكوبون لكل مستخدم
        Schema::create('coupon_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coupon_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->decimal('discount_amount', 10, 2); // المبلغ المخصوم
            $table->timestamps();
            
            $table->index(['coupon_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_user');
        Schema::dropIfExists('coupons');
    }
};
