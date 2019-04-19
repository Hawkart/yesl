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
            ->limit(4);

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
        $c = "App\\Models\\".$cname;

        $unsubscribed = ['david.balvantin@headwaters.org', "ericmaw0@icloud.com", "ivanszasz@icloud.com", "jackson_mcknight@yahoo.com",
            "jacobd900@yahoo.com", "jorgeny11@icloud.com", "matthewhurt99@yahoo.com", "xdaltonlovex@outlook.com"];

        $c::athletes()->chunk(200, function ($users) use ($sendedEmails, $news, $cname, $unsubscribed)
        {
            foreach ($users as $user)
            {
                if(filter_var($user->email, FILTER_VALIDATE_EMAIL) && !in_array($user->email, $sendedEmails) && strpos($user->email, '@gmail')===false)
                {
                    if(strpos($user->email, 'highschoolesportsleague.com')===false &&
                        strpos($user->email, 'varsityesports.com')===false &&
                        !in_array($user->email, $unsubscribed) &&
                        ($cname!="VarsityUser" || (
                            $cname=="VarsityUser" &&
                            $user->varsity_id<=41000 &&
                            (
                                !isset($user->json['school_details']['school_year']) ||
                                (isset($user->json['school_details']['school_year']) && $user->json['school_details']['school_year']!='staff')
                            )
                        ))
                    )
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
            }
        });

        return $sendedEmails;
    }
}
