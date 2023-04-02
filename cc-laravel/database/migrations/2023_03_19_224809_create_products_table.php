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
            $table->enum('type', [1, 2, 3, 4]);
            $table->string('model');
            $table->string('tissue');
            $table->string('color');
            $table->boolean('pocket');
            $table->enum('collar', [1, 2, 3, 4, 5])->nullable();
            $table->enum('cuff', [1, 2, 3, 4])->nullable();
            $table->boolean('vivo')->nullable();
            $table->enum('faixa', [1, 2, 3])->nullable();
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
