<?php

namespace App\Http\Controllers\CMS;

use App\SurveyQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SurveyQuestion  $surveyQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(SurveyQuestion $surveyQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SurveyQuestion  $surveyQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(SurveyQuestion $surveyQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SurveyQuestion  $surveyQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SurveyQuestion $surveyQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SurveyQuestion  $surveyQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(SurveyQuestion $surveyQuestion)
    {
        //
    }
}
