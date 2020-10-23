<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('leads_name');
            $table->string('leads_email');
            $table->string('leads_phone');
            $table->string('leads_ic');
            $table->string('leads_source');
            $table->string('leads_prog1'); 
            $table->string('leads_prog2'); 
            $table->string('leads_prog3'); 
            $table->id('leads_status');
            $table->id('created_by'); 
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
        Schema::dropIfExists('leads');
    }
}
