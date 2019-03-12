<?php
namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UsersAvatarUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:avatar-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update users avatar.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();
        foreach($users as $user)
        {
            $user->setDefaultAvatar();
        }
    }
}
