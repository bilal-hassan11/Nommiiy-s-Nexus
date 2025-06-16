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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('discount_value')->default(0);
            $table->string('discount_type');

            $table->foreignId('system_user_id')
                ->nullable() // Allow system_user_id to be null
                ->constrained('users')
                ->onDelete('set null'); // When a role is deleted, set system_user_id to null
            // Make system_user_id nullable and set foreign key to "set null" on delete
            $table->foreignId('user_id')
                ->nullable() // Allow role_id to be null
                ->constrained('users')
                ->onDelete('set null'); // When a role is deleted, set role_id to null

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
