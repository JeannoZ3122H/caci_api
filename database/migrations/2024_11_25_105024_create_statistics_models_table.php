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
        Schema::create('statistics_models', function (Blueprint $table) {
            $table->id();
            $table->text('page');
            $table->integer('visites')->default(0);
            $table->string('utilisateurs_uniques')->nullable();
            $table->float('temps_moyen')->nullable();
            $table->date('date');
            $table->string('navigateur')->nullable();
            $table->string('dispositif')->nullable();
            $table->string('source_traffic')->nullable();
            $table->integer('folders')->default(0);
            $table->integer('members')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics_models');
    }
};
