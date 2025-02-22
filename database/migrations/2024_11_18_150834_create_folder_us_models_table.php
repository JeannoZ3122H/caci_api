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
        Schema::create('folder_us_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->unsigned();
            $table->foreignId('type_procedure_id')->unsigned();
            $table->string('ref_folder')->nullable();
            $table->string('fullname')->nullable();
            $table->string('dossier_follower')->nullable();
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->longText('professions')->nullable();
            $table->longText('description')->nullable();
            $table->string('already_step')->nullable();
            $table->text('file')->nullable();
            $table->string('status_folder_analyse')->default("En cours");
            $table->boolean('status_finished')->default(0);
            $table->boolean('status_answere')->default(0);
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folder_us_models');
    }
};
