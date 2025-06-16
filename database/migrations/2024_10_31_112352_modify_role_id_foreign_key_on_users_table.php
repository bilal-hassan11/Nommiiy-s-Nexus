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
        Schema::table('users', function (Blueprint $table) {
            // Drop the existing foreign key
            $table->dropForeign(['role_id']);
            
            // Recreate the foreign key with the RESTRICT option
            $table->foreign('role_id')
                  ->references('id')->on('roles')
                  ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the RESTRICT foreign key
            $table->dropForeign(['role_id']);
            
            // Recreate the foreign key with the SET NULL option
            $table->foreign('role_id')
                  ->references('id')->on('roles')
                  ->onDelete('set null');
        });
    }
};
