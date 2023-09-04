<?php

namespace App\Http\Controllers;

use App\Survey;
use App\SurveyQuestion;
use App\UserSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Mail;
use App\Admin;
use App\Allocation;
use Exception;

class SurveyController extends Controller
{
    use GetEmailTemplate, SystemSettingTrait;
    //
    public function index(){
        $surveys = Survey::where('status', 1)->first();
        if($surveys){
            $surveyQuestions = SurveyQuestion::where('survey_id', $surveys->id)->get();
        }else{
            $surveyQuestions = '';
        }
        $allocation = Allocation::where('student_id', Auth::user()->id)->where('is_finished', null)->orderBy('id', 'desc')->first();
        if(!$allocation){
            return abort(404);
        }
        return view('account.surveyForm', compact('surveyQuestions', 'surveys'));
    }

    public function store(Request $request){
        //dd($request->all());
        $surveyId = $request->surveyId;
        $userId = Auth::user()->id;
        $surveyData = json_encode($request->all());
        $user_survey = new UserSurvey();
        $user_survey->survey_id = $surveyId;
        $user_survey->user_id = $userId;
        $user_survey->survey_data = $surveyData;
        $user_survey->save();

        $allocation = Allocation::where('student_id', Auth::user()->id)->where('type', 2)->where('is_finished', null)->orderBy('id', 'desc')->first();
        if($allocation){
            $allocation->is_finished = 1;
            $allocation->certificate_id = 1;
            $allocation->save();
        }

        // Admin email for new student registration
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_SURVEY'));
        $admins = Admin::get();

        if ($email_template) {
            $data = [];
            foreach($admins as $admin){
                $data['email_sender_name'] = systemSetting()->email_sender_name;
                $data['from_email'] = systemSetting()->from_email;
                $data['to_email'] = [$admin->email];
                $data['cc_to_email'] = [];
                $data['subject'] = $email_template->subject;

                $key = ['{{full_name}}','{{email}}'];
                $value = [$request->name ?? Auth::user()->name, Auth::user()->email];

                $newContents = str_replace($key, $value, $email_template->content);

                $data['contents'] = $newContents;
                try {
                    $mail = Mail::to($admin->email)->send(new EmailNotification($data));
                } catch (Exception $exception) {
                    dd($exception);
                }
            }

        }

        return redirect('/');
    }
}
