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

        $file_name = 'universities.csv';    //change name of file!!!
        $path = Storage::path($file_name);
        $data = array_map(function($v){
            return str_getcsv($v, ";");
        }, file($path));

        foreach($data as $key=>$str)
        {
            if($key==0) continue;

            //change numbers of cals according to table!!!
            $unitid = $str[1];
            $email = $str[3];
            $name = $str[4];

            if(isset($universities[$unitid]))
                $this->createCoach($universities[$unitid], $email, $name);
        }
    }

    private function createCoach($id, $email, $name)
    {
        $university = University::firstOrFail($id);

        $user = new User();
        $user->create([
            'name' => $name,
            'first_name' => '',
            'last_name' => '',
            'type' => 2,
            'email' => $email,
            'university_id' => $university->id,
            'precreated' => true,
            'password' => Hash::make(str_random(10)),
            'gender' => 1,
            'date_birth' => Carbon::today(),
            'confirmation_code' => str_random(10)
        ]);
    }
}