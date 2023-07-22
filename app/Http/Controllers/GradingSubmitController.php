<?php

namespace App\Http\Controllers;

use App\GradingExam;
use App\GradingPaper;
use App\GradingExamList;
use App\GradingSubmitted;
use App\GradingQuestionSubmitted;
use App\GradingPaperQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class GradingSubmitController extends Controller
{
    //
    public function index(){

    }

    public function resultpage(Request $request){
        $grading_exam_id = $request->grading_exam_id;
        $listing_id = $request->listing_id;
        $paper_id = $request->paper_id;
        $questionTypeId = $request->question_type;
        $userId = Auth::user()->id;
        $questTem = array(1,2,3,4,5,6,8);
        $resultpage = array(1,2,4,5,6,8);
        if(in_array($questionTypeId, $questTem)){
            $gradeSub = new GradingSubmitted();
            $gradeSub->grading_exam_id  = $grading_exam_id;
            $gradeSub->paper_id = $paper_id;
            $gradeSub->question_template_id = $questionTypeId;
            $gradeSub->user_id = $userId;
            $gradeSub->save();
            $totalMarks = 0;
            $userMarks = 0;

            foreach($request->answer as $key=>$value){
                $quesSub = new GradingQuestionSubmitted();
                $gradingPaperQuestion = GradingPaperQuestion::where('id', $key)->first();
                $quesSub->grading_submitted_id  = $gradeSub->id;
                $quesSub->question_id = $key;
                $quesSub->question_answer = $gradingPaperQuestion->answer;
                //dd($gradingPaperQuestion);
                $quesSub->user_answer = $value;
                $quesSub->marks = $gradingPaperQuestion->marks;
                if($value == $gradingPaperQuestion->answer){
                    $quesSub->user_marks = $gradingPaperQuestion->marks;
                    $userMarks+= $gradingPaperQuestion->marks;
                }else{
                    $quesSub->user_marks = null;
                }
                $totalMarks+= $gradingPaperQuestion->marks;
                $quesSub->save();
            }
            $saveResult = GradingSubmitted::where('id', $gradeSub->id)->first();
            $saveResult->total_marks = $totalMarks;
            $saveResult->user_marks = $userMarks;
            $saveResult->save();
        }
        if(in_array($questionTypeId, $resultpage)){
            return view('result-grade', compact('totalMarks', 'userMarks'));
        }


    }
}
