<?php
namespace App\Console\Commands;

use App\Models\University;
use App\Models\Major;
use App\Models\MajorUniversity;
use Illuminate\Console\Command;
use Storage;
use DB;

class ImportMajors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'major:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import majors.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*$ids = University::where('nace', 1)->pluck('score_id')->toArray();
        $units = $this->importMajorUniversity();
        $units = array_unique($units);
        $a = array_intersect($ids, $units);
        dd(count($a));*/

        $this->importMajor();
        $this->importMajorUniversity();
    }

    private function importMajor()
    {
        $file_name = 'valuesets16.csv';
        $path = Storage::path($file_name);
        $variables = ['CIPCODE'];
        $exludevalues = [-1, -2];
        $data = array_map(function($v){
                return str_getcsv($v, ";");
            }, file($path));

        foreach($data as $key=>$str)
        {
            if($key==0) continue;

            if(in_array($str[2], $variables) && !in_array($str[3], $exludevalues))
            {
                $this->addMajor($str);
            }
        }
    }

    private function importMajorUniversity()
    {
        $universities = University::pluck('id', 'score_id')->toArray();
        $majors = Major::pluck('id', 'code')->toArray();

        $file_name = 'C2016_A.csv';
        $path = Storage::path($file_name);
        $exludeValues = [-1, -2];
        $data = array_map(function($v){
            return str_getcsv($v, ";");
        }, file($path));

        $units = [];
        foreach($data as $key=>$str)
        {
            if($key==0) continue;

            $unitid = $str[0];
            $valueCode = $str[1];
            $units[] = $unitid;

            if(isset($universities[$unitid]) && isset($majors[$valueCode]))
            {
                $this->addMajorUniversity($majors[$valueCode], $universities[$unitid]);
            }
        }
    }

    private function addMajor($str)
    {
        if(!empty($str[3]) && Major::where('code', $str[3])->count()==0)
        {
            Major::create([
                'title' => $str[4],
                'code' => $str[3]
            ]);
        }
    }

    private function addMajorUniversity($major, $university)
    {
        if(MajorUniversity::where('major_id', $major)->where('university_id', $university)->count()==0)
        {
            MajorUniversity::create([
                'major_id' => $major,
                'university_id' => $university
            ]);
        }
    }
}