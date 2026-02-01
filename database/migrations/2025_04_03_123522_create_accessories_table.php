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
        Schema::create('accessories', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Name of the accessory
            $table->string('category');       // Category of the accessory
            $table->decimal('price', 10, 2);  // Price of the accessory
            $table->integer('stock');         // Stock quantity of the accessory
            $table->string('color')->nullable();  // Color of the accessory
            $table->string('size')->nullable();   // Size (e.g., small, medium, large)
            $table->string('image1')->nullable();  // Image 1
            $table->string('image2')->nullable();  // Image 2
            $table->string('image3')->nullable();  // Image 3
            $table->string('image4')->nullable();  // Image 4
            $table->string('image5')->nullable();  // Image 5
            $table->timestamps();             //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessories');
    }
};
