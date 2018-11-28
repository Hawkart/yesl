<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailboxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('mailbox_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mailbox_id')->unsigned();
            $table->integer('user_id')->nullable();
            $table->integer('user_email')->nullable();
            $table->integer('user_name')->nullable();
            $table->string('subject')->nullable();
            $table->text('body');
            $table->text('attachments');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('mailbox_participants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mailbox_id')->unsigned();
            $table->integer('user_id')->nullable();
            $table->integer('user_email')->nullable();
            $table->integer('user_name')->nullable();
            $table->timestamp('last_read')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('mailboxes');
    }
}
