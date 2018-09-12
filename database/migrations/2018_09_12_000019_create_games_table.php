<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'games';

    /**
     * Run the migrations.
     * @table games
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->tinyInteger('active')->default('1');
            $table->unsignedInteger('giantbomb_id');
            $table->unsignedInteger('twitch_id');
            $table->unsignedInteger('genre_id');
            $table->string('title', 191);
            $table->string('alias', 191)->nullable()->default(null);
            $table->text('images')->nullable()->default(null);
            $table->string('logo', 191)->nullable()->default(null);
            $table->text('body')->nullable()->default(null);
            $table->string('site_url', 191)->nullable()->default(null);
            $table->text('rules')->nullable()->default(null);
            $table->unsignedInteger('video_count')->default('0');
            $table->tinyInteger('online')->default('1');
            $table->unsignedInteger('min_players')->default('2');
            $table->string('overlay', 191)->nullable()->default(null);
            $table->unsignedInteger('cross_block')->default('3');
            $table->string('social_provider', 191)->nullable()->default(null);
            $table->string('logo_mini', 191)->nullable()->default(null);

            $table->index(["genre_id"], 'games_genre_id_foreign');

            $table->unique(["title"], 'games_title_unique');


            $table->foreign('genre_id', 'games_genre_id_foreign')
                ->references('id')->on('genres')
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
