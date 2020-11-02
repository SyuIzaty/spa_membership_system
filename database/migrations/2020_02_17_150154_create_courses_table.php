<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->string('id');
            $table->string('course_code');
            $table->string('course_name_bm');
            $table->string('course_name');
            $table->decimal('credit_hours'); 
            $table->decimal('lecturer_hours');
            $table->decimal('lab_hours');
            $table->decimal('tutorial_hours');
            $table->string('exam_duration');
            $table->string('final_exam');
            $table->string('project_course');
            $table->string('course_status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
