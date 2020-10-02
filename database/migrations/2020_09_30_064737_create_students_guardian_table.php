<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsGuardianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_guardian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('students_id');
            $table->string('guardian_one_name');
            $table->string('guardian_one_relationship');
            $table->string('guardian_one_ic');
            $table->string('guardian_one_mobile');
            $table->string('guardian_one_address');
            $table->string('guardian_one_occupation');
            $table->string('guardian_one_nationality');
            $table->string('guardian_one_dependent');
            $table->string('guardian_two_name');
            $table->string('guardian_two_relationship');
            $table->string('guardian_two_ic');
            $table->string('guardian_two_mobile');
            $table->string('guardian_two_address');
            $table->string('guardian_two_occupation');
            $table->string('guardian_two_nationality');
            $table->string('guardian_two_dependent');
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
        Schema::dropIfExists('students_guardian');
    }
}
