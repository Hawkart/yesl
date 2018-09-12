<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToPostsTable extends Migration
{
    /**
     * Run the migrations.
     * @table posts
     *
     * @return void
     */
    public function up()
    {
		Schema::table('posts', function (Blueprint $table) {
            $table->unsignedInteger('university_id')->nullable()->default('0');
			$table->index('university_id');
            $table->foreign('university_id')->references('id')->on('universities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
		 Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['university_id']);
			$table->dropForeign(['university_id']);			
        });
     }
}
