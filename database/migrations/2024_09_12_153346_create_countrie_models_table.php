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
        Schema::create('countrie_models', function (Blueprint $table) {
            $table->id();
            $table->text('countrie_name')->nullable();
            $table->text(column: 'continent')->nullable();
            $table->text('countrie_flag')->nullable();
            $table->text('countrie_iso_code')->nullable();
            $table->text('countrie_phone_code')->nullable();
            $table->text('countrie_currency')->nullable();
            $table->text('nationality')->nullable();
            $table->longText('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countrie_models');
    }
};
