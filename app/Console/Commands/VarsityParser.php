<?php
namespace App\Console\Commands;

use App\Mail\EmailToVarsityUser;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use App\Models\VarsityUser;
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

        $this->migrateToDb();
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
                    $user = $this->add($res);

                    if(!empty($user->email))
                        Mail::to($user->email)->send(new EmailToVarsityUser($user));
                }

                usleep(200000); //0,2 sec
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
     * @return int
     */
    private function getLastUserId()
    {
        if($u = VarsityUser::all()->last())
            return $u->varsity_id;

        return 0;
    }

    /**
     * Migrate from file to DB
     */
    private function migrateToDb()
    {
        if(VarsityUser::all()->count()==0)
        {
            $path = $this->getFilePath();
            $content = json_decode(file_get_contents($path), true);

            foreach($content as $key=>$res)
            {
                $this->add($res);
            }
        }
    }

    /**
     * @param $res
     */
    private function add($res)
    {
        if(isset($res['user']))
        {
            $user = $res['user'];

            if (VarsityUser::where('varsity_id', $user['id'])->count() == 0 && isset($user['name']))
            {
                $name = stristr($user['name'], '"') !== false ? stristr($user['name'], '"', true) : $user['name'];
                $nickname = $user['name'];

                if (preg_match('/"([^"]+)"/', $user['name'], $m))
                    $nickname = $m[1];

                if(strlen($nickname)>100)
                    $nickname = substr($nickname, 0, 100);

                if(strlen($name)>100)
                    $name = substr($name, 0, 100);

                echo $nickname."\n";

                return VarsityUser::create([
                    'varsity_id' => $user['id'],
                    'name' => trim($name),
                    'nickname' => $nickname,
                    'email' => isset($user['email']) ? $user['email'] : '',
                    'club_id' => count($res['clubs']) > 0 ? $res['clubs'][0]['clubId'] : 0,
                    'json' => $res
                ]);
            }
        }

        return false;
    }

    /**
     * Delete duplicate users
     */
    private function checkToDelete()
    {
        VarsityUser::chunk(100, function($users)
        {
            foreach ($users as $user)
            {
                $delUsers = VarsityUser::where('varsity_id', $user['varsity_id'])
                    ->where('id', '<>', $user->id);

                if($delUsers->count()>0)
                {
                    foreach($delUsers->get() as $delUser)
                    {
                        $delUser->delete();
                    }
                }
            }
        });
    }
}
