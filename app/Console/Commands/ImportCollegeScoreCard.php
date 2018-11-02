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
        DB::statement("SET foreign_key_checks=0");
        University::truncate();
        Group::truncate();
        GroupUser::truncate();
        DB::statement("SET foreign_key_checks=1");

        $nace = 'Albright College;Ashland University;Averett University;Bellevue University;Bloomfield College;Boise State University;Brescia University;Campbellsville University;Cazenovia College;Central Maine Community College;Central Methodist University;Centralia College;Cincinnati Christian University;Coker College;College of St. Joseph;Columbia College - Missouri;Culver-Stockton College;Daemen College;Dakota Wesleyan University;Defiance College;Delaware Valley University;DeSales University;Dickinson State University;East Coast Polytechnic Institute;Edinboro University;Embry-Riddle Aeronautical University (Arizona Campus);Ferrum College;Florida Southern College;Fontbonne University;Georgia Southern University;Georgia State University;Grand View University;Harrisburg University;Hartwick College;Hastings College;Hawkeye Community College;Illinois College;Illinois Wesleyan University;Indiana Institute of Technology;Iowa Central Community College;Jarvis Christian College;Juniata College;Kansas Wesleyan University;Keuka College;King University - Tennessee;Lackawanna College;Lawrence Technological University;Lebanon Valley College;Lees-McRae College;Limestone College;Lindenwood University;Lourdes University;Marietta College;Maryville University;McPherson College;Menlo College;Miami University;Midland University;Missouri Valley College;Montreat College;Morningside College;Mount St. Joseph University;Mount Vernon Nazarene University;New England College;New Mexico State University;Northern Virginia Community College;Northwest Christian University;Ohio Northern University;Oregon Institute of Technology;Park University;Principia College;Randolph-Macon College;Robert Morris University - Illinois;Sacred Heart University;Savannah College of Art & Design;Schreiner University;Shawnee State University;Shenandoah University;Siena Heights University;Simpson University;Southern New Hampshire University;Southwestern Oregon Community College;Spalding University;St. Ambrose University;St. Clair College;St. Louis College of Pharmacy;St. Thomas Aquinas College;St. Thomas University - Florida;Stephens College;Stevenson University;SUNY Canton;Texas Wesleyan University;Trine University;Union County College;University of Akron;University of Antelope Valley;University of Jamestown;University of North Texas;University of Oklahoma;University of Pikeville;University of Providence (Formerly University of Great Falls);University of Saint Mary;University of South Carolina - Sumter;University of South Carolina - Union;University of Texas at Dallas;Upper Iowa University;Viterbo University;West Virginia Wesleyan College;Western Kentucky University;Wichita State University';
        $this->naces = explode(";", $nace);

        $page = 0;
        do{
            $page++;
            $response = $this->makeRequest($page);
            $meta = $response['metadata'];
            $results = $response['results'];
            $pages = ceil($meta['total'] / $meta['per_page']);

            foreach($results as $university)
            {
                $this->addUniversity($university);
            }

        } while ($page<$pages);

    }

    private function makeRequest($page)
    {
        $api_url = 'https://api.data.gov/ed/collegescorecard/v1/schools';
        $key = getenv('COLLEGESCORECARD_KEY', '');
        $fields = ['id', 'ope8_id', 'ope6_id', 'school.name', 'school.city', 'school.state', 'school.zip',
            'school.accreditor', 'school.school_url', 'school.price_calculator_url', 'school.main_campus', 'school.branches', 'school.degrees_awarded.highest',
            'school.ownership', 'school.state_fips', 'school.region_id', 'location.lat', 'location.lon',
            'latest.admissions.admission_rate.overall', 'latest.admissions.sat_scores.average.overall', 'school.online_only',
            'latest.student.size', 'latest.student.enrollment.all', 'school.operating', 'latest.cost.tuition.in_state', 'latest.cost.tuition.out_of_state',
            'latest.aid.pell_grant_rate', 'latest.aid.federal_loan_rate', 'latest.student.demographics.age_entry', 'latest.student.demographics.female_share',
            'latest.student.demographics.married', 'latest.earnings.10_yrs_after_entry.working_not_enrolled.mean_earnings',
            'latest.earnings.10_yrs_after_entry.median', 'latest.student.demographics.men', 'latest.student.demographics.women',
            'latest.student.undergrads_with_pell_grant_or_federal_student_loan', 'latest.student.undergrads_non_degree_seeking',
            'latest.student.grad_students'
        ];

        $params = [
            '_fields' => implode(',', $fields),
            'api_key' => $key,
            'page' => $page,
            'per_page' => 100
        ];
        //$str = http_build_query($array);

        /*$client = new Client();
        $response = $client->request('GET', $api_url, [
            'query' => $params
        ]);*/

        /*$client = new Client();
        $request = new Request('GET', $api_url);
        $response = $client->send($request, ['timeout' => 2, 'query' => $params]);

        dd($response->getBody());*/

        //dd(urldecode($api_url."?".http_build_query($params)));
        $content = file_get_contents($api_url."?".http_build_query($params));
        $content = json_decode($content, true);

        //dd($content['metadata']);
        //dd(json_decode($content, true));

        return $content;
    }

    private function addUniversity($university)
    {
        if(University::where('score_id', $university['id'])->count()==0)
        {
            $url = $university['school.school_url'];
            $domain = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));

            University::create([
                'nace' => in_array($university['school.name'], $this->naces),
                'title' => $university['school.name'],
                'url' => $url,
                'address' => $university['school.zip'].", ".$university['school.city'].", ".$university['school.state'],
                'domain' => $domain,
                'json' => $university,
                'score_id' => $university['id'],
                'ope8_id' =>  $university['ope8_id'],
                'ope6_id' =>  $university['ope6_id'],
                'city' =>  $university['school.city'],
                'state' =>  $university['school.state'],
                'zip' =>  $university['school.zip'],
                'accreditor' =>  $university['school.accreditor'],
                'price_calculator_url' =>  $university['school.price_calculator_url'],
                'degrees_awarded_highest' => $university['school.degrees_awarded.highest'],
                'main_campus' =>  $university['school.main_campus'],
                'branches' =>  $university['school.branches'],
                'ownership' =>  $university['school.ownership'],
                'state_fips' =>  $university['school.state_fips'],
                'region_id' =>  $university['school.region_id'],
                'location_lat' =>  $university['location.lat'],
                'location_lon' =>  $university['location.lon'],
                'admission_rate_overall' =>  $university['latest.admissions.admission_rate.overall'],
                'sat_scores_average_overall' =>  $university['latest.admissions.sat_scores.average.overall'],
                'online_only' =>  $university['school.online_only'],
                'size' =>  $university['latest.student.size'],
                'enrollment_all' =>  $university['latest.student.enrollment.all'],
                'operating' =>  $university['school.operating'],
                'cost_tuition_in_state' =>  $university['latest.cost.tuition.in_state'],
                'cost_tuition_out_of_state' =>  $university['latest.cost.tuition.out_of_state'],
                'aid_pell_grant_rate' =>  $university['latest.aid.pell_grant_rate'],
                'aid_federal_loan_rate' =>  $university['latest.aid.federal_loan_rate'],
                'demographics_age_entry' =>  $university['latest.student.demographics.age_entry'],
                'demographics_female_share' =>  $university['latest.student.demographics.female_share'],
                'demographics_married' =>  $university['latest.student.demographics.married'],
                '10_yrs_after_entry_working_not_enrolled' =>  $university['latest.earnings.10_yrs_after_entry.working_not_enrolled.mean_earnings'],
                '10_yrs_after_entry_median' =>  $university['latest.earnings.10_yrs_after_entry.median'],
                'demographics_men' =>  $university['latest.student.demographics.men'],
                'demographics_women' =>  $university['latest.student.demographics.women'],
                'undergrads_with_pell_grant' =>  $university['latest.student.undergrads_with_pell_grant_or_federal_student_loan'],
                'undergrads_non_degree' =>  $university['latest.student.undergrads_non_degree_seeking'],
                'grad_students' =>  $university['latest.student.grad_students'],
            ]);
        }
    }
}