<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'profiles';

    /**
     * Run the migrations.
     * @table profiles
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nickname', 191);
            $table->tinyInteger('type');
            $table->unsignedInteger('game_id')->default('0');
            $table->unsignedInteger('user_id');
            $table->string('link')->nullable();

            $table->index(["game_id"], 'profiles_game_id_foreign');

            $table->index(["user_id"], 'profiles_user_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('game_id', 'profiles_game_id_foreign')
                ->references('id')->on('games')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_id', 'profiles_user_id_foreign')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->softDeletes();
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
