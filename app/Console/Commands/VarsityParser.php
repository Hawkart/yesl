<?php
namespace App\Console\Commands;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Storage;

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

        for($userId = 1; $userId < 100; $userId++)
        {
            echo $userId."\n";
            try {
                $res = $client->post($uri, [
                    'form_params' => [
                        'userId' => $userId//13174
                    ]
                ]);
                $res = json_decode($res->getBody()->getContents(), true);
                //print_r($res);

                if(isset($res['user']))
                {
                    $user = $res['user'];   //name, email
                    $this->add($res);
                }

                sleep(1);
            } catch (\Exception $e) {
               break;
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
        $content[] = $data;
        file_put_contents($path, json_encode($content));
    }
}
