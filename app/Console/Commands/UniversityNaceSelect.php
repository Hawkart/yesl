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
        $nace = strtoupper('Albright College,Ashland University,Averett University,Bellevue University,Bloomfield College,Boise State University,Brescia University,Campbellsville University,Cazenovia College,Central Maine Community College,Central Methodist University,Centralia College,Cincinnati Christian University,Coker College,College of St. Joseph,Columbia College - Missouri,Culver-Stockton College,Daemen College,Dakota Wesleyan University,Defiance College,Delaware Valley University,DeSales University,Dickinson State University,East Coast Polytechnic Institute,Edinboro University,Embry-Riddle Aeronautical University (Arizona Campus),Ferrum College,Florida Southern College,Fontbonne University,Georgia Southern University,Georgia State University,Grand View University,Harrisburg University,Hartwick College,Hastings College,Hawkeye Community College,Illinois College,Illinois Wesleyan University,Indiana Institute of Technology,Iowa Central Community College,Jarvis Christian College,Juniata College,Kansas Wesleyan University,Keuka College,King University - Tennessee,Lackawanna College,Lawrence Technological University,Lebanon Valley College,Lees-McRae College,Limestone College,Lindenwood University,Lourdes University,Marietta College,Maryville University,McPherson College,Menlo College,Miami University,Midland University,Missouri Valley College,Montreat College,Morningside College,Mount St. Joseph University,Mount Vernon Nazarene University,New England College,New Mexico State University,Northern Virginia Community College,Northwest Christian University,Ohio Northern University,Oregon Institute of Technology,Park University,Principia College,Randolph-Macon College,Robert Morris University - Illinois,Sacred Heart University,Savannah College of Art & Design,Schreiner University,Shawnee State University,Shenandoah University,Siena Heights University,Simpson University,Southern New Hampshire University,Southwestern Oregon Community College,Spalding University,St. Ambrose University,St. Clair College,St. Louis College of Pharmacy,St. Thomas Aquinas College,St. Thomas University - Florida,Stephens College,Stevenson University,SUNY Canton,Texas Wesleyan University,Trine University,Union County College,University of Akron,University of Antelope Valley,University of Jamestown,University of North Texas,University of Oklahoma,University of Pikeville,University of Providence (Formerly University of Great Falls),University of Saint Mary,University of South Carolina - Sumter,University of South Carolina - Union,University of Texas at Dallas,Upper Iowa University,Viterbo University,West Virginia Wesleyan College,Western Kentucky University,Wichita State University,Yakima Valley College,University of California - Irvine');
        $this->naces = explode(",", $nace);

        $opes6 = ['2453', '3685', '2516', '3321', '1479', '3496', '2482', '3077', '3033', '2657', '1746', '21415', '1889', '1468', '2855', '3123', '3184', '2527', '9741', '3805', '1314'];
        $scores = [176947, 231077, 178396, 212160, 104586, 220516, 178059, 204024, 204200, 188030, 148335, 140951, 154235, 137476, 196015, 200800, 207500, 180258, 228787, 237109, 110653];

        $data = University::all();
        foreach($data as $university)
        {
            $university->update([
                'nace' => in_array(strtoupper($university->title), $this->naces) || in_array($university->score_id, $scores)
            ]);
        }
    }
}