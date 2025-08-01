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
        Schema::create('member_groups', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Unique identifier for the group
            $table->string('name')->unique(); // Group name, also unique
            $table->integer('level'); // Numeric level for the group
            $table->string('logo_path')->nullable(); // Path to the uploaded logo
            $table->enum('status', ['Default', 'Active', 'Inactive'])->default('Active'); // Group status
            $table->integer('sequence')->unique(); // Display order/sequence, unique
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};