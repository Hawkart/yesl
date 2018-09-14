<?php
namespace App\Console\Commands;

use App\Models\University;
use Illuminate\Console\Command;
use Storage;
use DB;

class ImportUsaUniversities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'university:import-usa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import USA University.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::statement("SET foreign_key_checks=0");
        University::truncate();
        DB::statement("SET foreign_key_checks=1");

        $file_name = 'colleges.csv';
        $path = Storage::path($file_name);
        $data = array_map('str_getcsv', file($path));

        foreach($data as $key=>$str)
        {
            if($key==0)  continue;
            $this->addUniversity($str);
        }
    }

    private function addUniversity($university)
    {
        if(University::where('title', $university[1])->count()==0)
        {
            $url = $university[11];
            $domain = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));

            University::create([
                'title' => $university[1],
                'url' => $url,
                'address' => $university[2].", ".$university[7],
                'domain' => $domain,
                'json' => $university
            ]);
        }
    }
}