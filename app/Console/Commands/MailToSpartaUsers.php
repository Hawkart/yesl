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
        $data = array_map(function($v){
            return str_getcsv($v, ";");
        },  file($path));

        $c = 1;
        foreach($data as $key=>$str)
        {
            if(strpos($str[2], '@sparta.games')===false && $c<1000)
            {
                if($c>158 || ($c<158 && $c>75))
                    $this->sendMail($str);

                $c++;
            }
        }
    }

    private function sendMail($u)
    {
        $data = [
            'title' => $u[3],
            'email' => $u[2]
        ];

        if(filter_var($data['email'], FILTER_VALIDATE_EMAIL) )
        {
            try {
                Mail::to($data['email'])->send(new EmailToSpartaUser($data));
            } catch (\Exception $exception){
                //echo $exception->getMessage();
            }
        }
    }
}
