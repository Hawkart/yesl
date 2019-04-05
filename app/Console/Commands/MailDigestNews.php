<?php
namespace App\Console\Commands;

use App\Mail\EmailDigestNews;
use App\Models\News;
use Mail;
use Storage;
use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MailDigestNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:digest-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send digest to users.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sendedEmails = [];

        $from = Carbon::now()->subDays(6)->format('d');

        $news = News::where('status', 1)
            //->whereDay('created_at', '>=', $from)
            ->orderBy('created_at', 'desc')
            ->limit(6);

        if($news->count()>0)
        {
            $news = $news->get();

            foreach(["User", 'VarsityUser'] as $cname)
                $sendedEmails = $this->sendEmail($cname, $sendedEmails, $news);
        }
    }

    /**
     * @param $cname
     * @param $sendedEmails
     * @param $news
     * @return mixed
     */
    private function sendEmail($cname, $sendedEmails, $news)
    {
        $cname = "App\\Models\\".$cname;

        $cname::athletes()->chunk(200, function ($users) use ($sendedEmails, $news)
        {
            foreach ($users as $user)
            {
                if(filter_var($user->email, FILTER_VALIDATE_EMAIL) && !in_array($user->email, $sendedEmails) && strpos($user->email, '@gmail')===false)
                {
                    $data = [
                        'name' => $user->name,
                        'news' => $news
                    ];

                    try {
                        Mail::to($user->email)->send(new EmailDigestNews($data));

                        $sendedEmails[] = $user->email;

                    } catch (\Exception $exception){
                        //echo $exception->getMessage();
                    }
                }
            }
        });

        return $sendedEmails;
    }
}
