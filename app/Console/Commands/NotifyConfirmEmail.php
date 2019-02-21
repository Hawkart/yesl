<?php
namespace App\Console\Commands;

use App\Mail\EmailVerificationNotify;
use App\Models\User;
use Illuminate\Console\Command;
use Carbon\Carbon;

class NotifyConfirmEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:notify-confirm-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users to confirm email.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now()->format('d');
        $users = User::where('verified', 0)->whereDay('created_at', '<', $now);

        if($users->count()>0)
        {
            foreach($users->get() as $user)
            {
                $email = new EmailVerificationNotify(new User(['confirmation_code' => $user->confirmation_code, 'name' => $user->name]));
                try {
                    Mail::to($user->email)->send($email);
                } catch (\Exception $exception){
                    //echo $exception->getMessage();
                }
            }
        }

    }
}
