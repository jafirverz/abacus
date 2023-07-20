<?php

namespace App\Http\Controllers;

use App\Competition;
use App\CompetitionPaper;
use App\CompetitionPaperQuestionSubmitted;
use App\CompetitionPaperSubmitted;
use App\CompetitionQuestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetitionController extends Controller
{
    //
    public function index($id){
        $competition = Competition::where('id', $id)->first();
        if($competition){
            if($competition->competition_type == 'physical'){
                return view('competition_physical', compact("competition"));
            }else{
                return view('competition_online', compact("competition"));
            }
        }else{
            return abort(404);
        }
    }

    public function paper($id){
        $compPaper = CompetitionPaper::where('id', $id)->first();
        if($compPaper){
            if($compPaper->question_template_id == 1){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->groupBy('block')->get();
                return view('account.competitionAudio', compact('questions', 'compPaper'));
            }
            if($compPaper->question_template_id == 2){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionVideo', compact('questions', 'compPaper'));
            }
            if($compPaper->question_template_id == 3){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionNumber', compact('questions', 'compPaper'));
            }
            if($compPaper->question_template_id == 4){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionAddSubtract', compact('questions', 'compPaper'));
            }
            if($compPaper->question_template_id == 5){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionMultiplyDivide', compact('questions', 'compPaper'));
            }
            if($compPaper->question_template_id == 6){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionChallenge', compact('questions', 'compPaper'));
            }
            if($compPaper->question_template_id == 7){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionMix', compact('questions', 'compPaper'));
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
        $userId = Auth::user()->id;
        $questTem = array(1,2,3,4,5,6,7,8);
        //$resultpage = array(1,2,4,5,6,8);
        if(in_array($questionTypeId, $questTem)){
            $workshSub = new CompetitionPaperSubmitted();
            $workshSub->competition_id = $compId;
            $workshSub->competition_paper_id = $paperId;
            //$workshSub->question_template_id = $questionTypeId;
            $workshSub->user_id = $userId;
            $workshSub->save();
            $totalMarks = 0;
            $userMarks = 0;
            foreach($request->answer as $key=>$value){
                $worksheetQuesSub = new CompetitionPaperQuestionSubmitted();
                $miscQuestion = CompetitionQuestions::where('id', $key)->first();
                $worksheetQuesSub->competition_paper_submitted_id = $workshSub->id;
                $worksheetQuesSub->competition_question_id = $key;
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
            $saveResult = CompetitionPaperSubmitted::where('id', $workshSub->id)->first();
            $saveResult->total_marks = $totalMarks;
            $saveResult->user_marks = $userMarks;
            $saveResult->save();
        }
        return view('result-competition', compact('totalMarks', 'userMarks', 'paperType'));
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
