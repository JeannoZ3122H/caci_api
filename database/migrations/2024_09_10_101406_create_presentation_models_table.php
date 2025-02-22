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
        Schema::create('presentation_models', function (Blueprint $table) {
            $table->id();
            $table->integer('type_event_id')->unsigned();
            $table->integer('author_id')->unsigned();
            $table->integer('item_order')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('illustration')->nullable();
            $table->string('type_media')->nullable();
            $table->string('url')->nullable();
            $table->longText('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentation_models');
    }
};
