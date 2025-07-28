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
        Schema::create('c_m_s_banners', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_id'); // Corresponds to merchantId in Vue
            $table->string('status'); // e.g., Active, Inactive
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('language'); // e.g., EN-BD
            $table->integer('index'); // Changed to integer based on context
            $table->date('start_date');
            $table->date('end_date');
            $table->string('mobile_image')->nullable(); // Path to mobile image
            $table->string('web_image')->nullable();   // Path to web image
            $table->string('href')->nullable(); // Corresponds to href in Vue
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cmsbanners');
    }
};