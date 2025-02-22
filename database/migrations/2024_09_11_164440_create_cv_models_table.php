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
        Schema::create('cv_models', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->unsigned();
            $table->string('matricule')->nullable();
            $table->string('libelle')->nullable();
            $table->string('type_content')->nullable();
            $table->longText('content')->nullable();
            $table->longText('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_models');
    }
};
