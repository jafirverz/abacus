<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\CompetitionStudentResult;
use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;

class CompetitionStudentResultController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = 'Competition Result';
        $this->module = 'Competition Result';
        //$this->middleware('grant.permission:'.$this->module);
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
     * @param  \App\CompetitionStudentResult  $competitionStudentResult
     * @return \Illuminate\Http\Response
     */
    public function show(CompetitionStudentResult $competitionStudentResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CompetitionStudentResult  $competitionStudentResult
     * @return \Illuminate\Http\Response
     */
    public function edit(CompetitionStudentResult $competitionStudentResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompetitionStudentResult  $competitionStudentResult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompetitionStudentResult $competitionStudentResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CompetitionStudentResult  $competitionStudentResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompetitionStudentResult $competitionStudentResult)
    {
        //
    }
}
