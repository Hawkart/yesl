<?php
namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Genre;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\GameController;
use Illuminate\Console\Command;
use Storage;
use DB;

class ImportGamesAndGenres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games:import';

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
        //Genre::truncate();
        //Game::truncate();
        DB::statement("SET foreign_key_checks=1");

        //$genreClass = new GenreController();
        //$genreClass->importByGiantbomb();

        $gameClass = new GameController();
        $gameClass->importByTwitchGiantbomb();
        $gameClass->deleteNotAllowed();
    }
}
