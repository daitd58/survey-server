<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Officers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('officers', function (Blueprint $table) {
		    $table->increments('id');
		    $table->tinyInteger('isAdmin');
		    $table->tinyInteger('isLecturer');
		    $table->string('fullname');
		    $table->string('otherEmail');
		    $table->string('phoneNumber');
		    $table->string('avatarUrl');
		    $table->string('officerCode');
		    $table->string('class');
		    $table->string('office');
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
        Schema::drop('officers');
    }
}
