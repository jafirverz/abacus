<?php

namespace App\Console\Commands;

use App\Level;
use Illuminate\Console\Command;
use App\Mail\EmailNotification;
use App\Notification;
use App\Order;
use App\OrderDetail;
use App\Traits\EmailNotificationTrait;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use App\User;
use Illuminate\Support\Facades\Mail;
use Exception;

class NotifyUser extends Command
{
    use GetEmailTemplate, SystemSettingTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify user for membership expiry';

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
        $daysAhead = date('Y-m-d', strtotime($today. ' + 14 days'));
        $orders = Order::where('payment_status', 'COMPLETED')->get();
        if($orders){
            foreach($orders as $order){
                $user = User::where('id', $orders->user_id)->first();
                $orderDetails = OrderDetail::where('order_id', $order->id)->where('order_type', 'level')->where('expiry_date', $daysAhead)->get();
                if($orderDetails){
                    
                    // Admin email for new student registration
                    $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_USER_MEMBERSHIP_EXPIRY'));

                    if ($email_template) {
                        $data = [];
                        foreach ($orderDetails as $order) {
                            $level = Level::where('id', $order->level_id)->first();
                            $data['email_sender_name'] = systemSetting()->email_sender_name;
                            $data['from_email'] = systemSetting()->from_email;
                            $data['to_email'] = [$user->email];
                            $data['cc_to_email'] = [];
                            $data['subject'] = $email_template->subject;

                            $key = ['{{full_name}}', '{{level}}'];
                            $value = [$user->name, $level->title];

                            $newContents = str_replace($key, $value, $email_template->content);

                            $data['contents'] = $newContents;
                            try {
                                $mail = Mail::to($user->email)->send(new EmailNotification($data));
                            } catch (Exception $exception) {
                                dd($exception);
                            }
                        }
                    }
                }
            }
        }
        
    }
}
