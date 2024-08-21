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
        Schema::create('banner_models', function (Blueprint $table) {
            $table->id();
            $table->integer('type_event_id')->unsigned();
            $table->string('url')->nullable();
            $table->string('title')->nullable();
            $table->string('event_img')->nullable();
            $table->text('description')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_models');
    }
};
