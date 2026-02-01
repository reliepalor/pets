<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceCartWithCartItemsTable extends Migration
{
    public function up()
    {
        // Drop the existing cart table
        Schema::dropIfExists('cart');

        // Create the new cart_items table
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('item_type'); // 'pet' or 'accessory'
            $table->unsignedBigInteger('item_id');
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Drop the cart_items table
        Schema::dropIfExists('cart_items');

        // Recreate the original cart table
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pet_id');
            $table->unsignedInteger('quantity');
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
        });
    }
}