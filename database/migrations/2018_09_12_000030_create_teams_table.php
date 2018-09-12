<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'teams';

    /**
     * Run the migrations.
     * @table teams
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 191);
            $table->string('slug', 191);
            $table->string('image', 191)->nullable()->default(null);
            $table->unsignedInteger('capt_id');
            $table->unsignedInteger('quantity');
            $table->string('overlay', 191)->nullable()->default(null);
            $table->unsignedInteger('game_id')->nullable()->default(null);
            $table->unsignedTinyInteger('status')->default('0');
            $table->integer('count_wins')->default('0');
            $table->integer('count_losses')->default('0');
            $table->integer('count_fights')->default('0');
            $table->text('schedule')->nullable()->default(null);
            $table->unsignedInteger('created_id');
            $table->unsignedInteger('coach_id')->nullable()->default(null);
            $table->unsignedInteger('university_id')->nullable()->default('0');

            $table->index(["coach_id"], 'teams_coach_id_foreign_idx');

            $table->index(["game_id"], 'teams_game_id_foreign');

            $table->index(["capt_id"], 'teams_capt_id_foreign');

            $table->unique(["title"], 'teams_title_unique');
            $table->nullableTimestamps();


            $table->foreign('coach_id', 'teams_coach_id_foreign_idx')
                ->references('id')->on('profiles')
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
