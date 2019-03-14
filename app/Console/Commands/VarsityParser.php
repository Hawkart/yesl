<?php
namespace App\Console\Commands;

use App\Mail\EmailToVarsityUser;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Storage;
use Mail;

class VarsityParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:varsity-parser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse users from varsity esports.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client(['cookies' => true]);
        $uri = 'https://www.varsityesports.com/api/user/getUserProfile';

        for($userId = 100; $userId < 1000; $userId++)
        {
            echo $userId."\n";
            try {
                $res = $client->post($uri, [
                    'form_params' => [
                        'userId' => $userId//13174
                    ]
                ]);
                $res = json_decode($res->getBody()->getContents(), true);

                if(isset($res['user']))
                {
                    $user = $res['user'];
                    $this->add($res);

                    if(isset($user['email']))
                    {
                        $data = [
                            'name' => stristr($user['name'], '"')!==false ? stristr($user['name'], '"', true) : $user['name']
                        ];
                        if (preg_match('/"([^"]+)"/', $user['name'], $m))
                        {
                            $data['nickname'] = $m[1];
                        }else{
                            $data['nickname'] = $user['name'];
                        }

                        Mail::to($user['email'])->send(new EmailToVarsityUser($data));
                    }
                }

                usleep(300000); //0,3 sec
            } catch (\Exception $e) {

            }
        }
    }

    private function add($data)
    {
        $dir = 'public';
        Storage::makeDirectory($dir);
        $filename = "varsity_users.json";
        $path = storage_path('app/'.$dir.'/'.$filename);

        if(!file_exists($path))
            Storage::disk('local')->put($dir.'/'.$filename, '');

        $content = json_decode(file_get_contents($path), true);
        $content['page'] = $data['user']['id'];
        $content[] = $data;
        file_put_contents($path, json_encode($content));
    }
}
