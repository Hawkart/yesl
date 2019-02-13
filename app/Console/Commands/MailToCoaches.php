<?php
namespace App\Console\Commands;

use App\Mail\EmailToCoach;
use App\Models\University;
use Mail;
use Storage;
use DB;
use Illuminate\Console\Command;

class MailToCoaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:coaches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send to coaches.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $universities = University::nace()->get();

        foreach($universities as $university)
        {
            if($university->group()->count()>0)
            {
                $coach = [];

                if(strpos($university->group->owner->email, '@campusteam.tv')===false)
                {
                    $coach = [
                        'title' => $university->group->owner->name,
                        'email' => $university->group->owner->email
                    ];
                } else if($university->group->coach_name)
                {
                    $coach = [
                        'title' => $university->group->coach_name,
                        'email' => $university->group->coach_email
                    ];
                }

                if(count($coach)>0)
                {
                    $coach['title'] = mb_convert_case($coach['title'], MB_CASE_TITLE);
                    Mail::to($coach['email'])->send(new EmailToCoach($coach));
                }
            }
        }
    }
}
