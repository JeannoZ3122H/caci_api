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
        Schema::create('message_models', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->unsigned();
            $table->string('fullname')->nullable();
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->string('profession')->nullable();
            $table->string('object')->nullable();
            $table->string('requerent')->nullable();
            $table->string('type_procedure')->nullable();
            $table->longText('message')->nullable();
            $table->string('file')->nullable();
            $table->string('status_contact')->default("En attente");
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('message_models');
    }
};
