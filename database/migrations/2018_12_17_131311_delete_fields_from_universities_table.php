<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteFieldsFromUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropColumn(['coach_id', 'coach_name', 'coach_email']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mailbox_email', 'mailbox_password']);
        });

        Schema::dropIfExists('mailboxes');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('universities', function (Blueprint $table) {
            //
        });
    }
}
