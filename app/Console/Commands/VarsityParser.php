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

        $userId = intval($this->getLastUserId())+1;
        while($userId>0)
        {
            echo $userId."\n";
            try {
                $res = $client->post($uri, [
                    'form_params' => [
                        'userId' => $userId
                    ]
                ]);
                $res = json_decode($res->getBody()->getContents(), true);

                if($res==null)
                    break;

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

                usleep(200000); //0,3 sec
                $userId++;
            } catch (\Exception $e) {

            }
        }
    }

    /**
     * @return string
     */
    protected function getFilePath()
    {
        $dir = 'public';
        Storage::makeDirectory($dir);
        $filename = "varsity_users.json";
        $path = storage_path('app/'.$dir.'/'.$filename);

        if(!file_exists($path))
            Storage::disk('local')->put($dir.'/'.$filename, '');

        return $path;
    }

    /**
     * @param $data
     */
    private function add($data)
    {
        $path = $this->getFilePath();
        $content = json_decode(file_get_contents($path), true);
        $content['page'] = $data['user']['id'];
        $content[] = $data;
        file_put_contents($path, json_encode($content));
    }

    /**
     * @return int
     */
    private function getLastUserId()
    {
        $path = $this->getFilePath();
        $content = json_decode(file_get_contents($path), true);
        return $content['page'] ? $content['page'] : 0;
    }
}
