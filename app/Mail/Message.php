<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Message extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Elements de contact
     * @var array
     */
    public $a;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Array $message)
    {
        $this->a = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('univ.sport.lyon@gmail.com', 'Sport Lyon')
            ->subject('Message d\'information')
            ->view('emails.message');
    }
}