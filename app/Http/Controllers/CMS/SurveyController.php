<?php

namespace App\Http\Controllers\CMS;

use App\Survey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Level;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.SURVEY');
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
        $title = $this->title;
        $surveys = Survey::orderBy('id','desc')->paginate($this->pagination);

        return view('admin.survey.index', compact('title', 'surveys'));
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
    public function show(Survey $survey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = $this->title;
        $surveys = Survey::find($id);

        return view('admin.survey.edit', compact('title', 'surveys'));
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
        //
        $fields = [
            'title' => 'required',

        ];
        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $request->validate($fields, $messages);

        $survey = Survey::find($id);
        $survey->title = $request->title;
        $survey->description = $request->description;
        $survey->status = $request->status;
        $survey->save();

        return redirect()->route('surveys.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        //
    }
}
