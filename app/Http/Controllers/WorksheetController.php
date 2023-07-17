<?php

namespace App\Http\Controllers;

use App\Level;
use App\MiscQuestion;
use App\Question;
use App\Worksheet;
use App\WorksheetQuestionSubmitted;
use App\WorksheetSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class WorksheetController extends Controller
{
    //
    public function index($worksheetId = null, $qId = null, $lId = null){
        if($qId == 4){
            if(empty($worksheetId)){
                return abort(404);
            }
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $lId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $qId)->first();
            return view('account.worksheetQuestion', compact("worksheet", 'level', 'questions'));
        }
        if($qId == 2) {
            if(empty($worksheetId)){
                return abort(404);
            }
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $lId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $qId)->first();
            return view('account.worksheetVideo', compact("worksheet", 'level', 'questions'));
        }

        if($qId == 1) {
            if(empty($worksheetId)){
                return abort(404);
            }
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $lId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $qId)->first();
            return view('account.worksheetAudio', compact("worksheet", 'level', 'questions'));
        }

        if($qId == 3) {
            if(empty($worksheetId)){
                return abort(404);
            }
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $lId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $qId)->first();
            return view('account.worksheetNumber', compact("worksheet", 'level', 'questions'));
        }

        if($qId == 6) {
            if(empty($worksheetId)){
                return abort(404);
            }
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $lId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $qId)->first();
            return view('account.worksheetChallenge', compact("worksheet", 'level', 'questions'));
        }
        if($qId == 5) {
            if(empty($worksheetId)){
                return abort(404);
            }
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $lId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $qId)->first();
            $miscQuestion = MiscQuestion::where('question_id', $questions->id)->pluck('symbol')->toArray();
            $miscQuestion = array_unique($miscQuestion);
            if(count($miscQuestion) == 1){
                if($miscQuestion[0] == 'multiply'){
                    $allQuestions = MiscQuestion::where('question_id', $questions->id)->paginate(10);
                    return view('account.worksheetMultiply', compact("worksheet", 'level', 'questions', 'allQuestions'));
                }else{
                    $allQuestions = MiscQuestion::where('question_id', $questions->id)->paginate(10);
                    return view('account.worksheetDivide', compact("worksheet", 'level', 'questions', 'allQuestions'));
                }
            }else{
                $allQuestions = MiscQuestion::where('question_id', $questions->id)->paginate(10);
                return view('account.worksheetMix', compact("worksheet", 'level', 'questions', 'allQuestions'));
            }
            // return view('account.worksheetChallenge', compact("worksheet", 'level', 'questions'));
        }
    }

    public function resultpage(Request $request){
        $worksheetId = $request->worksheetId;
        $levelId = $request->levelId;
        $questionTypeId = $request->questionTypeId;
        $userId = Auth::user()->id;
        $questTem = array(1,2,3,5,6);
        $resultpage = array(1,2,5,6);
        if(in_array($questionTypeId, $questTem)){
            $workshSub = new WorksheetSubmitted();
            $workshSub->worksheet_id = $worksheetId;
            $workshSub->level_id = $levelId;
            $workshSub->question_template_id = $questionTypeId;
            $workshSub->user_id = $userId;
            $workshSub->save();
            $totalMarks = 0;
            $userMarks = 0;
            foreach($request->answer as $key=>$value){
                $worksheetQuesSub = new WorksheetQuestionSubmitted();
                $miscQuestion = MiscQuestion::where('id', $key)->first();
                $worksheetQuesSub->worksheet_submitted_id = $workshSub->id;
                $worksheetQuesSub->misc_question_id = $key;
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
            $saveResult = WorksheetSubmitted::where('id', $workshSub->id)->first();
            $saveResult->total_marks = $totalMarks;
            $saveResult->user_marks = $userMarks;
            $saveResult->save();
        }
        if(in_array($questionTypeId, $resultpage)){
            return view('result', compact('totalMarks', 'userMarks'));
        }
        if($questionTypeId == 3){
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $levelId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $questionTypeId)->first();
            //return view('account.worksheetNumber', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks'));
            return view('resultNumber', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks'));
        }
        
    }
}
