<?php
namespace App\Console\Commands;

use App\Mail\EmailDigestNews;
use App\Models\News;
use Mail;
use Storage;
use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MailCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check emails.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $emails = ['segezhagroup.it@gmail.com', 'veronika.ilchenko@gmail.com', 'campus.team.tv@gmail.com'];
        $domains = ['campusteam.info', 'campusteam.net', 'collegeteam.info'];

        foreach($emails as $email)
        {
            foreach($domains as $domain)
            {
                $from = "info@".$domain;
                $name = "Campusteam crew";

                echo $from."\n";

                Mail::raw("Testing of Campusteam mail", function ($message) use ($email, $from, $name) {
                    $message->to($email)
                        ->from($from, $name)
                        ->subject("Testing of Campusteam mail");
                });
            }
        }

    }
}
