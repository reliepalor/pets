<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveShippingLocationIdFromUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['shipping_location_id']);
            // Drop the column
            $table->dropColumn('shipping_location_id');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Re-add the column
            $table->unsignedBigInteger('shipping_location_id')->nullable()->after('updated_at');
            // Re-add the foreign key constraint
            $table->foreign('shipping_location_id')->references('id')->on('shipping_locations')->onDelete('set null');
        });
    }
}