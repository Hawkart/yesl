<?php
namespace App\Console\Commands;

use App\Models\University;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Storage;
use DB;
use Carbon\Carbon;

class ImportTwitts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'university:import-twitts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import twitts to university.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $universities = University::pluck('id', 'ope6_id')->toArray();

        $file_name = 'twitts.csv';
        $path = Storage::path($file_name);
        $data = array_map(function($v){
            return str_getcsv($v, ";");
        }, file($path));

        foreach($data as $key=>$str)
        {
            if($key==0) continue;

            $email = $str[5];
            $name = $str[4];

            $unitid = trim($str[0]);
            $twitts = [];

            foreach([2, 3, 1] as $col)
            {
                if(strpos($str[$col], 'https://twitter.com/')!==false)
                {
                    $twitts[] = str_replace(['?lang=en', 'https://twitter.com/'], '', $str[$col]);
                }else{
                    $twitts[] = '';
                }
            }

            $s = implode(',', $twitts);
            if(isset($universities[$unitid]) && !empty($s))
            {
                $u = University::findOrFail($universities[$unitid]);

                $u->update([
                    'twitter_str' => $s
                ]);

                if($u->group()->count()>0)
                {
                    $u->group->update([
                        'coach_name' => $name,
                        'coach_email' => $email
                    ]);
                }
            }
        }
    }
}
