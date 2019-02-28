<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResumeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('discord_nickname')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_foreign')->default(false);
            $table->tinyInteger('apply_as')->default(0);
            $table->string('attending_start')->nullable();
            $table->integer('act_scored')->nullable();
            $table->integer('sat_scored')->nullable();
            $table->double('gpa')->nullable();
            $table->integer('transfer_hours')->nullable();

            $table->integer('toefl_paper')->nullable();
            $table->integer('toefl_computer')->nullable();
            $table->integer('toefl_internet')->nullable();

            $table->string('country')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'discord_nickname', 'is_foreign', 'apply_transfer', 'apply_as', 'attending_start',
                'act_scored', 'sat_scored', 'gpa', 'transfer_hours', 'toefl_paper', 'toefl_computer',
                'toefl_internet', 'country', 'street', 'city', 'state', 'postal_code'
            ]);
        });
    }
}
