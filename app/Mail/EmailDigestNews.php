<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailDigestNews extends Mailable
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
        $address = 'news@esportsathletes.net';
        $name = 'Esports Newsletter';

        return $this->view('emails.digest_news')
            ->with('data', $this->data)
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject("Esports News for ".$this->data['name']);
    }
}
