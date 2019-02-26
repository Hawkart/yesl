<?php
namespace App\Console\Commands;

use App\Models\GameUniversity;
use App\Models\Team;
use Illuminate\Console\Command;

class ImportFromUniversityAndVacancyToTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teams:import-from-university-vacancy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer university games with vacancies to teams';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $gus = GameUniversity::all();
        foreach($gus as $gu)
        {
            $university = $gu->university;
            $game = $gu->game;
            $vacancies = $university->vacancies;
            $vids = [];

            if(count($vacancies)>0)
                $vids = $vacancies->pluck('game_id')->toArray();

            Team::create([
                'title' => $university->title." ".$game->title,
                'university_id' => $university->id,
                'game_id' => $game->id,
                'players_needed' => in_array($game->id, $vids),
                'status' => Team::STATUS_ACTIVE
            ]);

            echo $university->title."  ".$game->title."\n";
        }
    }
}
