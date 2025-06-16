<?php
// database/migrations/xxxx_xx_xx_create_members_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('member', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('currency')->default('BDT');
            $table->string('country_code');
            $table->string('mobile_number');
            $table->string('full_name');
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('force_password_change')->default(false);
            $table->string('bank')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('affiliate_login')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('member');
    }
};
