<?php

namespace App\Http\Controllers;

use App\Competition;
use App\CompetitionPaper;
use App\CompetitionQuestions;
use Illuminate\Http\Request;

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
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionAudio', compact('questions'));
            }
            if($compPaper->question_template_id == 2){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionAudio', compact('questions'));
            }
            if($compPaper->question_template_id == 3){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionAudio', compact('questions'));
            }
            if($compPaper->question_template_id == 4){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionAudio', compact('questions'));
            }
            if($compPaper->question_template_id == 5){
                $questions = CompetitionQuestions::where('competition_paper_id', $id)->get();
                return view('account.competitionAudio', compact('questions'));
            }
        }else{
            return abort(404);
        }

    }
}
