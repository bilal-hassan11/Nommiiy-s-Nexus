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
        Schema::create('affiliate_groups', function (Blueprint $table) {
            $table->id();
            $table->string('merchant');
            $table->string('name');
            $table->string('currency');
            $table->string('member_group');
            $table->string('remark')->nullable();
            $table->string('default_status');
            $table->boolean('active');
            $table->integer('sequence');

            // Withdrawal Limitation
            $table->boolean('no_minimum')->default(false);
            $table->boolean('no_maximum')->default(false);
            $table->decimal('minimum', 16, 2)->nullable();
            $table->decimal('maximum', 16, 2)->nullable();
            $table->integer('daily_count')->nullable();
            $table->boolean('no_daily_maximum')->default(false);
            $table->integer('daily_maximum_count')->nullable();

            // Deposit Limitation
            $table->boolean('no_minimum_deposit')->default(false);
            $table->boolean('no_maximum_deposit')->default(false);
            $table->decimal('minimum_deposit', 16, 2)->nullable();
            $table->decimal('maximum_deposit', 16, 2)->nullable();

            // Transfer Limitation
            $table->boolean('deposit_wallet')->default(false);
            $table->boolean('commission_wallet')->default(false);
            $table->decimal('minimum_transfer_limit', 16, 2)->nullable();
            $table->decimal('maximum_transfer_limit', 16, 2)->nullable();
            $table->decimal('daily_maximum_transfer_limit', 16, 2)->nullable();
            $table->decimal('target_multiplier', 8, 2)->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_groups');
    }
};
