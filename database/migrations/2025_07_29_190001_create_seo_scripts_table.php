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
        // Drop the old table if it exists and had language/merchant logic
        Schema::dropIfExists('seo_scripts');

        Schema::create('global_seo_settings', function (Blueprint $table) {
            $table->id(); // This table will ideally only ever have one row (ID 1)
            $table->text('seo_header')->nullable();
            $table->text('seo_homepage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_scripts');
    }
};