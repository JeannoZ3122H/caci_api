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
        Schema::create('analyse_folder_models', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->unsigned();
            $table->integer('folder_us_id')->unsigned();
            $table->text('object')->nullable();
            $table->longText('comments')->nullable();
            $table->string('current_step')->nullable();
            $table->string('next_step')->nullable();
            $table->string('next_step_date')->nullable();
            $table->string('file')->nullable();
            $table->string('status_analyse')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyse_folder_models');
    }
};
