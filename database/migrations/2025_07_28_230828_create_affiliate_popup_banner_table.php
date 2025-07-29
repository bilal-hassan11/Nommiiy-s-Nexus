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
        Schema::create('affiliate_pop_up_banners', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_id');
            $table->string('status');
            $table->string('language');
            $table->string('title');
            $table->text('description'); // Text for potentially longer descriptions
            $table->string('link');
            $table->enum('link_target', ['current', 'new'])->default('current'); // 'current' or 'new'
            $table->date('start_date');
            $table->date('end_date');
            $table->string('mobile_image_path'); // Stores the path to the uploaded image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_pop_up_banners');
    }
};