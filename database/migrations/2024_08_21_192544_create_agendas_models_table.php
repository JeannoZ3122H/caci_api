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
        Schema::create('agendas_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id')->nullable()->index();
            $table->string('price')->nullable();
            $table->string('title_event')->nullable();
            $table->longText('description_event')->nullable();
            $table->date('date_start_event')->nullable();
            $table->date('date_end_event')->nullable();
            $table->string('status_enter_event')->nullable();
            $table->text('address_event')->nullable();
            $table->text('localisation_event')->nullable();
            $table->text('illusration_event')->nullable();
            $table->longText('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas_models');
    }
};
