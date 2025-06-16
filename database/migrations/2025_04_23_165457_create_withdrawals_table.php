<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalsTable extends Migration
{
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('merchant'); // Merchant
            $table->string('username')->nullable(); // Username
            $table->string('currency')->nullable(); // Currency (consider normalization for multiple currencies)
            $table->string('payment_channel')->nullable(); // Payment Type
            $table->string('member_group')->nullable(); // Member Group
            $table->unsignedBigInteger('withdraw_id')->nullable(); // Withdraw ID
            $table->string('status')->default('All'); // Status default to 'All'
            $table->date('completed_at')->nullable(); // End Date
            $table->string('risk')->default('All'); // Risk status
            $table->string('merchant_bank')->nullable(); // Merchant Bank
            $table->string('time_zone')->default('GMT+0700'); // Default Time Zone
            $table->string('player_id')->nullable(); // Player ID
            $table->timestamps(); // Creates created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('withdrawals');
    }
}
