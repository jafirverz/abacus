<?php

namespace App\Http\Controllers;

use App\Level;
use App\Question;
use App\Worksheet;
use Illuminate\Http\Request;

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
    }
}
