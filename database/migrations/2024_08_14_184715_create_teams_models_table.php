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
            $table->string('person_img')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('fonction')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
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
