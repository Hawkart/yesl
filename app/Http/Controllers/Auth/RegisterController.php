<?php

namespace App\Http\Controllers\Auth;

use App\Models\University;
use App\Models\User;
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['date_birth'] = Carbon::parse($data['date_birth'])->format('Y-m-d');

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',//|unique:users',
            'password' => 'required|string|min:6',
            'terms' => 'required|accepted',
            'gender' => 'required',
            'date_birth' => 'required|date_format:Y-m-d|before:today'
        ];

        return Validator::make($data, $rules);
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
            'date_birth' => Carbon::parse($data['date_birth']),
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

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $data = $request->all();
        $send_no_auto = false;
        $errors = [];

        //check coach
        if(isset($data['type']) && $data['type']==2)
        {
            $domain = substr($data['email'], strrpos($data['email'], '@') + 1);

            //check .edu email
            if(stripos($domain, '.edu')===false)
            {
                $errors['email'] = "Coaches can register only with university's mailbox.";
                return response()->json(['email' => "Coaches can register only with university's mailbox."], 422);
            }else{

                if(intval($data['university_id'])>0)
                {
                    $universities = University::whereId($data['university_id']);
                }else{
                    $universities = University::where('url', 'like', "%".$domain."%");
                }

                if($universities->count()==0)
                {
                    $errors['university_id'] = "You must choose which university coach you are.";
                    return response()->json(['university_id' => 'You must choose which university coach you are.'], 422);
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
                    return response()->json(['email' => 'The email has already been taken.'], 422);
                }
            }else{
                $user = $this->create($request->all());
            }

            $email = new EmailVerification(new User(['confirmation_code' => $user->confirmation_code, 'name' => $user->name]));
            Mail::to($user->email)->send($email);
            DB::commit();

            $message = '';
            if($data['type']==2)
                $message = 'Dear coach of the university team. We are glad that you are with us! ';

            $message.= "A confirmation link has been sent to your mail!";

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

    public function verify($token)
    {
        $user = User::where('confirmation_code', $token)->firstOrFail();
        $user->verified();

        if($user->university_id && $user->type==2)
        {
            $university = University::where('id', $user->university_id)->first();

            if($university->group()->count()>0 && strpos($university->group->owner->email, '@campusteam.tv')!==false) //now campus team profile
            {
                $university->group->update([
                    'owner_id' => $user->id
                ]);

                $this->getBackGroupMessages($university->group, $user);
            }

            if($university)
            {
                Mail::raw('New coach '.$user->name." from ".$university->title." registered.", function ($message) use ($university)  {
                    $message->to('vladislav.ilchenko@gmail.com')
                        ->subject('New coach from '.$university->title);
                });
            }
        }

        return redirect('login')->with('status', "Your mail has been verified!");
    }

    public function showRegistrationCoachForm()
    {
        return view('auth.register_coach');
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
