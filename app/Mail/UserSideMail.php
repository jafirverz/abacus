<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserSideMail extends Mailable
{
    use Queueable, SerializesModels;
    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
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
        if (isset($data['attachment'])) {
            return $this->subject($data['subject'])
                ->from($data['from_email'], $data['email_sender_name'])
                ->markdown('mail.user_side', compact("data"))
                ->attachFromStorage('/'.$data['attachment']);

        } else {
            return $this->subject($data['subject'])
                ->from($data['from_email'], $data['email_sender_name'])
                ->markdown('mail.user_side', compact("data"));
        }

    }
}
