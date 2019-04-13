<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailToCoach extends Mailable
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
        $address = 'vl@campusteam.info';
        $name = 'Vlad ILchenko';

        return $this->view('emails.to_coach')
            ->with('data', $this->data)
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject("Esports athletes registration is now open on CampusTeam.tv");
    }
}
