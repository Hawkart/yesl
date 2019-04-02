<?php
namespace App\Console\Commands;

use App\Models\University;
use App\Models\Group;
use App\Models\User;
use Illuminate\Console\Command;
use Storage;
use DB;


class UniversityNaceSelect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'university:nace-select';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select Nace USA University.';

    /**
     * The console command description.
     *
     * @var array
     */
    protected $naces = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$nace = strtoupper('Albright College,Ashland University,Averett University,Bellevue University,Bloomfield College,Boise State University,Brescia University,Campbellsville University,Cazenovia College,Central Maine Community College,Central Methodist University,Centralia College,Cincinnati Christian University,Coker College,College of St. Joseph,Columbia College - Missouri,Culver-Stockton College,Daemen College,Dakota Wesleyan University,Defiance College,Delaware Valley University,DeSales University,Dickinson State University,East Coast Polytechnic Institute,Edinboro University,Embry-Riddle Aeronautical University (Arizona Campus),Ferrum College,Florida Southern College,Fontbonne University,Georgia Southern University,Georgia State University,Grand View University,Harrisburg University,Hartwick College,Hastings College,Hawkeye Community College,Illinois College,Illinois Wesleyan University,Indiana Institute of Technology,Iowa Central Community College,Jarvis Christian College,Juniata College,Kansas Wesleyan University,Keuka College,King University - Tennessee,Lackawanna College,Lawrence Technological University,Lebanon Valley College,Lees-McRae College,Limestone College,Lindenwood University,Lourdes University,Marietta College,Maryville University,McPherson College,Menlo College,Miami University,Midland University,Missouri Valley College,Montreat College,Morningside College,Mount St. Joseph University,Mount Vernon Nazarene University,New England College,New Mexico State University,Northern Virginia Community College,Northwest Christian University,Ohio Northern University,Oregon Institute of Technology,Park University,Principia College,Randolph-Macon College,Robert Morris University - Illinois,Sacred Heart University,Savannah College of Art & Design,Schreiner University,Shawnee State University,Shenandoah University,Siena Heights University,Simpson University,Southern New Hampshire University,Southwestern Oregon Community College,Spalding University,St. Ambrose University,St. Clair College,St. Louis College of Pharmacy,St. Thomas Aquinas College,St. Thomas University - Florida,Stephens College,Stevenson University,SUNY Canton,Texas Wesleyan University,Trine University,Union County College,University of Akron,University of Antelope Valley,University of Jamestown,University of North Texas,University of Oklahoma,University of Pikeville,University of Providence (Formerly University of Great Falls),University of Saint Mary,University of South Carolina - Sumter,University of South Carolina - Union,University of Texas at Dallas,Upper Iowa University,Viterbo University,West Virginia Wesleyan College,Western Kentucky University,Wichita State University,Yakima Valley College,University of California - Irvine');
        //$this->naces = explode(",", $nace);

        $opes6 = [2236,2239,1903,1466,2908,3965,2337,2678,2914,1908,1852,2456,3810,3557,1856,2249,2461,10198,23621,39483,
            21519,1088,3511,3247,7540,2775,3084,4072,3030,1741,3395,3168,1521,1889,2052,2536,3083,3116,1962,2899];

        //$scores = [176947, 231077, 178396, 212160, 104586, 220516, 178059, 204024, 204200, 188030, 148335, 140951, 154235, 137476, 196015, 200800, 207500, 180258, 228787, 237109, 110653];

        $data = University::all();
        /*foreach($data as $university)
        {
            $university->update([
                'nace' => in_array(strtoupper($university->title), $this->naces) || in_array($university->score_id, $scores)
            ]);
        }*/
        foreach($data as $university)
        {
            if(in_array($university->ope6_id, $opes6))
            {
                $university->update([
                    'nace' => 1
                ]);
            }
        }

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
    }
}
