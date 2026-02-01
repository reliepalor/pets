<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['pet_id']);
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
        });
    }
};
