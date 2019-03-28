<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVarsityusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('varsityusers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('varsity_id');
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->string('email')->nullable();
            $table->integer("club_id")->nullable();
            $table->text("json");

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
        Schema::dropIfExists('varsityusers');
    }
}
