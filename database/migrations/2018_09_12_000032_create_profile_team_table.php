<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileTeamTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'profile_team';

    /**
     * Run the migrations.
     * @table profile_team
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('profile_id');
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('sender_id');
            $table->unsignedTinyInteger('status')->default('0');
            $table->timestamp('start_at')->nullable()->default(null);
            $table->timestamp('end_at')->nullable()->default(null);

            $table->index(["profile_id"], 'profile_team_profile_id_foreign');

            $table->index(["team_id"], 'profile_team_team_id_foreign');

            $table->index(["sender_id"], 'profile_team_sender_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('profile_id', 'profile_team_profile_id_foreign')
                ->references('id')->on('profiles')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('sender_id', 'profile_team_sender_id_foreign')
                ->references('id')->on('profiles')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('team_id', 'profile_team_team_id_foreign')
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
