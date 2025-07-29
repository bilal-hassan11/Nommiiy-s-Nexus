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
        Schema::create('general_info_settings', function (Blueprint $table) {
            $table->id();
            $table->string('currency')->unique(); // Currency will be unique
            $table->boolean('about_us_enabled')->default(true);
            $table->boolean('faq_enabled')->default(true);
            $table->boolean('terms_enabled')->default(false);
            $table->boolean('privacy_policy_enabled')->default(false);
            $table->boolean('responsible_gaming_enabled')->default(false);
            $table->boolean('disconnect_policy_enabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_info_settings');
    }
};