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
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware(function ($request, $next) {
            $this->student_id = Auth::user()->id;
            $this->previous = url()->previous();
            return $next($request);

        });
    }
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
        if($qId == 7) {
            if(empty($worksheetId)){
                return abort(404);
            }
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $lId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $qId)->first();
            return view('account.worksheetMixed', compact("worksheet", 'level', 'questions'));
        }
        if($qId == 8) {
            if(empty($worksheetId)){
                return abort(404);
            }
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $lId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $qId)->first();
            $miscQuestions = MiscQuestion::where('question_id', $questions->id)->groupBy('block')->get();
            return view('account.worksheetAbacus', compact("worksheet", 'level', 'questions', 'miscQuestions'));
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
                    $allQuestions = MiscQuestion::where('question_id', $questions->id)->groupBy('block')->get();
                    return view('account.worksheetMultiply', compact("worksheet", 'level', 'questions', 'allQuestions'));
                }else{
                    $allQuestions = MiscQuestion::where('question_id', $questions->id)->get();
                    return view('account.worksheetDivide', compact("worksheet", 'level', 'questions', 'allQuestions'));
                }
            }else{
                if(isset($_REQUEST['s'])){
                    $allQuestions = MiscQuestion::where('question_id', $questions->id)->inRandomOrder()->get();
                }else{
                    $allQuestions = MiscQuestion::where('question_id', $questions->id)->get();
                }
                //$allQuestions = MiscQuestion::where('question_id', $questions->id)->paginate(10);
                return view('account.worksheetMix', compact("worksheet", 'level', 'questions', 'allQuestions'));
            }
            // return view('account.worksheetChallenge', compact("worksheet", 'level', 'questions'));
        }
        if($qId == 10) {
            if(empty($worksheetId)){
                return abort(404);
            }
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $lId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $qId)->first();
            return view('account.worksheetGradingSample', compact("worksheet", 'level', 'questions'));
        }
        if($qId == 11) {
            if(empty($worksheetId)){
                return abort(404);
            }
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $lId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $qId)->first();
            return view('account.worksheetLearningVideo', compact("worksheet", 'level', 'questions'));
        }
    }

    public function resultpage(Request $request){
        // dd($request->all());
        $worksheetId = $request->worksheetId;
        $levelId = $request->levelId;
        $questionTypeId = $request->questionTypeId;
        $userId = Auth::user()->id;
        $questTem = array(1,2,3,4,5,6,7,8);
        $resultpage = array(1,2,4,5,7,8);
        if(in_array($questionTypeId, $questTem)){
            $workshSub = new WorksheetSubmitted();
            $workshSub->worksheet_id = $worksheetId;
            $workshSub->level_id = $levelId;
            $workshSub->question_template_id = $questionTypeId;
            $workshSub->user_id = $userId;
            $workshSub->save();
            $worksheetSubmittedId = $workshSub->id;
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
        if($questionTypeId == 1){
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $levelId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $questionTypeId)->first();
            //return view('account.worksheetNumber', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks'));
            return view('resultListening', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks', 'worksheetSubmittedId'));
        }
        if($questionTypeId == 2){
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $levelId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $questionTypeId)->first();
            //return view('account.worksheetNumber', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks'));
            return view('resultVideo', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks', 'worksheetSubmittedId'));
        }
        if($questionTypeId == 4){
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $levelId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $questionTypeId)->first();
            //return view('account.worksheetNumber', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks'));
            return view('resultAddSubtract', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks', 'worksheetSubmittedId'));
        }
        if($questionTypeId == 5){
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $levelId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $questionTypeId)->first();
            //return view('account.worksheetNumber', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks'));
            return view('resultMixx', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks', 'worksheetSubmittedId'));
        }
        if($questionTypeId == 7){
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            $level = Level::where('id', $levelId)->first();
            $questions = Question::where('worksheet_id', $worksheetId)->where('question_type', $questionTypeId)->first();
            //return view('account.worksheetNumber', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks'));
            return view('resultmix7', compact("worksheet", 'level', 'questions','totalMarks', 'userMarks', 'worksheetSubmittedId'));
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
        if($questionTypeId == 6){
            $level = Level::where('id', $levelId)->first();
            $worksheet = Worksheet::where('id', $worksheetId)->first();
            return view('resultChallenge', compact('totalMarks','level','worksheet','userMarks'));
        }
        
    }

    public function leaderboard(Request $request, $levelid = null, $worksheetId = null){
        // dd($worksheetId);
        $page = get_page_by_slug('leaderboard');
        if (!$page) {
            return abort(404);
        }
        $level = Level::where('id', $levelid)->first();
        $worksheetSubmitted = WorksheetSubmitted::where('level_id', $levelid)->where('worksheet_id', $worksheetId)->where('question_template_id', 6)->orderBy('user_marks', 'desc')->get()->unique('user_id');
        return view('leaderboard', compact('worksheetSubmitted', 'levelid', 'worksheetId', 'level', 'page'));
    }
}
