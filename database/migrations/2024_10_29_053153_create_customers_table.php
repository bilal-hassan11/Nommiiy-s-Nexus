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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('nin_bvn')->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('password')->nullable();
            $table->foreignId('system_user_id')->nullable() ->constrained('users')->onDelete('set null');
            $table->foreignId('user_id')->nullable() ->constrained('users')->onDelete('set null');
            $table->string('status');
            $table->unique(['name', 'system_user_id']); // unique constraint for name within system_user_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
