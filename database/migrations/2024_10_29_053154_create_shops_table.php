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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('location');
            $table->string('contact_number')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('system_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_id')->nullable() ->constrained('users')->onDelete('set null');
            $table->unique(['name', 'system_user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
