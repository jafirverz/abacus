<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SellerParticular;
use App\BuyerParticular;
use App\Chat;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Mail\EmailNotification;
use App\User;

class SendBuyerEmail extends Command
{
    use GetEmailTemplate, SystemSettingTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:buyerspagreement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Emails to buyer who have not submitted S&P Agreement';

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
        $chkSeller = SellerParticular::where('vehicle_main_id', '!=', 0)->get();
        if ($chkSeller) {
            $hours48 = date('Y-m-d', strtotime($chkSeller->created_at . " +48 hours"));
            $hours96 = date('Y-m-d', strtotime($chkSeller->created_at . " +96 hours"));
            $hours144 = date('Y-m-d', strtotime($chkSeller->created_at . " +144 hours"));
            $todayDate = date('Y-m-d');
            $email_template = $this->emailTemplate(__('constant.EMAIL_NOTIFICATION_PREPARE_FOR_EPZ_REMINDER'));
            foreach ($chkSeller as $seller) {
                $buyer = BuyerParticular::where('seller_particular_id', $seller->id)->first();
                if (!$buyer) {
                    $buyerEmail = $seller->buyer_email;
                    $user = User::where('email', $buyerEmail)->first();
                    if ($user) {
                        $chat = Chat::where('buyer_id', $user->id)->where('vechile_main_id', $chkSeller->vehicle_main_id)->first();
                        if ($chat && ($chat->hour_48 != 1)) {
                            if ($todayDate ==  $hours48) {
                                $data = [];
                                $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                                $data['from_email'] = $this->systemSetting()->from_email;
                                $data['to_email'] = [$buyerEmail];
                                $data['cc_to_email'] = [];
                                $data['subject'] = $email_template->subject;
                                // $key = ['{{countdays}}', '{{vehicle_number}}'];
                                // $value = [$daysleft, $stock_data->car_registration_number];
                                // $data['contents'] = str_replace($key, $value, $email_template->content);
                                try {
                                    $mail = Mail::to($data['to_email'])->send(new EmailNotification($data));
                                    $chat->hour_48 = 1;
                                    $chat->save();
                                } catch (Exception $exception) {
                                }
                            }
                        }elseif ($chat && ($chat->hour_96 != 1)) {
                            if ($todayDate ==  $hours96) {
                                $data = [];
                                $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                                $data['from_email'] = $this->systemSetting()->from_email;
                                $data['to_email'] = [$buyerEmail];
                                $data['cc_to_email'] = [];
                                $data['subject'] = $email_template->subject;
                                // $key = ['{{countdays}}', '{{vehicle_number}}'];
                                // $value = [$daysleft, $stock_data->car_registration_number];
                                // $data['contents'] = str_replace($key, $value, $email_template->content);
                                try {
                                    $mail = Mail::to($data['to_email'])->send(new EmailNotification($data));
                                    $chat->hour_96 = 1;
                                    $chat->save();
                                } catch (Exception $exception) {
                                }
                            }
                        }elseif ($chat && ($chat->hour_144 != 1)) {
                            if ($todayDate ==  $hours144) {
                                $data = [];
                                $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                                $data['from_email'] = $this->systemSetting()->from_email;
                                $data['to_email'] = [$buyerEmail];
                                $data['cc_to_email'] = [];
                                $data['subject'] = $email_template->subject;
                                // $key = ['{{countdays}}', '{{vehicle_number}}'];
                                // $value = [$daysleft, $stock_data->car_registration_number];
                                // $data['contents'] = str_replace($key, $value, $email_template->content);
                                try {
                                    $mail = Mail::to($data['to_email'])->send(new EmailNotification($data));
                                    $chat->hour_144 = 1;
                                    $chat->save();
                                } catch (Exception $exception) {
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
