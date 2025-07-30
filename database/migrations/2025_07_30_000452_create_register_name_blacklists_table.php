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
        Schema::create('register_name_blacklists', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->unique(); // Matches frontend 'fullName', added unique constraint
            $table->text('remark')->nullable();    // Matches frontend 'remark'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_name_blacklists');
    }
};