<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'comments';

    /**
     * Run the migrations.
     * @table comments
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('comment');
            $table->integer('active')->default('0');
            $table->unsignedInteger('post_id');
            $table->integer('reply_id')->default('0');
            $table->string('url', 191);
            $table->unsignedInteger('user_id');

            $table->index(["post_id"], 'comments_posts_id_foreign_idx');

            $table->index(["user_id"], 'comments_user_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('user_id', 'comments_user_id_foreign')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('post_id', 'comments_posts_id_foreign_idx')
                ->references('id')->on('posts')
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
