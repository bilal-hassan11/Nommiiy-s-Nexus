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
        Schema::create('member_tags', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('tag_name')->unique(); // String for tag name, must be unique
            $table->text('description')->nullable(); // Text for description, can be null
            $table->text('remark')->nullable(); // Text for remark, can be null
            $table->boolean('domain_binding')->default(false); // Boolean (true/false), defaults to false
            $table->string('mode')->default('single');
            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_tags');
    }
};