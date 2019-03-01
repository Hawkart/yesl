<?php
namespace App\Mail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerificationNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'confirm_mail@campusteam.tv';
        $name = 'CampusTeam MailServer';

        return $this->view('emails.verification_notify')
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject("Verify email");
    }
}
