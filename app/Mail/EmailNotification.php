<?php

namespace App\Mail;

use App\Traits\SystemSettingTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNotification extends Mailable
{
    use Queueable, SerializesModels, SystemSettingTrait;
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
        $system_settings = $this->systemSetting();
        if(isset($data['attachment']))
        {
            $email = $this->subject($data['subject'])->from($data['from_email'], $data['email_sender_name'])->markdown('mail.email_notification', compact("data", "system_settings"));
            if(gettype($data['attachment'])=='array')
            {
                foreach($data['attachment'] as $item)
                {
                    $email->attachFromStorageDisk('public', $item);
                }
            }
            else
            {
                $email->attachFromStorageDisk('public', $data['attachment']);
            }
            return $email;
        }
        else
        {
            return $this->subject($data['subject'])->from($data['from_email'], $data['email_sender_name'])->markdown('mail.email_notification', compact("data", "system_settings"));
        }
	}
}
