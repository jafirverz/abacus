<?php

namespace App\Http\Controllers\CMS;

use App\SurveyQuestionOption;
use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\SurveyQuestion;

class SurveyQuestionOptionController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.SURVEY_QUESTIONS_OPTIONS');
        $this->module = 'SURVEY_QUESTIONS_OPTIONS';
        $this->middleware('grant.permission:' . $this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = $this->title;
        $surveys = SurveyQuestion::orderBy('id','desc')->paginate($this->pagination);

        return view('admin.survey_question_option.index', compact('title', 'surveys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = $this->title;
        $surveysQuestions = SurveyQuestion::get();
        return view('admin.survey_question_option.create', compact('title', 'surveysQuestions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $fields = [
            'survey_question' => 'required',
        ];
        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $request->validate($fields, $messages);
        $i = 0;
        $count = count($request->input_1);
            for($i=0; $i<$count; $i++){
            $survey = new SurveyQuestionOption();
            $survey->survey_question_id = $request->survey_question_id;
            $survey->title = $request->input_1[$i];
            if(isset($request->radio_type) && sizeof($request->radio_type)>0){
                $survey->option_type = $request->radio_type[$i];
            }
            
            $survey->save();
        }
        

        return redirect()->route('options-survey-questions.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SurveyQuestionOption  $surveyQuestionOption
     * @return \Illuminate\Http\Response
     */
    public function show(SurveyQuestionOption $surveyQuestionOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SurveyQuestionOption  $surveyQuestionOption
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = $this->title;
        $surveysQuestionOptions = SurveyQuestionOption::where('survey_question_id', $id)->get();
        $surveysQuestions = SurveyQuestion::where('id', $id)->first();
        return view('admin.survey_question_option.edit', compact('title', 'surveysQuestionOptions', 'surveysQuestions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SurveyQuestionOption  $surveyQuestionOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SurveyQuestionOption $surveyQuestionOption)
    {
        //
        $fields = [
            'survey_question' => 'required',
        ];
        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $request->validate($fields, $messages);
        $survey_question_id = $request->survey_question_id;
        $questionOptions = SurveyQuestionOption::where('survey_question_id', $survey_question_id)->get();
        foreach($questionOptions as $question){
            $question->delete();
        }

        $i = 0;
        $count = count($request->input_1);
            for($i=0; $i<$count; $i++){
            $survey = new SurveyQuestionOption();
            $survey->survey_question_id = $request->survey_question_id;
            $survey->title = $request->input_1[$i];
            if(isset($request->radio_type) && sizeof($request->radio_type)>0){
                $survey->option_type = $request->radio_type[$i];
            }
            
            $survey->save();
        }
        

        return redirect()->route('options-survey-questions.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SurveyQuestionOption  $surveyQuestionOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(SurveyQuestionOption $surveyQuestionOption)
    {
        //
    }
}
