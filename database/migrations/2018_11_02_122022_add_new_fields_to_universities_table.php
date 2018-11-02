<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->tinyInteger('degrees_awarded_highest')->nullable();
            $table->string('es_team_title')->nullable();
            $table->string('es_team_image')->nullable();
            $table->boolean('nace')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropColumn(['nace', 'degrees_awarded_highest', 'es_team_title', 'es_team_image']);
        });
    }
}
