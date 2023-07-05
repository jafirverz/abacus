<?php

namespace App\Http\Controllers;

use App\Survey;
use App\SurveyQuestion;
use App\UserSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('account.surveyForm', compact('surveyQuestions', 'surveys'));
    }

    public function store(Request $request){
        $surveyId = $request->surveyId;
        $userId = Auth::user()->id;
        $surveyData = json_encode($request->all());
        $user_survey = new UserSurvey();
        $user_survey->survey_id = $surveyId;
        $user_survey->user_id = $userId;
        $user_survey->survey_data = $surveyData;
        $user_survey->save();
    }
}
