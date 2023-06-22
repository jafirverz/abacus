<?php

namespace App\Http\Controllers;

use App\Level;
use App\MiscQuestion;
use App\Question;
use App\Worksheet;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
}
