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
        Schema::create('b2_b_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_shop_id')->nullable() ->constrained('shops')->onDelete('set null'); 
            $table->foreignId('to_shop_id')->nullable() ->constrained('shops')->onDelete('set null'); 
                $table->string('type')->nullable();

            $table->date('date')->nullable();
            $table->foreignId('system_user_id')->nullable() ->constrained('users')->onDelete('set null'); 
            $table->foreignId('user_id')->nullable() ->constrained('users')->onDelete('set null'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b2_b_requests');
    }
};
