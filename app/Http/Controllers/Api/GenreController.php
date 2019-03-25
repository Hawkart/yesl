<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GenreResource;
use Illuminate\Http\Request;
use \GiantBomb\Client\GiantBombClient;
use App\Models\Genre;
use Storage;
use Image;
use Cache;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Genre::all();
        return GenreResource::collection($items);
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
     * @param Genre $genre
     * @return GenreResource
     */
    public function show(Genre $genre)
    {
        return new GenreResource($genre);
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
     * Import genres from Giantbomb.com by API.
     */
    public function importByGiantbomb()
    {
        $giantbombClient = GiantBombClient::factory([
            'apiKey' => env('GIANTBOMB_API_CLIENT'),
        	'cache'  => null
        ]);
        
        $count = 0;
        $limit = 50;
        $offset = 0;
        do{
            $response = $giantbombClient->getGenres([
                'limit'  => $limit,
                'offset' => $offset
            ]);
            $genres = $response->getResults();
            $total = intval($response->getNumberOfTotalResults());

            echo $count." ".$total."\r\n";

            foreach($genres as $arGenre)
            {
                $image = $arGenre->getImage();
                if(!empty($image) && isset($image['icon_url']))
                {
                    $image_path = 'genres/'.basename($image['icon_url']);
                    $image_path = str_replace("%20", "", $image_path);
                    Image::make($image['icon_url'])->save(public_path("storage/".$image_path));
                }else{
                    $image_path = null;
                }
                
                $data = [
                    'active'            => true,
                    'giantbomb_id'      => $arGenre->getId(),
                    'title'             => $arGenre->getName(),
                    'desc'              => $arGenre->getDeck(),
                    'image'             => $image_path
    	        ];
                
                Genre::create($data);
            }
            
            $count += count($genres);
            $offset += $limit;
            
        } while ($count<$total);
    }
}
