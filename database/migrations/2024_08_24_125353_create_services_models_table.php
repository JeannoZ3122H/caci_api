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
        Schema::create('services_models', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->unsigned();
            $table->integer('type_service_id')->unsigned();
            $table->string('libelle')->nullable();
            $table->string('type_content')->nullable();
            $table->string('')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_models');
    }
};
