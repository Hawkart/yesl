<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFightTeamTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'fight_team';

    /**
     * Run the migrations.
     * @table fight_team
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('fight_id');
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('status')->default('0');
            $table->string('extern_match_id', 191)->nullable()->default(null);
            $table->string('twitch_link', 191)->nullable()->default(null);
            $table->text('match_result')->nullable()->default(null);

            $table->index(["fight_id"], 'fight_team_fight_id_foreign');

            $table->index(["team_id"], 'fight_team_team_id_foreign');


            $table->foreign('fight_id', 'fight_team_fight_id_foreign')
                ->references('id')->on('fights')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('team_id', 'fight_team_team_id_foreign')
                ->references('id')->on('teams')
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
