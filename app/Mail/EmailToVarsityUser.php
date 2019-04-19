<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailToVarsityUser extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'scolarship@campusteam.tv';
        $name = 'CampusTeam crew';

        return $this->view('emails.to_varsity_users')
            ->with('data', $this->data)
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject("For ".$this->data->nickname." Esports scholarships opportunities");
    }
}
