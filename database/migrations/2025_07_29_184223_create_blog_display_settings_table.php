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
        Schema::create('blog_display_settings', function (Blueprint $table) {
            $table->id();
            $table->string('merchant')->default('MJB');
            $table->string('currency')->default('BDT');
            $table->string('display_on_top')->default('yes'); // 'yes' or 'no'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_display_settings');
    }
};