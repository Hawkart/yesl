<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamTournamentTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'team_tournament';

    /**
     * Run the migrations.
     * @table team_tournament
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('tournament_id');
            $table->unsignedInteger('team_id');
            $table->unsignedTinyInteger('place');

            $table->index(["tournament_id"], 'team_tournament_tournament_id_foreign');

            $table->index(["team_id"], 'team_tournament_team_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('team_id', 'team_tournament_team_id_foreign')
                ->references('id')->on('teams')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('tournament_id', 'team_tournament_tournament_id_foreign')
                ->references('id')->on('tournaments')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
