<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMajorProgrammeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('major_programme', function (Blueprint $table) {
            $table->id();
            $table->string('programme_code');
            $table->foreign('programme_id')->references('id')->on('programmes');
            $table->string('major_code');
            $table->foreign('major_id')->references('id')->on('major');
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
        Schema::dropIfExists('major_programme');
    }
}
