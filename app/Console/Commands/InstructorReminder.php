<?php

namespace App\Console\Commands;

use App\Level;
use Illuminate\Console\Command;
use App\Mail\EmailNotification;
use App\InstructorCalendar;
use App\Order;
use App\OrderDetail;
use App\Traits\EmailNotificationTrait;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use App\User;
use Illuminate\Support\Facades\Mail;
use Exception;

class InstructorReminder extends Command
{
    use GetEmailTemplate, SystemSettingTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'instructor:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind Instructor before expiry';

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
        $today = date('Y-m-d');
        $daysAhead = date('Y-m-d', strtotime($today. ' + 2 days'));
        $reminder = InstructorCalendar::where('start_date', $daysAhead)->get();
        if($reminder){
            foreach($reminder as $remind){
                if($remind){

                    $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_INSTRUCTOR_REMINDER'));

                    if ($email_template) {
                        $data = [];

                            $data['email_sender_name'] = systemSetting()->email_sender_name;
                            $data['from_email'] = systemSetting()->from_email;
                            $data['to_email'] = [$remind->teacher->email];
                            $data['cc_to_email'] = [];
                            $data['subject'] = $email_template->subject;

                            $key = ['{{full_name}}', '{{start_date}}'];
                            $value = [$remind->teacher->name, $remind->start_date];

                            $newContents = str_replace($key, $value, $email_template->content);

                            $data['contents'] = $newContents;
                            try {
                                $mail = Mail::to('jafir.verz@gmail.com')->send(new EmailNotification($data));
                            } catch (Exception $exception) {
                                dd($exception);
                            }

                    }
                }
            }
        }

    }
}
