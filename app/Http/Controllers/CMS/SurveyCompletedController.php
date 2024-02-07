<?php

namespace App\Http\Controllers\CMS;

use App\Certificate;
use App\Survey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Level;
use App\Traits\SystemSettingTrait;
use App\User;
use App\UserSurvey;
use Illuminate\Support\Facades\Auth;

class SurveyCompletedController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.SURVEY_COMPLETED');
        $this->module = 'SURVEY_COMPLETED';
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
        $title = 'Survey Completed';
        $surveys = UserSurvey::orderBy('id','desc')->paginate($this->pagination);

        return view('admin.survey.survey_completed', compact('title', 'surveys'));
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
        $levels = Level::get();
        return view('admin.survey.create', compact('title', 'levels'));
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
            'title' => 'required',

        ];
        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $request->validate($fields, $messages);

        $survey = new Survey();
        $survey->title = $request->title;
        $survey->description = $request->description;
        $survey->status = $request->status;
        $survey->save();

        return redirect()->route('surveys.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $title = 'Survey Details View';
        $survey = UserSurvey::where('id', $id)->first();
        $data = json_decode($survey->survey_data);
        return view('admin.survey.survey_show', compact('title', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Survey Edit';
        $survey = UserSurvey::where('id', $id)->first();
        $data = json_decode($survey->survey_data);
        $certificate = Certificate::get();
        return view('admin.survey.survey_edit', compact('title', 'data', 'survey', 'certificate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $certificateId = $request->certificate;
        $userSurvey = UserSurvey::where('id', $id)->first();
        $userSurvey->certificate_id = $certificateId;
        $userSurvey->save();
        return redirect()->route('survey-completed.getlist')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //dd($request->all());
        $ids = explode(',',$request->multiple_delete );
        $surveyUser = UserSurvey::whereIn('id', $ids)->get();
        foreach($surveyUser as $val){
            $val->delete();
        }
        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
        //
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        //DB::enableQueryLog();
        $title = 'Survey Completed';
        $users = User::where('name', 'like', '%'.$search_term.'%')->pluck('id')->toArray();
        $surveys = UserSurvey::whereIn('user_id', $users)->orderBy('id','desc')->paginate($this->pagination);
        
       // dd(DB::getQueryLog());
       return view('admin.survey.survey_completed', compact('title', 'surveys'));
    }
}
