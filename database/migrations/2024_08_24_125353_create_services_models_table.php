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
            $table->unsignedBigInteger('author_id')->nullable()->index();
            $table->unsignedBigInteger('type_service_id')->nullable()->index();
            $table->text('libelle')->nullable();
            $table->text('code_ref')->nullable();
            $table->longText('description')->nullable();
            $table->text('illustration')->nullable();
            $table->text('type_media')->nullable();
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
