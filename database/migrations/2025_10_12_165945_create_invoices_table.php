<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('invoice_number')->unique(); // INV-20251012-001
            $table->uuid('uuid')->unique(); // UUID فريد للفاتورة
            
            // Seller Information
            $table->string('seller_name_ar');
            $table->string('seller_name_en')->nullable();
            $table->string('vat_number', 15); // الرقم الضريبي (15 رقم)
            $table->string('cr_number')->nullable(); // رقم السجل التجاري
            $table->text('seller_address')->nullable();
            
            // Invoice Details
            $table->enum('invoice_type', ['tax', 'simplified'])->default('simplified');
            $table->dateTime('invoice_date'); // تاريخ ووقت الإصدار
            
            // Amounts
            $table->decimal('subtotal', 10, 2); // قبل الضريبة
            $table->decimal('tax_amount', 10, 2); // قيمة الضريبة
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2); // الإجمالي النهائي
            
            // QR Code
            $table->text('qr_code_data'); // Base64 encoded QR data
            $table->text('qr_code_image')->nullable(); // QR Code as image (base64)
            
            // Additional Info
            $table->json('line_items')->nullable(); // تفاصيل المنتجات
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            $table->index('order_id');
            $table->index('invoice_number');
            $table->index('vat_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
