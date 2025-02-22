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
        Schema::create('session_footer_menu_models', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->unsigned()->default(1);
            $table->integer('item_order')->nullable();
            $table->string('nav_footer_item_code')->nullable();
            $table->string('nav_footer_item')->nullable();
            $table->string('perimetre')->nullable();
            $table->longText('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_footer_menu_models');
    }
};
