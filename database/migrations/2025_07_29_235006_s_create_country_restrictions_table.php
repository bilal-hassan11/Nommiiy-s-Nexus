<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('country_restrictions', function (Blueprint $table) {
            $table->id();
            $table->string('merchant');
            $table->string('country');
            $table->string('name')->nullable();
            $table->boolean('whitelist')->default(false);
            $table->string('status');
            $table->text('remark')->nullable();
            $table->timestamps();

           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('country_restrictions');
    }
};