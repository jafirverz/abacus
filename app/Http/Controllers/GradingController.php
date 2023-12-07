<?php

namespace App\Http\Controllers;

use App\GradingExam;
use App\GradingCategory;
use App\GradingPaper;
use App\GradingQuestionSubmitted;
use App\GradingSubmitted;
use App\GradingPaperQuestion;
use App\GradingStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradingController extends Controller
{
    //
    public function index($id){
        $competition = GradingExam::where('id', $id)->first();
        if($competition){
            if($competition->competition_type == 'physical'){
                return view('grading_physical', compact("competition"));
            }else{
                return view('grading_online', compact("competition"));
            }
        }else{
            return abort(404);
        }
    }

    public function paper($id){
        $compPaper = GradingPaper::where('id', $id)->first();
        $compPaperTitle = $compPaper->title;
        $compId = $compPaper->grading_exam_id;
        $comDetails = GradingExam::where('id', $compId)->first();
        $compeTitle = $comDetails->title;
        $compStudent = GradingStudent::where('grading_exam_id', $compId)->where('user_id', Auth::user()->id)->first();
        //$compStudentCateogyId = $compStudent->category_id;
        //$compC = GradingCategory::where('id', $compStudentCateogyId)->first();

        //dd($compPaper->question_template_id);
        $categoryTitle = '';
        if($compPaper){
            if($compPaper->question_template_id == 1){
                $questions = GradingPaperQuestion::where('grading_paper_id', $id)->groupBy('block')->get();
                return view('account.gradingAudio', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
            }
            if($compPaper->question_template_id == 2){
                $questions = GradingPaperQuestion::where('grading_paper_id', $id)->get();
                return view('account.gradingVideo', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
            }
            if($compPaper->question_template_id == 3){
                $questions = GradingPaperQuestion::where('grading_paper_id', $id)->get();
                return view('account.gradingNumber', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
            }
            if($compPaper->question_template_id == 4){
                $questions = GradingPaperQuestion::where('grading_paper_id', $id)->get();
                return view('account.gradingAddSubtract', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
            }
            if($compPaper->question_template_id == 5){
                $questions = GradingPaperQuestion::where('grading_paper_id', $id)->get();
                return view('account.gradingMultiplyDivide', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
            }
            if($compPaper->question_template_id == 6){
                $questions = GradingPaperQuestion::where('grading_paper_id', $id)->get();
                return view('account.gradingChallenge', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
            }
            if($compPaper->question_template_id == 7){
                $questions = GradingPaperQuestion::where('grading_paper_id', $id)->get();
                return view('account.gradingMix', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
            }
        }else{
            return abort(404);
        }

    }

    public function submitPaper(Request $request){
        $compId = $request->compId;
        $paperId = $request->paperId;
        $questionTypeId = $request->questionTemp;
        $paperType = $request->paperType;
        $categoryId = $request->categoryId;
        $userId = Auth::user()->id;
        $questTem = array(1,2,3,4,5,6,7,8);
        //$resultpage = array(1,2,4,5,6,8);
        if(in_array($questionTypeId, $questTem)){
            $workshSub = new GradingSubmitted();
            $workshSub->grading_exam_id  = $compId;
            $workshSub->paper_id  = $paperId;
            //$workshSub->question_template_id = $questionTypeId;
            $workshSub->paper_type = $paperType;
            $workshSub->user_id = $userId;
            $workshSub->category_id = $categoryId;
            $workshSub->save();
            $totalMarks = 0;
            $userMarks = 0;
            foreach($request->answer as $key=>$value){
                $worksheetQuesSub = new GradingQuestionSubmitted();
                $miscQuestion = GradingPaperQuestion::where('id', $key)->first();
                $worksheetQuesSub->grading_submitted_id  = $workshSub->id;
                $worksheetQuesSub->question_id  = $key;
                $worksheetQuesSub->question_answer = $miscQuestion->answer;
                $worksheetQuesSub->user_answer = $value;
                $worksheetQuesSub->marks = $miscQuestion->marks;
                if($value == $miscQuestion->answer){
                    $worksheetQuesSub->user_marks = $miscQuestion->marks;
                    $userMarks+= $miscQuestion->marks;
                }else{
                    $worksheetQuesSub->user_marks = null;
                }
                $totalMarks+= $miscQuestion->marks;
                $worksheetQuesSub->save();
            }
            $saveResult = GradingSubmitted::where('id', $workshSub->id)->first();
            $saveResult->total_marks = $totalMarks;
            $saveResult->user_marks = $userMarks;
            $saveResult->save();
        }
        return view('result-grade', compact('totalMarks', 'userMarks', 'paperType'));
        // if(in_array($questionTypeId, $resultpage)){
        //     return view('result-competition', compact('totalMarks', 'userMarks', 'paperType'));
        // }
        // if($questionTypeId == 3){
        //     $worksheet = Worksheet::where('id', $worksheetId)->first();
        //     $level = Level::where('id', $levelId)->first();
        //     $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $questionTypeId)->first();
        //     //return view('account.worksheetNumber', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks'));
        //     return view('resultNumber', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks'));
        // }
    }
}
