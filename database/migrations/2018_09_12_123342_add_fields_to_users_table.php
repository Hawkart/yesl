<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('api_token', 100);
            $table->string('first_name', 191);
            $table->string('last_name', 191);
            $table->string('second_name', 191)->nullable()->default(null);
            $table->string('nickname', 191)->nullable()->default(null);
            $table->tinyInteger('verified')->default('0');
            $table->string('confirmation_code', 191)->nullable()->default(null);
            $table->enum('notify', ['y', 'n'])->default('y');
            $table->string('overlay', 191)->nullable()->default(null);
            $table->string('description', 191)->nullable()->default(null);
            $table->string('timezone', 191)->nullable()->default(null);
            $table->text('contacts')->nullable()->default(null);
            $table->unsignedInteger('university_id')->nullable()->default('0');
            $table->date('date_birth')->nullable()->default(null);
            $table->unsignedTinyInteger('gender')->default('0');

            $table->index(["university_id"], 'users_university_id_foreign');

            $table->unique(["api_token"], 'users_api_token_unique');

            $table->foreign('university_id', 'users_university_id_foreign')
                ->references('id')->on('universities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
