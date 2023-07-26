<?php

namespace App\Http\Controllers;

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

class OnlineStudentController extends Controller
{
    //
    public function feedback(){
        $country = Country::get();
        return view('account.feedback', compact('country'));
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
        return redirect()->route('feedback')->with('success', 'Submitted Successfully');
    }

    public function my_course(){
        $level = Level::get();
        return view('account.online-my-course', compact('level'));
    }

    public function detail_course($id){
        $course = Course::find($id);
        $paper_detail=TestPaperDetail::where('paper_id',$course->paper->id)->first();
        $qId=$course->paper->question_template_id;
        //dd($qId);
        if($qId == 5){
            return view('account.courseMultipleDivision', compact("course","paper_detail"));
        }
        elseif($qId == 6){
            return view('account.courseChallenge', compact("course","paper_detail"));
        }
        elseif($qId == 8){
            return view('account.courseAbacus', compact("course","paper_detail"));
        }
        elseif($qId == 7){
            return view('account.coursegMix', compact("course","paper_detail"));
        }
        elseif($qId == 4){
            return view('account.courseAddSubQuestion', compact("course","paper_detail"));
        }
        elseif($qId == 3){
            return view('account.courseNumber', compact("course","paper_detail"));
        }
        elseif($qId == 1){
            return view('account.courseAudio', compact("course","paper_detail"));
        }
        elseif($qId == 2){
            return view('account.courseAudio', compact("course","paper_detail"));
        }
        //return view('account.online-my-course-detail', compact('course'));
    }

    public function submit_course(Request $request){
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
            return view('result-course', compact('totalMarks', 'userMarks'));
        }


    }
}
