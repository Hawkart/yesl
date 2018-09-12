<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tournaments';

    /**
     * Run the migrations.
     * @table tournaments
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('parent_id')->nullable()->default(null);
            $table->unsignedInteger('game_id');
            $table->string('title', 191);
            $table->timestamp('start_at')->nullable()->default(null);
            $table->timestamp('end_at')->nullable()->default(null);
            $table->decimal('buy_in', 8, 2);
            $table->unsignedInteger('prize_pool')->default('0');
            $table->unsignedTinyInteger('count_teams')->default('8');
            $table->unsignedTinyInteger('min_teams')->default('4');
            $table->unsignedTinyInteger('count_wins')->default('1');
            $table->text('description')->nullable()->default(null);
            $table->text('rules')->nullable()->default(null);
            $table->string('image', 191)->nullable()->default(null);
            $table->tinyInteger('is_multiple')->default('1');
            $table->unsignedTinyInteger('status')->default('0');
            $table->string('promocode', 191)->nullable()->default(null);
            $table->timestamp('contract_start_at')->nullable()->default(null);
            $table->timestamp('contract_end_at')->nullable()->default(null);
            $table->timestamp('final_at')->nullable()->default(null);
            $table->string('period', 191)->nullable()->default(null);
            $table->string('period_start_at', 191)->nullable()->default(null);
            $table->string('period_final_at', 191)->nullable()->default(null);
            $table->string('period_register_at', 191)->nullable()->default(null);
            $table->timestamp('register_start')->nullable()->default(null);
            $table->string('winners_part', 191);
            $table->text('terms')->nullable();

            $table->index(["game_id"], 'tournaments_game_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('game_id', 'tournaments_game_id_foreign')
                ->references('id')->on('games')
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
