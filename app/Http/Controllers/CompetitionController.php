<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\Competition;
use App\CompetitionCategory;
use App\CompetitionPaper;
use App\CompetitionPaperQuestionSubmitted;
use App\CompetitionPaperSubmitted;
use App\CompetitionQuestions;
use App\CompetitionStudent;
use App\CompetitionStudentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class CompetitionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware(function ($request, $next) {
            $this->student_id = Auth::user()->id;
            $this->previous = url()->previous();
            return $next($request);

        });
    }
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
        $compPaperTitle = $compPaper->title;
        $compId = $compPaper->competition_controller_id;
        $comDetails = Competition::where('id', $compId)->first();
        $compeTitle = $comDetails->title;
        $compStudent = CompetitionStudent::where('competition_controller_id', $compId)->where('user_id', Auth::user()->id)->first();
        $compStudentCateogyId = $compStudent->category_id;
        $compC = CompetitionCategory::where('id', $compStudentCateogyId)->first();
        $categoryTitle = $compC->category_name;
        if($compPaper){
            if($compPaper->question_template_id == 1){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->groupBy('block')->get();
                return view('account.competitionAudio', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
            }
            if($compPaper->question_template_id == 2){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionVideo', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
            }
            if($compPaper->question_template_id == 3){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionNumber', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
            }
            if($compPaper->question_template_id == 4){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionAddSubtract', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
            }
            if($compPaper->question_template_id == 5){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionMultiplyDivide', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
            }
            if($compPaper->question_template_id == 6){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionChallenge', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
            }
            if($compPaper->question_template_id == 7){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionMix', compact('questions', 'compPaper', 'compeTitle', 'compPaperTitle', 'categoryTitle'));
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
            $workshSub = new CompetitionPaperSubmitted();
            $workshSub->competition_id = $compId;
            $workshSub->competition_paper_id = $paperId;
            //$workshSub->question_template_id = $questionTypeId;
            $workshSub->paper_type = $paperType;
            $workshSub->user_id = $userId;
            $workshSub->category_id = $categoryId;
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
        return view('result-competition', compact('totalMarks', 'userMarks', 'paperType', 'compId'));
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

    public function downloadCertificate($id = null){
        $compCompleted = CompetitionStudentResult::where('id', $id)->first();
        $certificate = Certificate::where('id', $compCompleted->certificate_id)->first();

        $competition = Competition::where('id', $compCompleted->competition_id)->first();

        $logo='<img style="width: 220px" width="220" src="http://abacus.verz1.com/storage/site_logo/20230522101759_3g-abacus-logo.png" alt="abacus" />';

        $logoFoot='<img style="width: 180px" width="180" src="http://abacus.verz1.com/storage/images/1702371736__65782198b8449__3g-abacus-foot.png" alt="abacus" />';

        //$bg = 'http://abacus.verz1.com/storage/images/1702371744__657821a0f0a96__bg-certificate-2.jpg';

        $bg1 = 'http://abacus.verz1.com/storage/images/1702371744__657821a0f0a96__bg-certificate-2.jpg';

        $bg = '<div style="background: url('.$bg1.') no-repeat 0 0; border: #333 solid 1px; color: #000; font-family: NotoSans, Arial; font-size: 16px; line-height: 1.4; margin: 0 auto; max-width: 840px;">';

        //$date_of_issue_certificate=date('j F,Y',strtotime($compCompleted->certificate_issued_on));

        $key = ['{{comp_title}}','{{user_name}}', '{{category}}', '{{competition_date}}', '{{logo}}','{{logofoot}}', '{{$bg}}'];

        $value = [$competition->title, Auth::user()->name, 'Category name',  $competition->date_of_competition, $logo, $logoFoot, $bg];

        $newContents = str_replace($key, $value, $certificate->content);

        $pdf = PDF::loadView('account.certificate_pdf', compact('newContents'));
        return $pdf->download('certificate.pdf');
    }
}
