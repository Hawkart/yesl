<?php
namespace App\Console\Commands;

use App\Models\University;
use App\Models\Group;
use App\Models\User;
use Illuminate\Console\Command;
use Storage;
use DB;

class UniversityGroupSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'university:group-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync universities and groups.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $openids = University::where('nace', 1)->pluck('ope8_id')->toArray();
        $groups = Group::where('groupable_type', 'App\\Models\\University')->get();
        $user = User::findOrFail(16);

        foreach($groups as $group)
        {
            $university = $group->groupable;

            if(!in_array($university->ope8_id, $openids))
            {
                $this->deleteGroup($group);
            }else{
                if (($key = array_search($university->ope8_id, $openids)) !== false) {
                    unset($openids[$key]);
                }
            }
        }

        if(count($openids)>0)
        {
            foreach($openids as $openid)
            {
                $university = University::where('ope8_id', $openid)->first();
                $group = Group::create([
                    'image' => $university->logo,
                    'cover' => $university->overlay,
                    'title' => $university->title,
                    'owner_id' => $user->id,
                    'groupable_type' => 'App\Models\University',
                    "groupable_id" => $university->id
                ]);

                $user->groups()->attach($group->id);
            }
        }
    }

    /**
     * @param $group
     */
    private function deleteGroup($group)
    {
        DB::statement("SET foreign_key_checks=0");

        $posts = $group->posts();

        if($posts->count()>0)
        {
            foreach($posts->get() as $post)
            {
                $likes = $post->likes();
                if($likes->count()>0)
                {
                    foreach($likes->get() as $like)
                    {
                        $like->delete();
                    }
                }

                $comments = $post->comments();
                if($comments->count()>0)
                {
                    foreach($comments->get() as $comment)
                    {
                        $comment->delete();
                    }
                }

                $reposts = $post->reposts();
                if($reposts->count()>0)
                {
                    foreach($reposts->get() as $repost)
                    {
                        $repost->delete();
                    }
                }

                $post->delete();
            }
        }

        $group->delete();
        DB::statement("SET foreign_key_checks=1");
    }
}
