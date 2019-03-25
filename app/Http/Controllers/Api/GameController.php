<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use \GiantBomb\Client\GiantBombClient;
use App\Acme\Helpers\TwitchHelper;
use Illuminate\Support\Str;
use App\Models\Genre;
use App\Models\Game;
use App\Models\Group;
use Storage;
use Image;
use File;
use Cache;
use DB;
use App\Http\Resources\GameResource;
use Spatie\QueryBuilder\QueryBuilder;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*$games = Game::all();

        if ($request->expectsJson() && $request->ajax())
        {
            return response()->json($games, 200);
        }else{
            $groups = Group::orderBy('id', 'asc')
                ->where('groupable_type', 'App\Models\Game')
                ->search($request)->paginate(12);

            $genres_id = Game::pluck('genre_id')->toArray();
            $genres_id = array_unique($genres_id);
            $genres = Genre::whereIn('id', $genres_id)->pluck('title', 'id')->toArray();
            $genres = ['0' => 'Select genres'] + $genres;

            $this->seo()->setTitle("Games");

            return view('games.index', compact('groups', 'genres'));
        }*/

        $games = QueryBuilder::for(Game::class)
            ->allowedIncludes(['group'])
            ->search($request);
            //->allowedFilters('name');

        if($request->has('page'))
        {
            $games = $games->paginate($request->has('limit') ? $request->get('limit') : 12);
        }else{
            $games = $games->get();
        }

        return GameResource::collection($games);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        $game->load(['group']);
        return new GameResource($game);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Import games from Giantbomb.com and Twitch by API.
     *
     * @throws \TwitchApi\Exceptions\ClientIdRequiredException
     * @throws \TwitchApi\Exceptions\InvalidLimitException
     * @throws \TwitchApi\Exceptions\InvalidOffsetException
     */
    public function importByTwitchGiantbomb()
    {
        $arGenres = Genre::all()->pluck('id', 'giantbomb_id');
        
        $twitchClient = new \TwitchApi\TwitchApi([
            'client_id' => env('TWITCH_API_CLIENT_ID'),
        ]);
        
        $giantbombClient = GiantBombClient::factory([
            'apiKey' => env('GIANTBOMB_API_CLIENT'),
        	'cache'  => null
        ]);
        
        $count = 0;
        $limit = 100;
        $offset = 0;

        do{
            $responseTwitch = $twitchClient->getTopGames((int)$limit, (int)$offset);
            $total = intval($responseTwitch['_total']);
            $games = $responseTwitch["top"];
            
            foreach($games as $arGame)
            {
                $giantbomb_id = $arGame["game"]["giantbomb_id"];
                $twitch_id = $arGame["game"]["_id"];

                //Get Game by Giant id
                $response = $giantbombClient->getGame(['id' => $giantbomb_id]);
                if( $response->getStatusCode() === 1 ) 
                {        
                    $game = $response->getResults();

                    if(Game::where('title', $game->getName())->count()>0)
                        continue;

                    try{
                        if($game->hasGenres())
                        {
                            $genres = $game->getGenres();
                            $genre_id = $genres[0]['id'];
                        }else{
                            $genre_id = 1;
                        }
                    }
                    catch(Exception $e)
                    {
                        $genre_id = 1;
                    }

                    $aliases =  explode(PHP_EOL, $game->getAliases());

                    if(!$this->checkAllowed($game->getName(), $aliases)) continue;

                    //Make logo
                    $logo = null;
                    if(!empty($arGame['game']['box']['large']))
                    {
                        $path = str_replace("https", "http", $arGame['game']['box']['large']);
                        $extension = strtolower(File::extension(basename($path)));
                        
                        if(in_array($extension, ["jpg", "jpeg", "png"]) && !empty($path))
                        {
                            $logo = 'games/'.basename($path);
                            $logo = str_replace(array("%", "+", ":"), "", $logo);
                            Image::make($path)->save(public_path("storage/".$logo));
                        }
                    }

                    //Make array images
                    $arImages = [];
                    $images = $game->getImages();                
                    foreach($images as $arImage)
                    {
                        $path = $arImage['medium_url'];
                        $extension = strtolower(File::extension(basename($path)));
                        if(in_array($extension, ["jpg", "jpeg", "png"]) && !empty($path) && @getimagesize($path))
                        {
                            $image = 'games/'.basename($path);
                            $image = str_replace(array("%", "+", ":"), "", $image);
                            Image::make($path)->save(public_path("storage/".$image));
                            $arImages[] = $image;
                            
                            if(count($arImages)==10) break;
                        }
                    }

                    //Make overlay
                    $overlay = null;
                    foreach($images as $arImage)
                    {
                        $path = $arImage['screen_url'];
                        $extension = strtolower(File::extension(basename($path)));
                        if(in_array($extension, ["jpg", "jpeg", "png"]) && !empty($path) && @getimagesize($path))
                        {
                            $image = 'games/'.basename($path);
                            $image = str_replace(array("%", "+", ":"), "", $image);
                            Image::make($path)->save(public_path("storage/".$image));
                            $overlay = $image;
                            
                            break;
                        }
                    }

                    if($logo===NULL && count($arImages)>0)
                        $logo = $arImages[0];

                    $data = [
                        'active'      => true,
                        'title'       => $game->getName(),
                        'giantbomb_id'=> $giantbomb_id,
                        'twitch_id'   => $twitch_id,
                        'genre_id'    => $arGenres[$genre_id],
                        'images'      => json_encode($arImages),
                        'logo'        => $logo,
                        'overlay'     => $overlay,  
                        'body'        => $game->getDeck(),
                        'online'      => true,
                        'alias'       => $aliases[0]
        	        ];
    
        	        Game::create($data);
                }
            }
            
            $count+= $limit;//count($games);
            $offset+= $limit;

            echo $count." ".$total."\r\n";

        } while ($count<$total);
    }

    /**
     * @param $title
     * @param $aliases
     * @return bool
     */
    public function checkAllowed($title, $aliases)
    {
        $names = ['Gears of War', 'Call Of Duty', 'HALO', 'League of Legends', 'Street Fighter', 'CS:GO', 'HEARTHSTONE', 'OVERWATCH', 'WORLD OF WARCRAFT',
            'Star Wars Battlefront', 'DOTA2', 'FIFA', 'FORTNITE', 'PUBG', 'SMITE', 'PALADINS', 'Heroes of the Storm', 'Brawlhalla', 'Starcraft',
            'Super Smash Bros', 'Tom Clancy\'s Rainbow Six Siege', 'Brawl Stars', 'Clash Royale', 'Metal Slug', 'Rocket League', 'Tekken', 'World of Tanks'
        ];

        $allowed = false;
        foreach($names as $name)
        {
            if(stripos($title, $name)==0 && stripos($title, $name)!==false)
            {
                $allowed = true;
                break;
            }

            foreach($aliases as $alias)
            {
                if(stripos($alias, $name)==0 && stripos($alias, $name)!==false)
                {
                    $allowed = true;
                    break;
                }
            }

            if($allowed)
                break;
        }

        return $allowed;
    }
}
