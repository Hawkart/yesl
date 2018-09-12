<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenresTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'genres';

    /**
     * Run the migrations.
     * @table genres
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
            $table->string('title', 191);
            $table->string('image', 191)->nullable()->default(null);
            $table->text('desc')->nullable()->default(null);
            $table->unsignedInteger('video_count')->default('0');

            $table->unique(["title"], 'genres_title_unique');

            $table->unique(["giantbomb_id"], 'genres_giantbomb_id_unique');
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
