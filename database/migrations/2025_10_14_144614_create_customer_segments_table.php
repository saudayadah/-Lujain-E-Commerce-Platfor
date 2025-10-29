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
        Schema::create('customer_segments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type')->default('behavioral'); // behavioral, demographic, etc.
            $table->json('conditions')->nullable(); // شروط الشريحة
            $table->boolean('is_dynamic')->default(true); // ديناميكي أم ثابت
            $table->timestamp('last_calculated_at')->nullable();
            $table->integer('customer_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('color')->default('#3B82F6');
            $table->string('icon')->default('users');
            $table->timestamps();

            $table->index(['type', 'is_active']);
            $table->index(['is_dynamic', 'last_calculated_at']);
            $table->index(['created_by', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_segments');
    }
};
