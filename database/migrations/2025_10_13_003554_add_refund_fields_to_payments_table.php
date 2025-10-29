<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table("payments", function (Blueprint $table) {
            if (!Schema::hasColumn("payments", "refund_amount")) {
                $table->decimal("refund_amount", 10, 2)->nullable();
                $table->string("refund_reason", 500)->nullable();
                $table->timestamp("refunded_at")->nullable();
            }
        });
    }
    public function down(): void {
        Schema::table("payments", function (Blueprint $table) {
            $table->dropColumn(["refund_amount", "refund_reason", "refunded_at"]);
        });
    }
};
