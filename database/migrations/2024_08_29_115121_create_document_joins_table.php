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
        Schema::create('document_joins', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->unsigned();
            $table->text('title')->nullable();
            $table->text('libelle_document')->nullable();
            $table->text('code_ref_libelle')->nullable();
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
        Schema::dropIfExists('document_joins');
    }
};
