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
            $table->foreignId('blog_type_id')->constrained('blog_types')->onDelete('cascade');
            $table->string('content_type'); // e.g., 'Home', 'Slot', 'Card'
            $table->string('status')->default('Active'); // e.g., 'Active', 'Inactive'
            $table->date('publish_date')->nullable();
            $table->string('author')->nullable();
            $table->string('index')->nullable(); // Could be a slug or a numerical index
            $table->string('url_title')->unique(); // For SEO friendly URLs, must be unique
            $table->boolean('popular')->default(false);
            $table->json('localized_content'); // Stores titles, descriptions, image paths, content for each locale
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