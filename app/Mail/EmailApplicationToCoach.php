<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailApplicationToCoach extends Mailable
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
        $address = 'no-reply@campusteam.tv';
        $name = 'CampusTeam crew';

        return $this->view('emails.application_to_coach')
            ->with('data', $this->data)
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject("New application to ".$this->data['game']->title." team from ".$this->data['user']->name);
    }
}
