<?php
namespace App\Console\Commands;

use App\Models\User;
use App\Models\University;
use App\Models\GroupUser;
use Illuminate\Console\Command;
use DB;

class DeleteUserPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:delete-posts
                        {user_id : The ID of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users poosts and connections(likes, comments, reposts).';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $uid = $this->argument('user_id');
        $user = User::findOrFail($uid);

        $posts = $user->posts();


        DB::statement("SET foreign_key_checks=0");

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

        DB::statement("SET foreign_key_checks=1");
    }
}
