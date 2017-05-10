<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Learners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('learners', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('type');
		    $table->string('fullname');
		    $table->string('otherEmail');
		    $table->string('phoneNumber');
		    $table->string('avatarUrl');
		    $table->string('class');
		    $table->string('learnerCode');
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
	    Schema::drop('learners');
    }
}
