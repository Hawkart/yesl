<?php

namespace App\Http\Controllers\Auth;

use App\Models\University;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use App\Mail\EmailVerification;
use DB;
use Mail;
use Illuminate\Http\Request;
use App\Acme\Helpers\MailgunHelper;

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
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'terms' => 'required',
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
            'confirmation_code' => str_random(10)
        ];

        //Check if email from university
        $domain = substr($data['email'], strrpos($data['email'], '@') + 1);
        $universities = University::where('domain', $domain);
        if($universities->count()>0)
        {
            $u['university_id'] =  $universities->first()->id;
        }

        return User::create($u);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        DB::beginTransaction();
        try
        {
            $user = $this->create($request->all());
            $email = new EmailVerification(new User(['confirmation_code' => $user->confirmation_code, 'name' => $user->name]));
            Mail::to($user->email)->send($email);
            DB::commit();
            return back()->with('status', "A confirmation link has been sent to your mail!");
        }
        catch(Exception $e)
        {
            DB::rollback();
            return back();
        }
    }

    public function verify($token)
    {
        $result = [];
        $user = User::where('confirmation_code', $token)->firstOrFail();

        $pass = str_random(10);
        $mailbox = $user->nickname.'@'.getenv('MAILGUN_DOMAIN', '');

        try
        {
            $result = MailgunHelper::create([
                'account'  => $user->nickname,
                'password' => $pass
            ]);
        }
        catch(Exception $e) {
        }

        if($result)
        {
            $user->update([
                'mailbox_email' => $mailbox,
                'mailbox_password' => $pass
            ]);
            $user->verified();
        }

        return redirect('login')->with('status', "Your mail has been verified!");
    }
}
