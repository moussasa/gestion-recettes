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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
             $table->string('title');
    $table->text('description');
    $table->text('instructions');
    $table->integer('prep_time')->nullable();
    $table->integer('cook_time')->nullable();
    $table->integer('servings')->nullable();
    $table->string('difficulty')->nullable();
    $table->string('image')->nullable();
    $table->string('type'); // entrée, plat principal, dessert, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
