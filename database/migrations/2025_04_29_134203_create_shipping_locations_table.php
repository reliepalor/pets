<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shipping_locations', function (Blueprint $table) {
            $table->id();
            $table->string('province');
            $table->string('city');
            $table->string('barangay')->nullable();
            $table->string('zip_code');
            $table->decimal('delivery_fee', 8, 2);
            $table->string('estimated_days')->nullable(); // e.g., "2-3 days"
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_locations');
    }
};
