<?php

namespace App\Http\Controllers\CMS;

use App\OptionChoice;
use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\SurveyQuestionOption;
use App\SurveyQuestionOptionChoices;

class OptionChoiceController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.OPTIONS_CHOICES');
        //$this->module = 'OPTIONS_CHOICES';
        $this->module = 'SURVEY';
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
        //
        $title = $this->title;
        $choices = OptionChoice::orderBy('id','desc')->paginate($this->pagination);
        $surveysQuestionsOptions = SurveyQuestionOption::where('option_type', '!=', null)->paginate($this->pagination);
        return view('admin.option_choice.index', compact('title', 'choices', 'surveysQuestionsOptions'));
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
        $surveysQuestionsOptions = SurveyQuestionOption::where('option_type', '!=', null)->get();
        return view('admin.option_choice.create', compact('title', 'surveysQuestionsOptions'));
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
        //dd($request->all());
        $fields = [
            'question_option' => 'required',
        ];
        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $request->validate($fields, $messages);
        $i = 0;
        $count = count($request->input_1);
        for($i=0; $i<$count; $i++){
            $choices = new OptionChoice();
            $choices->survey_question_option_id = $request->question_option_id;
            $choices->title = $request->input_1[$i];
            $choices->save();
        }

        $j = 0;
        if(isset($request->options)){
            $count = count($request->options);
            for($j=0; $j<$count; $j++){
                $choices = new SurveyQuestionOptionChoices();
                $choices->survey_question_option_id = $request->question_option_id;
                $choices->title = $request->options[$j];
                $choices->save();
            }
        }
        
        

        return redirect()->route('option-choices.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OptionChoice  $optionChoice
     * @return \Illuminate\Http\Response
     */
    public function show(OptionChoice $optionChoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OptionChoice  $optionChoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = $this->title;
        $optionChoices = OptionChoice::where('survey_question_option_id', $id)->get();
        $surveysQuestions = SurveyQuestionOption::where('id', $id)->first();
        $surveyQuestionOptionChoices = SurveyQuestionOptionChoices::where('survey_question_option_id', $id)->get();
        return view('admin.option_choice.edit', compact('title', 'optionChoices', 'surveysQuestions', 'surveyQuestionOptionChoices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OptionChoice  $optionChoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // $fields = [
        //     'question_option' => 'required',
        // ];
        // $messages = [];
        // $messages['title.required'] = 'The title field is required.';
        // $request->validate($fields, $messages);
        $i = 0;
        // dd($request->options);
        if(isset($request->input_1)){
            $count = count($request->input_1);
            if($count > 0){
                $optionChoices = OptionChoice::where('survey_question_option_id', $id)->get();
                foreach($optionChoices as $choicc){
                    $choicc->delete();
                }
            }
            for($i=0; $i<$count; $i++){
                $choices = new OptionChoice();
                $choices->survey_question_option_id = $request->question_option_id;
                $choices->title = $request->input_1[$i];
                $choices->save();
            }
        }else{
            $optionChoices = OptionChoice::where('survey_question_option_id', $id)->get();
                foreach($optionChoices as $choicc){
                    $choicc->delete();
                }
        }
        

        $j = 0;
        
        if(isset($request->options)) {
            $count = count($request->options);
                if($count > 0){
                    $optionChoices = SurveyQuestionOptionChoices::where('survey_question_option_id', $id)->get();
                    foreach($optionChoices as $choicc){
                        $choicc->delete();
                    }
                }
                for($j=0; $j<$count; $j++){
                    $choices = new SurveyQuestionOptionChoices();
                    $choices->survey_question_option_id = $request->question_option_id;
                    $choices->title = $request->options[$j];
                    $choices->save();
                }
        }else{
            $optionChoices = SurveyQuestionOptionChoices::where('survey_question_option_id', $id)->get();
                    foreach($optionChoices as $choicc){
                        $choicc->delete();
                    }
        }
        
        

        return redirect()->route('option-choices.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OptionChoice  $optionChoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(OptionChoice $optionChoice)
    {
        //
    }
}
