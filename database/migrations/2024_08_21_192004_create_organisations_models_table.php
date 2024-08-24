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
        Schema::create('organisations_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id')->nullable()->index();
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('illustration')->nullable();
            $table->longText('description')->nullable();
            $table->longText('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisations_models');
    }
};
