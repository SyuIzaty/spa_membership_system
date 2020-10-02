<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsContactInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_contact_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('students_id');
            $table->string('students_address_1');
            $table->string('students_address_2');
            $table->string('students_poscode');
            $table->string('students_city');
            $table->string('students_state');
            $table->string('students_country');
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
        Schema::dropIfExists('students_contact_info');
    }
}
