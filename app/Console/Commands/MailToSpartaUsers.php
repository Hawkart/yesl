<?php
namespace App\Console\Commands;

use App\Mail\EmailToSpartaUser;
use Mail;
use Storage;
use DB;
use Illuminate\Console\Command;

class MailToSpartaUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:sparta-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send invitations to sparta users.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file_name = 'sparta_users.csv';
        $path = Storage::path($file_name);
        $data = array_map('str_getcsv', file($path));

        foreach($data as $key=>$str)
        {
            if(strpos($str[2], '@sparta.games')===false)
                $this->sendMail($str);
        }
    }

    private function sendMail($u)
    {
        $data = [
            'title' => $u[3],
            'email' => $u[2]
        ];

        dd($data);
        //Mail::to($data['email'])->send(new EmailToSpartaUser($data));
    }
}
