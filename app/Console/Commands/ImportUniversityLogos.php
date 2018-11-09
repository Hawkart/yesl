<?php
namespace App\Console\Commands;

use App\Models\University;
use App\Models\Group;
use App\Models\GroupUser;
use Illuminate\Console\Command;
use Storage;

class ImportUniversityLogos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'university:import-logos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import USA University logos.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = University::all();

        $directory = 'public/universities';
        $files = Storage::allFiles($directory);

        foreach($data as $university)
        {
            $ope_id = $university['ope6_id'];

            $image = '';
            $head = '';
            foreach($files as $file)
            {
                $imagename = basename($file);

                if(strpos($imagename, $ope_id.'.')!== false)
                {
                    $image = 'universities/'.$imagename;
                }

                if(strpos($imagename, $ope_id.'_head')!== false)
                {
                    $head = 'universities/'.$imagename;
                }
            }

            if(!empty($image) || !empty($head))
            {
                echo $university['title']."\r\n";

                $university->update([
                    'logo' => $image,
                    'overlay' => $head
                ]);

                if($university->group()->count()>0)
                {
                    $group = $university->group;
                    $group->update([
                        'image' =>  $image,
                        'cover' => $head
                    ]);
                }
            }
        }
    }
}