<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('udata_id')->unsigned();
            $table->integer('profile_id')->unsigned();
            $table->integer('vacancy_id')->unsigned();
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('udata_id')->references('id')->on('udatas')->onDelete('CASCADE');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('CASCADE');
            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
