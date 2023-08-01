<?php

namespace App\Http\Controllers\CMS;

use App\CompetitionResultUpload;
use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CompetitionResultUploadController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.COMPETITION_RESULT_UPLOAD');
        $this->module = 'COMPETITION_RESULT_UPLOAD';
        $this->middleware('grant.permission:'.$this->module);
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
     * @param  \App\CompetitionResultUpload  $competitionResultUpload
     * @return \Illuminate\Http\Response
     */
    public function show(CompetitionResultUpload $competitionResultUpload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CompetitionResultUpload  $competitionResultUpload
     * @return \Illuminate\Http\Response
     */
    public function edit(CompetitionResultUpload $competitionResultUpload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompetitionResultUpload  $competitionResultUpload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompetitionResultUpload $competitionResultUpload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CompetitionResultUpload  $competitionResultUpload
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompetitionResultUpload $competitionResultUpload)
    {
        //
    }
}
