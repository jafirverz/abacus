<?php

namespace App\Console\Commands;

use App\ChatMessage;
use App\User;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Mail\EmailNotification;
use Illuminate\Console\Command;

class SendEmailNotification extends Command
{
    use GetEmailTemplate, SystemSettingTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email to user who have not read the chat message';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $chatMessages = ChatMessage::where('new_chat', 1)->where('sent_email', null)->get();
        if(sizeof($chatMessages) > 0){
            
            foreach($chatMessages as $cmsg){
                $senderId = $cmsg->sender_id;
                if($cmsg->buyer_id == $senderId){
                    $receiverId = $cmsg->seller_id;
                }else{
                    $receiverId = $cmsg->buyer_id;
                }
                $userDetail = User::where('id', $receiverId)->first();
                $userDetailSender = User::where('id', $senderId)->first();
                if($userDetail){
                    $receiverName = $userDetail->name ?? 'User';
                    $senderName = $userDetailSender->name ?? '';
                    $email = $userDetail->email;
                    $data = [];
                    $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                    $data['from_email'] = $this->systemSetting()->from_email;
                    $data['to_email'] = [$email];
                    $data['cc_to_email'] = [];
                    $data['subject'] = "New Message received";
                    $data['contents'] = "Dear $receiverName, \n
                    You have an unread message from $senderName. \n Please login to view the message from My Chats.";
                    try {
                        $mail = Mail::to($data['to_email'])->send(new EmailNotification($data));
                        $cmsg->sent_email = 1;
                        $cmsg->save();
                        // dd($data);
                    } catch (Exception $exception) {
                    }
                }
                
            }
        }
    }
}
