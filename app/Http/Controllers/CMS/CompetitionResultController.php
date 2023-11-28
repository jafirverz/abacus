<?php

namespace App\Http\Controllers\CMS;

use App\Certificate;
use App\Competition;
use App\CompetitionPaper;
use App\CompetitionPaperSubmitted;
use App\CompetitionStudentResult;
use App\Exports\CompetetitionResultExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Traits\SystemSettingTrait;
use App\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CompetitionResultController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.COMPETITION_RESULT');
        $this->module = 'COMPETITION_RESULT';
        $this->middleware('grant.permission:'.$this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        //
        $title = $this->title;
        // $competition = CompetitionPaperSubmitted::where('paper_type', 'actual')->groupBy('competition_id')->orderBy('id', 'desc')->paginate($this->pagination);
        $competition = Competition::paginate(10);
        return view('admin.competition_result.index', compact('title', 'competition'));
    }

    public function studentList($id){
        $title = $this->title;
        //$userList = CompetitionPaperSubmitted::where('competition_id', $id)->paginate($this->pagination);
        $userList = CompetitionStudentResult::where('competition_id', $id)->paginate($this->pagination);
        $competitionId = $id;
        $competition = Competition::where('id', $id)->first();
        return view('admin.competition_result.userList', compact('title', 'userList', 'competitionId', 'competition'));
    }

    public function edit($id){
        $title = $this->title;
        //$competitionPaperSubmitted = CompetitionPaperSubmitted::where('id', $id)->first();
        $competitionPaperSubmitted = CompetitionStudentResult::where('id', $id)->first();
        $certificates = Certificate::get();
        return view('admin.competition_result.edit', compact('title', 'competitionPaperSubmitted', 'certificates'));

    }

    public function update(Request $request, $id){
        $result = $request->result;
        $prize = $request->prize;
        $title = $this->title;
        //$compPaperResult = CompetitionPaperSubmitted::where('id', $id)->first();
        $compPaperResult = CompetitionStudentResult::where('id', $id)->first();
        $compPaperResult->result = $result;
        $compPaperResult->prize = $prize;
        $compPaperResult->certificate_id = $request->certificate;
        $compPaperResult->save();

        // if Competition result uploaded by admin then add certificate
        // $compStuResult = CompetitionStudentResult::where('competition_id', $compPaperResult->competition_id)->where('category_id', $compPaperResult->category_id)->where('user_id', $compPaperResult->user_id)->first();
        // if($compStuResult){
        //     dd("found");
        // }else{
        //     dd("not found");
        // }
        $competition = CompetitionPaperSubmitted::where('paper_type', 'actual')->groupBy('competition_id')->orderBy('id', 'desc')->paginate($this->pagination);
        return view('admin.competition_result.index', compact('title', 'competition'));

    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        // $checkCompetition = Competition::where('title', 'like', '%'.$search_term.'%')->pluck('id')->toArray();
        // $competition = CompetitionPaperSubmitted::where('paper_type', 'actual')->groupBy('competition_id')->orderBy('id', 'desc')->whereIn('competition_id', $checkCompetition)->paginate($this->pagination);
        // if ($search_term) {
        //     $competition->appends('search', $search_term);
        // }

        // $competitionPaper = CompetitionPaper::whereHas('comp_ques')->paginate($this->pagination);
        $competition = Competition::where('title', 'like', '%'.$search_term.'%')->paginate($this->pagination);
        return view('admin.competition_result.index', compact('title', 'competition'));
    }

    public function excelDownload(Request $request, $id){
        $allItems = CompetitionPaperSubmitted::where('paper_type', 'actual')->where('competition_id', $request->competitionId)->orderBy('competition_id', 'desc')->orderBy('user_id', 'asc')->get();
        ob_end_clean();
        ob_start();
        return Excel::download(new CompetetitionResultExport($allItems), 'CompetitionStudentReport.xlsx');
    }

    public function userresultsearch(Request $request)
    {
        //dd($request->all());
        $search_term = $request->search;
        $title = $this->title;
        $users = User::where('name', 'like', '%'.$search_term.'%')->pluck('id')->toArray();
        // $competitionPaper = CompetitionPaper::whereHas('comp_ques')->paginate($this->pagination);
        $userList = CompetitionStudentResult::where('competition_id', $request->competitionId)->whereIn('user_id', $users)->paginate($this->pagination);
        $competitionId = $request->competitionId;
        $competition = Competition::where('id', $request->competitionId)->first();
        return view('admin.competition_result.userList', compact('title', 'userList', 'competitionId', 'competition'));
    }
}
