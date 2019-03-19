<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {

            $table->dropForeign(['udata_id']);
            $table->dropForeign(['vacancy_id']);
            $table->dropColumn(['udata_id', 'vacancy_id']);

            $table->text('message')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('team_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('CASCADE');
        });

        Schema::dropIfExists('udatas');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['team_id']);
            $table->dropColumn(['user_id', 'team_id']);

            $table->integer('udata_id')->unsigned();
            $table->integer('vacancy_id')->unsigned();
            $table->foreign('udata_id')->references('id')->on('udatas')->onDelete('CASCADE');
            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('CASCADE');
        });
    }
}
