<?php
namespace App\Console\Commands;

use App\Models\University;
use App\Models\Group;
use App\Models\GroupUser;
use Illuminate\Console\Command;
use Storage;

class ImportUniversityTeamLogos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'university:import-team-logos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import USA University team logos.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = University::all();

        $directory = 'public/teams_logo';
        $files = Storage::allFiles($directory);

        foreach($data as $university)
        {
            $ope_id = $university['ope6_id'];

            $image = '';
            foreach($files as $file)
            {
                $imagename = basename($file);

                if(strpos($imagename, $ope_id.'.')!== false)
                {
                    $image = 'teams_logo/'.$imagename;
                }
            }

            if(!empty($image))
            {
                echo $university['title']."\r\n";

                $university->update([
                    'es_team_image' => $image
                ]);
            }
        }
    }
}