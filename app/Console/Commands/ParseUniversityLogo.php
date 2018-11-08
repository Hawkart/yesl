<?php
namespace App\Console\Commands;

use App\Models\University;
use App\Models\Group;
use App\Models\GroupUser;
use Illuminate\Console\Command;
use Storage;
use DB;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Exporter;

class ParseUniversityLogo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'university:parse-logos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse USA University logos.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = University::all();

        $url = 'https://www.glassdoor.com/searchsuggest/typeahead';
        $links = 'https://media.glassdoor.com/';
        foreach($data as $university)
        {
            $params = [
                'source' => 'Jobs',
                'version' => 'New',
                'input' => 'Albright',//str_replace(" ","+", 'Albright'),
                'rf' => 'full'
            ];

            $client = new Client();
            $response = $client->request('GET', $url, [
                'query' => $params
            ]);

            /*$client = new Client();
            $request = new Request('GET', $url);
            $response = $client->send($request, ['timeout' => 2, 'query' => $params]);*/

            $data = json_decode($response->getBody(), true);
            dd($data);

            if(count($data)>0)
            {
                foreach($data as $parsed)
                {
                    if(strtoupper($parsed['suggestion'])==strtoupper($university->title))
                    {
                        $imagename = basename($links.$parsed['logoUrl']);
                        Storage::disk('local')->put('public/universities/'.$imagename, $links.$parsed['logoUrl']);
                        //copy($links.$parsed['logoUrl'], '/tmp/file.jpeg');

                        $university->update([
                            'logo' => 'universities/'.$imagename
                        ]);

                        if($university->group()->count()>0)
                        {
                            $group = $university->group;
                            $group->update([
                               'image' =>  'universities/'.$imagename
                            ]);
                        }

                        echo $university->title."\r\n";

                        break;
                    }
                }
            }

            sleep(2);
        }
    }
}