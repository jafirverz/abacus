<?php

namespace App\Http\Controllers;

use App\Survey;
use App\SurveyQuestion;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    //
    public function index(){
        $surveys = Survey::where('status', 1)->first();
        if($surveys){
            $surveyQuestions = SurveyQuestion::where('survey_id', $surveys->id)->get();
        }else{
            $surveyQuestions = '';
        }
        return view('account.surveyForm', compact('surveyQuestions'));
    }
}
