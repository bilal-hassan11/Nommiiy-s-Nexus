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
        Schema::create('blog_types', function (Blueprint $table) {
            $table->id();
            $table->string('blog_type')->unique(); // Blog type name, must be unique
            $table->integer('priority')->default(0); // Numerical priority
            $table->json('locales')->nullable(); // JSON column for localized names
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_types');
    }
};