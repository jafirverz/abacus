<?php

namespace App\Http\Controllers\CMS;

use App\GradingStudentResults;
use App\GradingExam;
use App\GradingCategory;
use App\Exports\GradingResultExport;
use App\Imports\ImportGradingResult;
use App\GradingSubmitted;
use App\GradingStudent;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use Excel;

class GradingResultController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.GRADING_RESULT');
        $this->module = 'GRADING_RESULT';
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
        // $competition = GradingSubmitted::where('paper_type', 'actual')->groupBy('competition_id')->orderBy('id', 'desc')->paginate($this->pagination);
        $competition = GradingExam::orderBy('id','desc')->paginate(10);
        return view('admin.grading_result.index', compact('title', 'competition'));
    }

    public function studentList($id){
        $title = $this->title;
        //$userList = GradingSubmitted::where('competition_id', $id)->paginate($this->pagination);
        $userList = GradingStudentResults::where('grading_id', $id)->paginate($this->pagination);
        $competitionId = $id;
        $competition = GradingExam::where('id', $id)->first();
        return view('admin.grading_result.userList', compact('title', 'userList', 'competitionId', 'competition'));
    }

    public function edit($id){
        $title = $this->title;
        //$competitionPaperSubmitted = GradingSubmitted::where('id', $id)->first();
        $competitionPaperSubmitted = GradingStudentResults::where('id', $id)->first();
        $certificates = Certificate::get();
        return view('admin.grading_result.edit', compact('title', 'competitionPaperSubmitted', 'certificates'));

    }

    public function update(Request $request, $id){
        $result = $request->result;
        $prize = $request->prize;
        $title = $this->title;
        //$compPaperResult = GradingSubmitted::where('id', $id)->first();
        $compPaperResult = GradingStudentResults::where('id', $id)->first();
        $compPaperResult->result = $result;
        $compPaperResult->prize = $prize;
        $compPaperResult->certificate_id = $request->certificate;
        $compPaperResult->save();


        $competition = GradingSubmitted::where('paper_type', 'actual')->groupBy('competition_id')->orderBy('id', 'desc')->paginate($this->pagination);
        return view('admin.grading_result.index', compact('title', 'competition'));

    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        $competition = GradingExam::where('title', 'like', '%'.$search_term.'%')->paginate($this->pagination);
        return view('admin.grading_result.index', compact('title', 'competition'));
    }

    public function excelDownload(Request $request, $id){
        $allItems = GradingSubmitted::where('paper_type', 'actual')->where('grading_exam_id', $request->competitionId)->orderBy('grading_exam_id', 'desc')->orderBy('user_id', 'asc')->get();
        ob_end_clean();
        ob_start();
        return Excel::download(new GradingResultExport($allItems), 'GradingStudentReport.xlsx');
    }

    public function userresultsearch(Request $request)
    {
        //dd($request->all());
        $search_term = $request->search;
        $title = $this->title;
        $users = User::where('name', 'like', '%'.$search_term.'%')->pluck('id')->toArray();
        $userList = GradingStudentResults::where('grading_id', $request->competitionId)->whereIn('user_id', $users)->paginate($this->pagination);
        $competitionId = $request->competitionId;
        $competition = GradingExam::where('id', $request->competitionId)->first();
        return view('admin.grading_result.userList', compact('title', 'userList', 'competitionId', 'competition'));
    }

}
