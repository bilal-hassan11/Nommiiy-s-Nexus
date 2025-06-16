<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositeTable extends Migration
{
    public function up()
    {
        Schema::create('deposite', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('merchant'); // Merchant field
            $table->string('username')->nullable(); // Username filter
            $table->string('currency')->nullable(); // Selected currency (consider normalization if needed)
            $table->string('payment_channel')->nullable(); // Payment Channel
            $table->string('member_group')->nullable(); // Member Group
            $table->string('status')->default('All'); // Status, default to 'All'
            $table->string('payment_method')->nullable(); // Payment Method (like bank_transfer, credit_card)
            $table->date('completed_at')->nullable(); // End Date
            $table->string('risk')->default('All'); // Risk status
            $table->string('order_id')->nullable(); // Order ID
            $table->string('affiliate_username')->nullable(); // Affiliate Username
            $table->string('time_zone')->default('GMT+0700'); // Default Time Zone
            $table->string('transaction_id')->nullable(); // Transaction ID
            $table->string('reference_number')->nullable(); // Reference Number
            $table->string('player_id')->nullable(); // Player ID
            $table->timestamps(); // Created and updated timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('deposite');
    }
}
