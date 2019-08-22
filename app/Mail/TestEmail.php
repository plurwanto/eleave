<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestEmail extends Mailable
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
        $senderEmail    = $this->data['from'];
        $senderName     = $this->data['from_name'];
        $subject        = $this->data['subject'];
        $message        = $this->data['message'];

        $buildMail = $this->view('emails.general')
                        ->from($senderEmail, $senderName)
                        ->subject($subject);

        if(isset($this->data['attach']) && !empty($this->data['attach']))
        {
            $buildMail = $buildMail->attach($this->data['attach']);
        }

        $buildMail = $buildMail->with([ 'pesan' => $message ]);
        
        return $buildMail;
    }
}
