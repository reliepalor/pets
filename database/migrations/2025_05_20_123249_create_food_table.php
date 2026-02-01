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
    Schema::create('food', function (Blueprint $table) {
        $table->id();

        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('price', 8, 2);
        $table->integer('stock')->default(0);
        $table->decimal('weight', 5, 2)->nullable(); // in kg or g
        $table->string('flavor')->nullable();
        $table->enum('pet_type', ['dog', 'cat'])->default('dog');
        $table->string('brand')->nullable();

        // Images (1 to 5)
        $table->string('image1')->nullable();
        $table->string('image2')->nullable();
        $table->string('image3')->nullable();
        $table->string('image4')->nullable();
        $table->string('image5')->nullable();

        $table->enum('status', ['available', 'unavailable'])->default('available');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
