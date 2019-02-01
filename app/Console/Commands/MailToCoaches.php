<?php
namespace App\Console\Commands;

use App\Mail\EmailToCoach;
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
        $data = [
            [
                'email' => 'jbuchan3@ashland.edu',
                'title' => 'Josh Buchanan'
            ],
            [
                'email' => 'omanzano@averett.edu',
                'title' => 'Oscar Manzano'
            ],
            [
                'email' => 'arogers@bellevue.edu',
                'title' => 'Alex Rogers'
            ],
            [
                'email' => 'jerry.forbes@brescia.edu',
                'title' => 'JERRY FORBES'
            ],
            [
                'email' => 'jtalves@campbellsville.edu',
                'title' => 'JORDAN ALVES'
            ],
            [
                'email' => 'ccomino@cazenovia.edu',
                'title' => 'CHRIS COMINO'
            ],
            [
                'email' => 'dsledge@centralmethodist.edu',
                'title' => 'DONALD SLEDGE'
            ],
            [
                'email' => 'bob.peters@centralia.edu',
                'title' => 'Bob Peters'
            ],
            [
                'email' => 'jared.fayne@ccuniversity.edu',
                'title' => 'Jared Fayne'
            ],
            [
                'email' => 'jrudy@coker.edu',
                'title' => 'Joseph Rudy'
            ],
            [
                'email' => 'chris.towle@csj.edu',
                'title' => 'Chris Towle'
            ],
            [
                'email' => 'blclark@fontbonne.edu',
                'title' => 'Brandon Clark'
            ],
            [
                'email' => 'bdicker@gsu.edu',
                'title' => 'Brennen Dicker'
            ],
            [
                'email' => 'justin.bragg@ic.edu',
                'title' => 'JUSTIN BRAGG'
            ],
            [
                'email' => 'ragsdell@midlandu.edu',
                'title' => 'NATHAN RAGSDELL'
            ],
            [
                'email' => 'longj33@erau.edu',
                'title' => 'Jaime Long'
            ],
            [
                'email' => 'eSports@flsouthern.edu',
                'title' => 'Nate Carson'
            ],
            [
                'email' => 'blclark@fontbonne.edu',
                'title' => 'Brandon Clark'
            ],
            [
                'email' => 'gsathletics@georgiasouthern.edu',
                'title' => 'TOM KLEINLEIN'
            ],
            [
                'email' => 'Scott.Coval@desales.edu',
                'title' => 'SCOTT COVAL'
            ]
        ];

        foreach($data as $coach)
        {
            $coach['title'] = mb_convert_case($coach['title'], MB_CASE_TITLE);
            Mail::to($coach['email'])->send(new EmailToCoach($coach));
        }
    }
}