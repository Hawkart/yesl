<?php

namespace App\Http\Controllers\Auth;

use App\Models\University;
use App\Models\User;
use App\Models\Group;
use App\Models\GroupMessage;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use App\Mail\EmailVerification;
use App\Mail\EmailNewCoachRegisteredToAthlete;
use App\Mail\EmailNewCoachRegisteredToCoach;
use App\Mail\EmailSuccessRegistrationAthlete;
use App\Mail\EmailSuccessRegistrationCoach;
use App\Http\Requests\UserRequest;
use DB;
use Mail;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $u = [
            'name' => trim($data['first_name']." ".$data['last_name']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'gender' => intval($data['gender']),
            //'date_birth' => Carbon::parse($data['date_birth']),
            'confirmation_code' => str_random(10),
            'type' => isset($data['type']) ? $data['type'] : 1
        ];

        //Check if email from university
        if(isset($data['type']) && $data['type']==2)
        {
            $domain = substr($data['email'], strrpos($data['email'], '@') + 1);
            $universities = University::where('url', 'like', "%".$domain."%");
            if($universities->count()>0)
                $u['university_id'] =  $universities->first()->id;
        }

        return User::create($u);
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRequest $request)
    {
        $data = $request->all();
        $send_no_auto = false;

        //check coach
        if(isset($data['type']) && $data['type']==2)
        {
            $domain = substr($data['email'], strrpos($data['email'], '@') + 1);

            //check .edu email
            if(stripos($domain, '.edu')===false)
            {
                return response()->json(['email' => "Coaches may register with  college/university email only."], 422);
            }else{

                /*if(intval($data['university_id'])>0)
                {
                    $universities = University::whereId($data['university_id']);
                }else{*/
                    $universities = University::where('url', 'like', "%".$domain."%");
                //}

                if($universities->count()==0)
                {
                    return response()->json(['university_id' => "University with such domain zone doesn't exist."], 422);
                }else{
                    $university = $universities->first();

                    //check if need to send notify about coach with no auto chosen university
                    if(stripos($university->url, $domain)===false)
                        $send_no_auto = true;
                }
            }
        }

        DB::beginTransaction();
        try
        {
            $users = User::whereEmail($data['email']);
            if($users->count()>0)
            {
                $user = $users->first();

                if($user->precreated && !$user->verified && $user->type==2)
                {
                    $data['confirmation_code'] = str_random(10);
                    $user->update($data);
                }else{
                    return response()->json(['email' => 'This email has been already used.'], 422);
                }
            }else{
                $user = $this->create($request->all());
                $user->setDefaultAvatar();
            }

            $email = new EmailVerification(new User(['confirmation_code' => $user->confirmation_code, 'name' => $user->name]));
            Mail::to($user->email)->send($email);
            DB::commit();

            $message = '';
            if($data['type']==2)
                $message = 'Dear Esports team coach, We are glad you are with us!';

            $message.= "You need to make just one more step to complete your registration.<br>
                        Please find the 'CampusTeam Registration' message in your inbox
                        and confirm your email address by clicking the  <u>\"Verify Email\"</u> button in it.<br>
                        If you cannot find this message, please check your Spam box, spot it there, 
                        mark it as <u>'Not spam'</u> and then confirm your email address";

            return response()->json([
                "message" => $message
            ], 200);
        }
        catch(Exception $e)
        {
            DB::rollback();

            return response()->json([
                "message" => "Something wrong!"
            ], 422);
        }
    }

    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify($token)
    {
        $user = User::where('confirmation_code', $token)->firstOrFail();
        $user->verify();

        if($user->university_id && $user->isCoach())
        {
            $university = University::where('id', $user->university_id)->first();

            if($university->group()->count()>0 && $university->group->owner->isAdmin())
            {
                $university->group->update([
                    'owner_id' => $user->id
                ]);

                $this->getBackGroupMessages($university->group, $user);
            }

            if($university)
                $this->notifyAllAboutNewCoach($user);
        }

        $this->sendGuide($user);

        return redirect('login')->with('status', "Your mail has been verified! Now you can login to the website");
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationCoachForm()
    {
        return view('auth.register_coach');
    }

    /**
     * @param $user
     */
    public function sendGuide($user)
    {
        $data['user'] = $user;
        $when = now()->addDays(2);

        try{
            if($user->isAthlete())
                Mail::to($user->email)->later($when, new EmailSuccessRegistrationAthlete($data));
            else
                Mail::to($user->email)->send(new EmailSuccessRegistrationCoach($data));
        } catch (\Exception $e) {

        }
    }

    /**
     * Send notification to all users about new registered coach
     * @param $coach
     */
    public function notifyAllAboutNewCoach($coach)
    {
        $university = $coach->university;
        $when = now()->addMinutes(5);

        $users = User::verified()->where('id', '<>', $coach->id)->get();
        foreach($users as $user)
        {
            $data = [
                'user' => $user,
                'coach' => $coach,
                'university' => $university
            ];

            try{

                if($user->isAthlete())
                {
                    Mail::to($user->email)->later($when, new EmailNewCoachRegisteredToAthlete($data));
                }else{
                    Mail::to($user->email)->later($when, new EmailNewCoachRegisteredToCoach($data));
                }

            } catch (\Exception $e) {

            }
        }

        $groups = Group::whereNotNull('coach_email')->whereHas('owner', function($q){
            $q->admins();
        })->get();
        foreach($groups as $group)
        {
            $data = [
                'user' => [
                    'email' => $group->coach_email,
                    'name' => $group->coach_name
                ],
                'coach' => $coach,
                'university' => $university
            ];

            try{
                Mail::to($data['user']['email'])->later($when, new EmailNewCoachRegisteredToCoachNotRegistered($data));
            } catch (\Exception $e) {

            }
        }
    }

    /**
     * Get messages from additional table from group to new admin user
     *
     * @param $group
     * @param $user
     */
    public function getBackGroupMessages($group, $user)
    {
        try{
            $messages = GroupMessage::where('group_id', $group->id);
            if($messages->count()>0)
            {
                foreach($messages->get() as $omessage)
                {
                    $uids = [$omessage->from, $user->id];
                    $th = Thread::between($uids);

                    if($th->count()>0)
                    {
                        $thread = $th->first();
                    }else{
                        $subject = $user->name;

                        $thread = Thread::create([
                            'subject' => $subject,
                        ]);

                        // Recipients
                        $thread->addParticipant([$user->id]);

                        // Sender
                        Participant::create([
                            'thread_id' => $thread->id,
                            'user_id' => $omessage->from,
                            'last_read' => new Carbon,
                        ]);
                    }

                    // Message
                    $message = Message::create([
                        'created_at' => Carbon::parse($omessage->created_at),
                        'thread_id' => $thread->id,
                        'user_id' => $omessage->from,
                        'body' => $omessage->body,
                    ]);

                    //Mark all messages of chat read
                    $thread->markAsRead($omessage->from);
                }
            }

        } catch( \Exception $e) {

        }
    }
}
