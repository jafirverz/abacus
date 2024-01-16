<?php

namespace App\Http\Controllers\CMS;

use App\SurveyQuestionOption;
use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\OptionChoice;
use App\SurveyQuestion;
use App\SurveyQuestionOptionChoices;

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
    public function show($id)
    {
        //
        $title = $this->title;
        $surveysQuestionOptions = SurveyQuestionOption::where('survey_question_id', $id)->get();
        $surveysQuestions = SurveyQuestion::where('id', $id)->first();
        return view('admin.survey_question_option.show', compact('title', 'surveysQuestionOptions', 'surveysQuestions'));
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
            $questionOptions = OptionChoice::where('survey_question_option_id',  $question->id)->get();
            foreach($questionOptions as $optionChoices) {
                $optionChoices->delete();
            }
            $surveyQuesOptionChoices = SurveyQuestionOptionChoices::where('survey_question_option_id', $question->id)->get();
            foreach($surveyQuesOptionChoices as $optionChoicess) {
                $optionChoicess->delete();
            }
           
            $question->delete();
        }

        $i = 0;
        $count = count($request->input_1);
        if($count > 0){
            for($i=0; $i<$count; $i++){
                $survey = new SurveyQuestionOption();
                $survey->survey_question_id = $request->survey_question_id;
                $survey->title = $request->input_1[$i];
                if(isset($request->radio_type) && sizeof($request->radio_type)>0){
                    $survey->option_type = $request->radio_type[$i];
                }
                
                $survey->save();
            }
        }
        
        

        return redirect()->route('options-survey-questions.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SurveyQuestionOption  $surveyQuestionOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $ids = explode(',', $request->multiple_delete);
        $sqp = SurveyQuestionOption::whereIn('survey_question_id', $ids)->get();
        foreach($sqp as $options){
            
            $questionOptions = OptionChoice::where('survey_question_option_id',  $options->id)->get();
            foreach($questionOptions as $optionChoices) {
                $optionChoices->delete();
            }
            $surveyQuesOptionChoices = SurveyQuestionOptionChoices::where('survey_question_option_id', $options->id)->get();
            foreach($surveyQuesOptionChoices as $optionChoicess) {
                $optionChoicess->delete();
            }
            $options->delete();
        }
        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        // dd($request->all());
        $search_term = $request->search;
        $title = $this->title;
        $surveys = SurveyQuestion::where('title', 'like', '%'.$search_term.'%')->orderBy('id','desc')->paginate($this->pagination);


        return view('admin.survey_question_option.index', compact('title', 'surveys'));
        // $topic = Topic::search($search_term)->paginate($this->pagination);
        // if ($search_term) {
        //     $topic->appends('search', $search_term);
        // }

        // return view('admin.master.topic.index', compact('title', 'topic'));
    }

    
}
