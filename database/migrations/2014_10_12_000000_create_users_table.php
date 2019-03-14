<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); //concatenate fms name
            $table->string('fname');
            $table->string('mname');
            $table->string('sname');
            $table->date('start_of_employment');
            $table->string('dep_id');
            $table->string('class_id');
            $table->string('accesslvl_id');
            $table->string('sched_id');
            $table->time('req_time_in');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
