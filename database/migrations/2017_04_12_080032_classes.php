<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Classes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('classes', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('survey_id');
		    $table->string('subject_id');
		    $table->string('teacher_id');
		    $table->string('year');
		    $table->string('semester');
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
        Schema::drop('classes');
    }
}
