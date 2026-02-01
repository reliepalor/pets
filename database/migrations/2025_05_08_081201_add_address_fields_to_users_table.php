<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'street_address')) {
                $table->string('street_address')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('street_address');
            }
            if (!Schema::hasColumn('users', 'province')) {
                $table->string('province')->nullable()->after('city');
            }
            if (!Schema::hasColumn('users', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('province');
            }
            if (!Schema::hasColumn('users', 'country')) {
                $table->string('country')->nullable()->after('postal_code');
            }
            if (!Schema::hasColumn('users', 'profile_image')) {
                $table->string('profile_image')->nullable()->after('country');
            }
            if (!Schema::hasColumn('users', 'shipping_location_id')) {
                $table->unsignedBigInteger('shipping_location_id')->nullable()->after('updated_at');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['street_address', 'city', 'province', 'postal_code', 'country', 'profile_image', 'shipping_location_id'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}