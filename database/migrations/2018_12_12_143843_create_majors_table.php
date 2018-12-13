<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMajorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('code');
            $table->integer('sort')->nullable()->default(0);
        });

        Schema::create('major_university', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('major_id')->unsigned();
            $table->integer('university_id')->unsigned();

            $table->foreign('major_id')->references('id')->on('majors')->onDelete('CASCADE');
            $table->foreign('university_id')->references('id')->on('universities')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('majors');
        Schema::dropIfExists('major_university');
    }
}
