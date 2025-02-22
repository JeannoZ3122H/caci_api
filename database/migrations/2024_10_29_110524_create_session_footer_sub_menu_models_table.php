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
        Schema::create('session_footer_sub_menu_models', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->unsigned()->default(1);
            $table->integer('nav_footer_item_id')->unsigned();
            $table->integer('item_order')->nullable();
            $table->string('nav_list_footer_item')->nullable();
            $table->string('nav_list_footer_item_code')->nullable();
            $table->string('nav_list_footer_item_icon')->nullable();
            $table->string('nav_list_footer_item_type_content')->nullable();
            $table->longText('nav_list_footer_item_content')->nullable();
            $table->longText('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_footer_sub_menu_models');
    }
};
