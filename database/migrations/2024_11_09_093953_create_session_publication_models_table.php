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
        Schema::create('session_publication_models', function (Blueprint $table) {
            $table->id();
            $table->string('sup_title')->nullable();
            $table->longText('description')->nullable();
            $table->string('icon')->nullable();
            $table->text('banner')->nullable();
            $table->longText('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_publication_models');
    }
};
