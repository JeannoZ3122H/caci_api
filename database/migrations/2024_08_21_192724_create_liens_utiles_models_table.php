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
        Schema::create('liens_utiles_models', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->unsigned();
            $table->text('sub_title')->nullable();
            $table->text('title')->nullable();
            $table->longText('description')->nullable();
            $table->text('global_link')->nullable();
            $table->text('illustration_url')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liens_utiles_models');
    }
};
