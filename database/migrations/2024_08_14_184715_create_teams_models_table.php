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
        Schema::create('teams_models', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->unsigned();
            $table->integer('item_order')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('matricule')->nullable();
            $table->longText('fonctions')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('genre')->default('personnaliser');
            $table->string('person_img')->nullable();
            $table->longText('profession_list')->nullable();
            $table->string('address')->nullable();
            $table->longText('competences')->nullable();
            $table->longText('languages')->nullable();
            $table->text('nationnalite')->nullable();
            $table->text('pays_residence')->nullable();
            $table->string('lieu_residence')->nullable();
            $table->string('organisation')->nullable();
            $table->string('link_linkedin')->nullable();
            $table->string('link_site_web')->nullable();
            $table->string('category_person')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams_models');
    }
};
