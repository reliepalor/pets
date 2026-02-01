<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['Dog', 'Cat']);
            $table->string('breed');
            $table->float('age');
            $table->enum('gender', ['Male', 'Female']);
            $table->integer('quantity');
            $table->string('color');
            $table->decimal('price', 10, 2);
            $table->text('description');
            $table->string('pet_image1');
            $table->string('pet_image2')->nullable();
            $table->string('pet_image3')->nullable();
            $table->string('pet_image4')->nullable();
            $table->string('pet_image5')->nullable();
            $table->enum('status', ['Available', 'Adopted', 'Reserved', 'Sold Out', 'Unavailable'])->default('Available');
            $table->timestamp('date_added')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pets');
    }
}; 