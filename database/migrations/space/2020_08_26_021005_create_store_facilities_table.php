<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_facilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('roomfacility_id');
            $table->unsignedBigInteger('roomtype_id');
	        $table->unsignedBigInteger('roomsuitability_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_facilities');
    }
}
