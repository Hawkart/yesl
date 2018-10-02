<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateNewPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("SET foreign_key_checks=0");
        Schema::dropIfExists('posts');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('comments');
        DB::statement("SET foreign_key_checks=1");

        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('group_id')->nullbale();
            //$table->text('attachments')->nullbale();
            $table->text('text')->nullbale();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('reply_id')->index()->nullable();
            $table->text('comment');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('likeable');
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->primary(['likeable_type', 'likeable_id', 'user_id']);
        });

        Schema::create('post_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('attachable');
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('CASCADE');
        });

        Schema::create('comment_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('attachable');
            $table->integer('comment_id')->unsigned();
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('post_attachments');
        Schema::dropIfExists('comment_attachments');
    }
}
