<?php
namespace App\Console\Commands;

use App\Models\News;
use App\Models\Post;
use Mail;
use Storage;
use DB;
use Illuminate\Console\Command;

class NewsToPostsMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:migrate-to-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate news to the posts.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $news = News::where('status', 1)->get();
        foreach($news as $post)
            Post::createFromNews($post);
    }
}
