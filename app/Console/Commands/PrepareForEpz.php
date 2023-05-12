<?php

namespace App\Console\Commands;

use App\Mail\EmailNotification;
use App\NewCarStock;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PrepareForEpz extends Command
{
    use GetEmailTemplate, SystemSettingTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:prepareepz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepare for EPZ Reminder';

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
        $car_stock = NewCarStock::whereHas('stockmeta')->get();
        if($car_stock->count())
        {
            foreach($car_stock as $item)
            {
                $stock_data = json_decode($item->stock_data);
                if(isset($stock_data->deregistration) && $stock_data->deregistration!=='')
                {
                    $today = Carbon::now();
                    $deregistration = new Carbon($stock_data->deregistration);
                    $daysleft30 = $deregistration->copy()->addMonth(1);
                    $daysleft = $today->diffInDays($daysleft30);

                    if($daysleft==__("constant.EPZ_REMINDER_14DAYS") || $daysleft==__("constant.EPZ_REMINDER_7DAYS") || $daysleft==__("constant.EPZ_REMINDER_5DAYS"))
                    {
                        $email_template = $this->emailTemplate(__('constant.EMAIL_NOTIFICATION_PREPARE_FOR_EPZ_REMINDER'));
                        if($email_template)
                        {
                            $data = [];

                            $stock_id = $item->meta_id;

                            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                            $data['from_email'] = $this->systemSetting()->from_email;
                            $data['to_email'] = [$item->admin->email];
                            $data['cc_to_email'] = [];


                            $data['subject'] = $email_template->subject;

                            $key = ['{{countdays}}', '{{vehicle_number}}'];
                            $value = [$daysleft, $stock_data->car_registration_number];
                            $data['contents'] = str_replace($key, $value, $email_template->content);

                            try {
                                if($daysleft==__("constant.EPZ_REMINDER_5DAYS"))
                                {
                                    // sms
                                }
                                $mail = Mail::to($data['to_email'])->send(new EmailNotification($data));
                            } catch (Exception $exception) {
                                // dd($exception);
                            }
                        }
                    }
                }
            }
        }
    }
}
