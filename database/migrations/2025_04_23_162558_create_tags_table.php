<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('merchant'); // Corresponds to the select for merchants
            $table->string('tag_name'); // Corresponds to the tag name input
            $table->string('updated_by')->default('Admin'); // Indicates who updated the tag
            $table->timestamps(); // Adds created_at and updated_at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('tags');
    }
}  
