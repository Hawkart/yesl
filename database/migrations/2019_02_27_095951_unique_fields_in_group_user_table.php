<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\GroupUser;

class UniqueFieldsInGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('group_users'))
            Schema::rename('group_users', 'group_user');

        $this->deleteDuplicates();

        Schema::table('group_user', function (Blueprint $table) {
            $table->unique(['group_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_user', function (Blueprint $table) {
            $table->dropUnique(['group_id', 'user_id']);
        });
    }

    /**
     * Delete duplicate GroupUsers records
     */
    private function deleteDuplicates()
    {
        $gus = GroupUser::all();
        $uniqueRecords = [];
        $needDelete = [];
        foreach($gus as $gu)
        {
            $ind = $gu->group_id." ".$gu->user_id;

            if(!in_array($ind, $uniqueRecords))
                $uniqueRecords[] = $ind;
            else
                $needDelete[] = $gu->id;
        }

        if(count($needDelete)>0)
            GroupUser::whereIn('id', $needDelete)->delete();
    }
}
