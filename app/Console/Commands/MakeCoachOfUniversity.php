<?php
namespace App\Console\Commands;

use App\Models\User;
use App\Models\University;
use App\Models\GroupUser;
use Illuminate\Console\Command;

class MakeCoachOfUniversity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'groups:make-as-coach
                        {user_id : The ID of the user}
                        {university_id : The ID of the university}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make user the coach of university group.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $uid = $this->argument('user_id');
        $unid = $this->argument('university_id');

        $user = User::findOrFail($uid);
        $university = University::findOrFail($unid);

        $user->type = 2;
        $user->university_id = $unid;
        $user->save();

        if($university->group()->count()>0)
        {
            $group = $university->group;
            $group->owner_id = $user->id;
            $group->save();

            if(GroupUser::where('user_id', $user->id)->where('group_id', $group->id)->count()==0)
            {
                $user->groups()->attach($group->id);
            }
        }
    }
}
