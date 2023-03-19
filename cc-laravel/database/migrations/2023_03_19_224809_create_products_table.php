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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price', 8, 2);
            $table->string('size');
            $table->unsignedInteger('type');
            $table->string('model');
            $table->string('tissue');
            $table->string('color');
            $table->boolean('pocket');
            $table->unsignedInteger('collar')->nullable();
            $table->unsignedInteger('cuff')->nullable();
            $table->boolean('vivo')->nullable();
            $table->unsignedInteger('faixa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
