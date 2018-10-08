<?php
namespace App\Console\Commands;

use App\Models\University;
use App\Models\Group;
use Illuminate\Console\Command;
use Storage;
use DB;

class ImportCollegeScoreCard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'university:import-scorecard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import USA University.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

    }

    private function makeRequest()
    {
        $api_url = 'https://api.data.gov/ed/collegescorecard/v1/schools';
        $key = getnev('COLLEGESCORECARD_KEY', '');
        $fields = [];

    }

    private function addUniversity($university)
    {

    }
}