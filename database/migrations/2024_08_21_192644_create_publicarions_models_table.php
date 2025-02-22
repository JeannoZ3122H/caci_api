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
        Schema::create('publicarions_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id')->nullable()->index();
            $table->unsignedBigInteger('type_publication_id')->nullable()->index();
            $table->string('libelle')->nullable();
            $table->string('type_file')->nullable();
            $table->string('url_file')->nullable();
            $table->longText('url')->nullable();
            $table->longText('slug')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicarions_models');
    }
};
