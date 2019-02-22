<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNewCoachRegisteredToAthlete extends Mailable implements ShouldQueue
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
        $data = $this->data;

        $address = 'news@campusteam.tv';
        $name = 'CampusTeam News';

        return $this->view('emails.new_coach_registered_to_athlete')
            ->from($address, $name)
            ->replyTo($address, $name)
            ->with('data', $this->data)
            ->subject("Esports coach of ".$data['university']->title." joined the CampusTeam community");
    }
}
