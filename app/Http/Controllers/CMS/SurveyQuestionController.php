<?php

namespace App\Http\Controllers\CMS;

use App\SurveyQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OptionChoice;
use App\Survey;
use App\SurveyQuestionOption;
use App\SurveyQuestionOptionChoices;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;

class SurveyQuestionController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.SURVEY_QUESTIONS');
        $this->module = 'SURVEY_QUESTIONS';
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

        return view('admin.survey_question.index', compact('title', 'surveys'));
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
        $surveys = Survey::get();
        return view('admin.survey_question.create', compact('title', 'surveys'));
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
            'survey' => 'required',
            'title' => 'required',
            'question_type' => 'required',
        ];
        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $request->validate($fields, $messages);

        $survey = new SurveyQuestion();
        $survey->survey_id = $request->survey;
        $survey->title = $request->title;
        $survey->note_help = $request->note;
        $survey->type = $request->question_type;
        $survey->status = $request->status;
        $survey->save();

        return redirect()->route('survey-questions.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SurveyQuestion  $surveyQuestion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //
        $title = $this->title;
        $surveysQuestion = SurveyQuestion::find($id);
        $surveys = Survey::get();
        return view('admin.survey_question.show', compact('title', 'surveys', 'surveysQuestion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SurveyQuestion  $surveyQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = $this->title;
        $surveysQuestion = SurveyQuestion::find($id);
        $surveys = Survey::get();
        return view('admin.survey_question.edit', compact('title', 'surveys', 'surveysQuestion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SurveyQuestion  $surveyQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $fields = [
            'survey' => 'required',
            'title' => 'required',
            'question_type' => 'required',
        ];
        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $request->validate($fields, $messages);

        $survey = SurveyQuestion::find($id);
        $survey->survey_id = $request->survey;
        $survey->title = $request->title;
        $survey->note_help = $request->note;
        $survey->type = $request->question_type;
        $survey->status = $request->status;
        $survey->save();

        return redirect()->route('survey-questions.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SurveyQuestion  $surveyQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        // dd($request->all());
        $ids = explode(',', $request->multiple_delete);
        $sq = SurveyQuestion::whereIn('id', $ids)->get();
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
        foreach($sq as $deleteQ){
            $deleteQ->delete();
        }
        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        // dd($request->all());
        $search_term = $request->search;
        $title = $this->title;
        $surveys = SurveyQuestion::where('title', 'like', '%'.$search_term.'%')->orderBy('id','desc')->paginate($this->pagination);

        return view('admin.survey_question.index', compact('title', 'surveys'));
        // $topic = Topic::search($search_term)->paginate($this->pagination);
        // if ($search_term) {
        //     $topic->appends('search', $search_term);
        // }

        // return view('admin.master.topic.index', compact('title', 'topic'));
    }
}
