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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requested_to_shop')->nullable() ->constrained('shops')->onDelete('set null'); 
            $table->foreignId('requested_from_shop')->nullable() ->constrained('shops')->onDelete('set null'); 
            $table->foreignId('system_user_id')->nullable() ->constrained('users')->onDelete('set null'); 
            $table->foreignId('user_id')->nullable() ->constrained('users')->onDelete('set null'); 
            $table->text('comment')->nullable();
            $table->date('datetime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
