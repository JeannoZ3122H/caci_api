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
        Schema::create('admin_account_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('admin_img')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('fonction')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('reset_password')->nullable();
            $table->boolean('status_account')->default(0);
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_account_models');
    }
};
