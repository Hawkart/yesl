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
            $table->string('message_ex_id')->nullable();
            $table->boolean('is_send')->default(0);
            $table->string('subject')->nullable();
            $table->integer('sender_id')->nullable();
            $table->string('sender_type')->nullable();
            $table->integer('recipient_id')->nullable();
            $table->string('recipient_type')->nullable();
            $table->text('body');
            $table->text('attachments')->nullable();
            $table->text('json')->nullable();
            $table->integer('reply_id')->nullable();
            $table->boolean('is_read')->default(0);
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
