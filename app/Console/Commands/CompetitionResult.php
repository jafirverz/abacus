<?php

namespace App\Console\Commands;

use App\Competition;
use App\CompetitionResultUpload;
use App\CompetitionStudentResult;
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
use Excel;
use App\Imports\ImportCompetitionResult;
use App\TempStudentCompetitionResult;

class CompetitionResult extends Command
{
    use GetEmailTemplate, SystemSettingTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'competition:results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert Competition Result';

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
        $filepath = CompetitionResultUpload::where('is_published', 0)->where('result_publish_date', date('Y-m-d'))->get();
        foreach($filepath as $file){
          $id = $file->id;
          $allItems = TempStudentCompetitionResult::where('cru_id', $id)->get();
          foreach($allItems as $item){
            $newResult = new CompetitionStudentResult();
            $newResult->competition_id = $item->competition_id;
            $newResult->user_id = $item->user_id;
            $newResult->category_id = $item->category_id;
            $newResult->total_marks = $item->total_marks;
            $newResult->result = $item->result;
            $newResult->rank = $item->rank;
            $newResult->abacus_grade = $item->abacus_grade;
            $newResult->mental_grade = $item->mental_grade;
            $newResult->prize = $item->prize;
            $newResult->certificate_id = $item->certificate_id;
            $newResult->save();

            $item->delete();
          }
          $file->is_published = 1;
          $file->save();
        } 
        
        
    }
}
