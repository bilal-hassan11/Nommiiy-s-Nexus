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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
            $table->foreignId('shop_id')->nullable()->constrained('shops')->onDelete('set null');
            $table->string('payment_method');
            $table->timestamp('purchase_date');
            $table->string('payment_status')->nullable();
            $table->decimal('paid_amount', 15, 2)->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->string('order_status')->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->string('delivery_status')->nullable();
            $table->string('type');
            $table->text('notes')->nullable();
            $table->foreignId('system_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
