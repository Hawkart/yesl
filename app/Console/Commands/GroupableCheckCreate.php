<?php
namespace App\Console\Commands;

use App\Models\Game;
use App\Models\University;
use App\Models\GameUniversity;
use App\Models\GroupUser;
use App\Models\User;
use App\Models\Group;
use Illuminate\Console\Command;
use Storage;
use DB;

class GroupableCheckCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'groups:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import games and genres from Twitch and Giantbomb.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::statement("SET foreign_key_checks=0");
        Group::truncate();
        GroupUser::truncate();
        DB::statement("SET foreign_key_checks=1");

        $universities = University::where('nace', 1)->get();

        foreach($universities as $university)
        {
            if($university->group()->count()==0)
            {
                $user = User::where('role_id', 1)->first();

                $group = Group::create([
                    'image' => $university->logo,
                    'cover' => $university->overlay,
                    'title' => $university->title,
                    'owner_id' => $user->id,
                    'groupable_type' => 'App\Models\University',
                    "groupable_id" => $university->id
                ]);

                $user->groups()->attach($group->id);
            }
        }

        $games = Game::all();
        foreach($games as $game)
        {
            if($game->group()->count()==0)
            {
                $user = User::where('role_id', 1)->first();

                $group = Group::create([
                    'title' => $game->title,
                    'image' => $game->logo,
                    'owner_id' => $user->id,
                    'groupable_type' => 'App\Models\Game',
                    "groupable_id" => $game->id
                ]);

                $user->groups()->attach($group->id);
            }
        }

        $gameUniversities = GameUniversity::all();
        foreach($gameUniversities as $gameUniversity)
        {
            if($gameUniversity->group()->count()==0)
            {
                $user = User::where('role_id', 1)->first();

                $group =  Group::create([
                    'title' => $gameUniversity->university->title.". ".$gameUniversity->game->title,
                    'owner_id' => $user->id,
                    'groupable_type' => 'App\Models\GameUniversity',
                    "groupable_id" => $gameUniversity->id
                ]);

                $user->groups()->attach($group->id);
            }
        }
    }
}