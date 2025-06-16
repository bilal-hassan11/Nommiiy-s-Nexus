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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->string('member');
            $table->string('currency');
            $table->string('bank_account');
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->string('member_bank');
            $table->string('reference_number');
            $table->string('receipt_path')->nullable(); // Store the path, not the file itself
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
};
