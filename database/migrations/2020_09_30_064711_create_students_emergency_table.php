<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsEmergencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_emergency', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('students_id');
            $table->string('emergency_name');
            $table->string('emergency_phone');
            $table->string('emergency_address');
            $table->string('emergency_relationship');
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
        Schema::dropIfExists('students_emergency');
    }
}
