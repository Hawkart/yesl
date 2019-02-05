<?php
namespace App\Console\Commands;

use App\Models\University;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Storage;
use DB;
use Carbon\Carbon;

class ImportCoaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'university:import-coaches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import coaches to university.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $universities = University::nace()->pluck('id', 'ope6_id')->toArray();

        $file_name = 'coaches.csv';
        $path = Storage::path($file_name);
        $data = array_map(function($v){
            return str_getcsv($v, ";");
        }, file($path));

        foreach($data as $key=>$str)
        {
            $unitid = $str[0];
            $email = $str[2];
            $name = $str[1];

            if(isset($universities[$unitid]))
            {
                $u = University::findOrFail($universities[$unitid]);
                if($u->group->count()>0)
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
