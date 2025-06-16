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
        Schema::create('b2_b_request_details', function (Blueprint $table) {
          $table->foreignId('b2b_request_id')->nullable() ->constrained('b2_b_requests')->onDelete('set null'); 
          $table->foreignId('product_id')->nullable() ->constrained('products')->onDelete('set null');
          
            $table->decimal('qty', 10, 2)->nullable();
            $table->string('in_out')->nullable();

            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b2_b_request_details');
    }
};
