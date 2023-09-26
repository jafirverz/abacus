<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\Country;
use App\Course;
use App\TestPaper;
use App\CourseSubmitted;
use App\CourseQuestionSubmitted;
use App\Level;
use App\TestPaperDetail;
use App\TestPaperQuestionDetail;
use App\UserFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Admin;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;
use Exception;

class OnlineStudentController extends Controller
{
    //
    use GetEmailTemplate, SystemSettingTrait;
    public function feedback(){
        $country = Country::get();
        $courses = Course::get();
        return view('account.feedback', compact('country', 'courses'));
    }

    public function feedbackstore(Request $request){
        $userfeedback = new UserFeedback();
        $userfeedback->enquiry = $request->enquiry;
        $userfeedback->message = $request->message;
        $userfeedback->user_id = Auth::user()->id;
        $userfeedback->name = Auth::user()->name;
        $userfeedback->email = Auth::user()->email;
        $userfeedback->phone = Auth::user()->mobile;
        $userfeedback->save();

        //			Admin email for new student registration
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_FEEBACK'));
        $admins = Admin::get();

        if ($email_template) {
            $data = [];
            foreach ($admins as $admin) {
                $data['email_sender_name'] = systemSetting()->email_sender_name;
                $data['from_email'] = systemSetting()->from_email;
                $data['to_email'] = [$admin->email];
                $data['cc_to_email'] = [];
                $data['subject'] = $email_template->subject;

                $key = ['{{full_name}}', '{{email}}', '{{contact_number}}', '{{enquiry}}', '{{message}}'];
                $value = [Auth::user()->name, Auth::user()->email, Auth::user()->mobile, $request->enquiry, $request->message];

                $newContents = str_replace($key, $value, $email_template->content);

                $data['contents'] = $newContents;
                try {
                    $mail = Mail::to($admin->email)->send(new EmailNotification($data));
                } catch (Exception $exception) {
                    dd($exception);
                }
            }
        }
        return redirect()->route('feedback')->with('success', 'Submitted Successfully');
    }

    public function my_course(){
        $level = Level::get();
        $courseCertificate = CourseSubmitted::where('user_id', Auth::user()->id)->where('is_submitted',1)->where('certificate_id', '!=', null)->get();
        return view('account.online-my-course', compact('level', 'courseCertificate'));
    }

    public function detail_course($id){
        $course = Course::find($id);
        $test_paper=TestPaper::where('id',$course->paper->id)->first();
        $paper_detail=TestPaperDetail::where('paper_id',$course->paper->id)->first();
        if(!isset($paper_detail))
        {
            abort(404);
        }
        $qId=$course->paper->question_template_id;
        $courseSubmitted = CourseSubmitted::where('course_id',$id)->where('course_submitteds.user_id', Auth::user()->id)->first();
        //dd($courseSubmitted);
        if($qId == 5){
            return view('account.courseMultipleDivision', compact("course","paper_detail","test_paper","courseSubmitted"));
        }
        elseif($qId == 6){
            return view('account.courseChallenge', compact("course","paper_detail","test_paper","courseSubmitted"));
        }
        elseif($qId == 8){
            return view('account.courseAbacus', compact("course","paper_detail","test_paper","courseSubmitted"));
        }
        elseif($qId == 7){
            return view('account.courseMix', compact("course","paper_detail","test_paper","courseSubmitted"));
        }
        elseif($qId == 4){
            return view('account.courseAddSubQuestion', compact("course","paper_detail","test_paper","courseSubmitted"));
        }
        elseif($qId == 3){
            return view('account.courseNumber', compact("course","paper_detail","test_paper","courseSubmitted"));
        }
        elseif($qId == 1){
            return view('account.courseAudio', compact("course","paper_detail","test_paper","courseSubmitted"));
        }
        elseif($qId == 2){
            return view('account.courseVideo', compact("course","paper_detail","test_paper","courseSubmitted"));
        }
        //return view('account.online-my-course-detail', compact('course'));
    }

    public function submit_course(Request $request){

        //dd($request);


        if(isset($request->course_submitted_id) &&  $request->is_submitted==1)
        {
            $course_sub=CourseSubmitted::find($request->course_submitted_id);

            CourseQuestionSubmitted::where('course_submitted_id',$course_sub->id)->delete();
            CourseSubmitted::where('id',$request->course_submitted_id)->delete();

        }

        $test_paper_question_id = $request->test_paper_question_id;
        $course_id = $request->course_id;
        $questionTypeId = $request->question_type;
        $userId = Auth::user()->id;
        $questTem = array(1,2,3,4,5,6,7,8);
        $resultpage = array(1,2,3,4,5,6,7,8);
        if(in_array($questionTypeId, $questTem)){
            $courseSub = new CourseSubmitted();
            $courseSub->test_paper_question_id   = $test_paper_question_id;
            $courseSub->course_id  = $course_id;
            $courseSub->question_template_id = $questionTypeId;
            $courseSub->user_id = $userId;
            $courseSub->certificate_id = 3;
            $courseSub->is_submitted = $request->is_submitted;
            $courseSub->save();
            $totalMarks = 0;
            $userMarks = 0;

            foreach($request->answer as $key=>$value){
                $quesSub = new CourseQuestionSubmitted();
                $testPaperQuestion = TestPaperQuestionDetail::where('id', $key)->first();
                $quesSub->course_submitted_id   = $courseSub->id;
                $quesSub->question_id = $key;
                $quesSub->question_answer = $testPaperQuestion->answer;
                //dd($testPaperQuestion);
                $quesSub->user_answer = $value;
                $quesSub->marks = $testPaperQuestion->marks;
                if($value == $testPaperQuestion->answer){
                    $quesSub->user_marks = $testPaperQuestion->marks;
                    $userMarks+= $testPaperQuestion->marks;
                }else{
                    $quesSub->user_marks = null;
                }
                $totalMarks+= $testPaperQuestion->marks;
                $quesSub->save();
            }
            $saveResult = CourseSubmitted::where('id', $courseSub->id)->first();
            $saveResult->total_marks = $totalMarks;
            $saveResult->user_marks = $userMarks;
            $saveResult->save();
        }
        if(in_array($questionTypeId, $resultpage)){
            return view('result-course', compact('totalMarks', 'userMarks','courseSub'));
        }


    }
    public function aboutPage(){
        $slug = 'about-3g-abacus';
        $page = get_page_by_slug($slug);
        if (!$page) {
            return abort(404);
        }
        return view('account.about', compact('page'));
    }

    public function downloadCertificate( $id = null){
        $courseSubmitted = CourseSubmitted::where('id', $id)->first();
        $certificate = Certificate::where('id', $courseSubmitted->certificate_id)->first();
        $key = ['{{course_name}}','{{full_name}}','{{email}}','{{dob}}','{{contact_number}}','{{address}}'];
        $value = [$courseSubmitted->course->title, Auth::user()->name, Auth::user()->email, Auth::user()->dob, Auth::user()->mobile, Auth::user()->address];
        $newContents = str_replace($key, $value, $certificate->content);
        $pdf = PDF::loadView('account.certificate_pdf', compact('newContents'));
        return $pdf->download('certificate.pdf');
    }
}
