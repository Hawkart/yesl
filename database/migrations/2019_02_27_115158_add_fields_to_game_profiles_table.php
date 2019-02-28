<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToGameProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('rank');
            $table->string('peak_rank')->nullable();
            $table->string('additional_link')->nullable();
            $table->string('rank_image')->nullable();
            $table->text('progress')->nullable();
            $table->string('streaming_link')->nullable();
            $table->boolean('have_banned')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'rank', 'peak_rank', 'additional_link', 'rank_image', 'progress', 'streaming_link', 'have_banned'
            ]);
        });
    }
}
