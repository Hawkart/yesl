<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFightsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'fights';

    /**
     * Run the migrations.
     * @table fights
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('game_id');
            $table->string('title', 191);
            $table->unsignedInteger('created_id');
            $table->unsignedInteger('count_parts');
            $table->timestamp('start_at')->nullable()->default(null);
            $table->timestamp('end_at')->nullable()->default(null);
            $table->unsignedInteger('judge_id')->nullable()->default(null);
            $table->unsignedInteger('commentator_id')->nullable()->default(null);
            $table->unsignedInteger('winner_id')->nullable()->default(null);
            $table->text('result')->nullable()->default(null);
            $table->tinyInteger('changed_time')->default('0');
            $table->text('cancel_text')->nullable()->default(null);
            $table->unsignedInteger('cancel_user_id')->nullable()->default(null);
            $table->unsignedInteger('created_team_id')->nullable()->default(null);
            $table->decimal('bet', 8, 2);
            $table->unsignedTinyInteger('status')->default('0');
            $table->string('extern_match_id', 191)->nullable()->default(null);
            $table->text('extern_statistic')->nullable()->default(null);
            $table->unsignedInteger('tournament_id')->nullable()->default('0');
            $table->integer('tournament_step')->nullable()->default(null);

            $table->index(["commentator_id"], 'fights_commentator_id_foreign');

            $table->index(["created_team_id"], 'fights_created_team_id_foreign');

            $table->index(["cancel_user_id"], 'fights_cancel_user_id_foreign_idx');

            $table->index(["tournament_id"], 'fights_tournaments_id_foreign_idx');

            $table->index(["game_id"], 'fights_game_id_foreign');

            $table->index(["judge_id"], 'fights_judge_id_foreign');

            $table->index(["created_id"], 'fights_created_id_foreign_idx');
            $table->nullableTimestamps();


            $table->foreign('cancel_user_id', 'fights_cancel_user_id_foreign_idx')
                ->references('id')->on('profiles')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('commentator_id', 'fights_commentator_id_foreign')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('created_id', 'fights_created_id_foreign_idx')
                ->references('id')->on('profiles')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('created_team_id', 'fights_created_team_id_foreign')
                ->references('id')->on('teams')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('game_id', 'fights_game_id_foreign')
                ->references('id')->on('games')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('judge_id', 'fights_judge_id_foreign')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('tournament_id', 'fights_tournaments_id_foreign_idx')
                ->references('id')->on('tournaments')
                ->onDelete('no action')
                ->onUpdate('no action');
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
