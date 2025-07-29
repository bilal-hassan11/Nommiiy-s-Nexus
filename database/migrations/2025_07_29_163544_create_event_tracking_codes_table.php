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
        Schema::create('event_tracking_codes', function (Blueprint $table) {
            $table->id();
            $table->string('merchant')->default('MJB'); // Default to MJB based on your form
            $table->json('platform')->nullable(); // Storing multiple platforms as JSON array
            $table->string('currency')->nullable();
            $table->json('tracker')->nullable(); // Storing multiple trackers as JSON array
            $table->string('status')->default('Active'); // Default status
            $table->date('start_date'); // Corresponds to `createdAt` in frontend
            $table->date('end_date');   // Corresponds to `completedAt` in frontend
            $table->timestamps(); // `created_at` and `updated_at` for actual record creation/update time
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_tracking_codes');
    }
};