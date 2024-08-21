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
        Schema::create('event_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_event_id')->nullable()->index();
            $table->string('author')->nullable();
            $table->string('event_title')->nullable();
            $table->longText('event_description')->nullable();
            $table->longText('event_img')->nullable();
            $table->longText('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_models');
    }
};
