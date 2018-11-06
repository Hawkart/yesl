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

class ExportUniversities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'university:export-scorecard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export USA University.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = University::where('nace', 1)->exclude('json')->get()->toArray();


        $title = [];
        foreach($data[0] as $key=>$value)
        {
            $title[$key] = str_replace("_", " ", $key);
        }

        array_unshift($data, $title);

        $data = array_map("unserialize", array_unique(array_map("serialize", $data)));
        $collection = collect($data);

        $dir = 'public';
        Storage::makeDirectory($dir);
        $filename = "export_uni_".date("d_m_Y").".xlsx";
        Storage::disk('local')->put($dir.'/'.$filename, '');
        $path = storage_path('app/'.$dir.'/'.$filename);

        $exporter = Exporter::make('Excel');
        $exporter->load($collection);
        $exporter->setChunk(100);
        $exporter->save($path);
    }
}