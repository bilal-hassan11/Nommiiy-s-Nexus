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
        Schema::create('blog_contents', function (Blueprint $table) {
            $table->id();
            $table->string('blog_type');
            $table->string('content_type');
            $table->string('status')->default('Active');
            $table->date('publish_date')->nullable();
            $table->string('author')->nullable();
            $table->integer('index')->nullable();
            $table->string('url_title')->nullable();
            $table->boolean('popular')->default(false);
            $table->json('localized_content'); // Stores the nested localized data
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_contents');
    }
};