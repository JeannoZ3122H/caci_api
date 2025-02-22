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
        Schema::create('calculator_frais_models', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->unsigned();
            $table->text('libelle')->nullable();
            $table->text('subTitle')->nullable();
            $table->text('type_service_code')->nullable();
            $table->text('code_ref')->nullable();
            $table->longText('description')->nullable();
            $table->text('illustration')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculator_frais_models');
    }
};
