<?php

namespace App\Console\Commands;

use App\Mail\EmailNotification;
use App\NewCarStock;
use App\StockMeta;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DisposalReminder extends Command
{
    use GetEmailTemplate, SystemSettingTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:disposal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disposal Reminder';

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

                // NOTE DISPOSAL WITH EPZ
                if((isset($stock_data->deregistration) && $stock_data->deregistration!=='') && (isset($stock_data->epz_entrance_date) && $stock_data->epz_entrance_date!==''))
                {
                    $today = Carbon::now();
                    $deregistration = new Carbon($stock_data->deregistration);
                    $pending_daysleft = $deregistration->copy()->addYear(1);
                    $daysleft = $today->diffInDays($pending_daysleft);

                    if($daysleft<__("constant.DISPOSAL_REMINDER_10DAYS"))
                    {
                        $meta = StockMeta::find($item->stock_meta_id);
                        $meta->tab_status = __('constant.T_CAR_TO_BE_DISPOSED');
                        $meta->save();
                    }
                    if($daysleft==__("constant.DISPOSAL_REMINDER_7DAYS"))
                    {
                        $email_template = $this->emailTemplate(__('constant.EMAIL_NOTIFICATION_DISPOSAL_REMINDER'));
                        if($email_template)
                        {
                            $data = [];

                            $stock_id = $item->meta_id;

                            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                            $data['from_email'] = $this->systemSetting()->from_email;
                            $data['to_email'] = [$item->admin->email];
                            $data['cc_to_email'] = [];


                            $data['subject'] = $email_template->subject;

                            $key = ['{{stock_id}}', '{{vehicle_number}}', '{{disposal_date}}'];
                            $value = [$stock_id, $stock_data->car_registration_number, $pending_daysleft->format('d M, Y')];
                            $data['contents'] = str_replace($key, $value, $email_template->content);

                            try {
                                $mail = Mail::to($data['to_email'])->send(new EmailNotification($data));
                            } catch (Exception $exception) {
                                // dd($exception);
                            }
                        }
                    }
                }
                // NOTE DISPOSAL WITHOUT EPZ
                elseif((isset($stock_data->deregistration) && $stock_data->deregistration!==''))
                {
                    $today = Carbon::now();
                    $deregistration = new Carbon($stock_data->deregistration);
                    $pending_daysleft = $deregistration->copy()->addMonth(1);
                    $daysleft = $today->diffInDays($pending_daysleft);

                    if($daysleft<__("constant.DISPOSAL_REMINDER_10DAYS"))
                    {
                        $meta = StockMeta::find($item->stock_meta_id);
                        $meta->tab_status = __('constant.T_CAR_TO_BE_DISPOSED');
                        $meta->save();
                    }
                    if($daysleft==__("constant.DISPOSAL_REMINDER_7DAYS"))
                    {
                        $email_template = $this->emailTemplate(__('constant.EMAIL_NOTIFICATION_DISPOSAL_REMINDER'));
                        if($email_template)
                        {
                            $data = [];

                            $stock_id = $item->meta_id;

                            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                            $data['from_email'] = $this->systemSetting()->from_email;
                            $data['to_email'] = [$item->admin->email];
                            $data['cc_to_email'] = [];


                            $data['subject'] = $email_template->subject;

                            $key = ['{{stock_id}}', '{{vehicle_number}}', '{{disposal_date}}'];
                            $value = [$stock_id, $stock_data->car_registration_number, $pending_daysleft->format('d M, Y')];
                            $data['contents'] = str_replace($key, $value, $email_template->content);

                            try {
                                $mail = Mail::to($data['to_email'])->send(new EmailNotification($data));
                            } catch (Exception $exception) {
                                // dd($exception);
                            }
                        }
                    }
                }
                // NOTE DISPOSAL WITH EPZ AND EPZ EXIT DATE IS ENTERED
                if((isset($stock_data->epz_exit_date) && $stock_data->epz_exit_date!==''))
                {
                    $today = Carbon::now();
                    $epz_exit_date = new Carbon($stock_data->epz_exit_date);
                    $pending_daysleft = $epz_exit_date->copy()->addDays(14);
                    $daysleft = $today->diffInDays($pending_daysleft);

                    if($daysleft<__("constant.DISPOSAL_REMINDER_10DAYS"))
                    {
                        $meta = StockMeta::find($item->stock_meta_id);
                        $meta->tab_status = __('constant.T_CAR_TO_BE_DISPOSED');
                        $meta->save();
                    }
                    if($daysleft==__("constant.DISPOSAL_REMINDER_7DAYS"))
                    {
                        $email_template = $this->emailTemplate(__('constant.EMAIL_NOTIFICATION_DISPOSAL_REMINDER'));
                        if($email_template)
                        {
                            $data = [];

                            $stock_id = $item->meta_id;

                            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                            $data['from_email'] = $this->systemSetting()->from_email;
                            $data['to_email'] = [$item->admin->email];
                            $data['cc_to_email'] = [];


                            $data['subject'] = $email_template->subject;

                            $key = ['{{stock_id}}', '{{vehicle_number}}', '{{disposal_date}}'];
                            $value = [$stock_id, $stock_data->car_registration_number, $pending_daysleft->format('d M, Y')];
                            $data['contents'] = str_replace($key, $value, $email_template->content);

                            try {
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
