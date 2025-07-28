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
        Schema::create('affiliate_banners', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_id');
            $table->string('content-type');
            $table->string('status');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('language');
            $table->integer('index');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('mobile_image'); // Path to stored mobile image
            $table->string('web_image');    // Path to stored web image
            $table->string('href');         // URL for the affiliate link
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_banners');
    }
};