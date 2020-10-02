<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('students_name');
            $table->string('students_ic');
            $table->string('students_email');
            $table->string('students_phone');
            $table->string('students_nationality');
            $table->string('students_gender');
            $table->string('students_religion');
            $table->string('students_marital');
            $table->string('students_race');
            $table->date('students_dob');
            $table->string('students_programme');
            $table->string('students_major');
            $table->string('programme_status');
            $table->string('intake_id');
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
        Schema::dropIfExists('students');
    }
}
