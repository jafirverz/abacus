<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CategoryCompetition;
use App\Competition;
use App\CompetitionCategory;
use App\CompetitionResultUpload;
use App\CompetitionStudent;
use App\Exports\CompetetitionStudentList;
use App\Imports\ImportCompetitionResult;
use App\Imports\TempImportCompetitionResult;
use App\Traits\SystemSettingTrait;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Excel;

class CompetitionAssignController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.COMPETITION_ASSIGN');
        $this->module = 'COMPETITION_ASSIGN';
        $this->middleware('grant.permission:'.$this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(){
        $title = 'Assign Competition';
        $competition = Competition::paginate($this->pagination);
        
        return view('admin.competition.assign', compact('title', 'competition'));
    }

    public function edit($id = null){
        $title = 'Assign Competition';
        $competition = Competition::where('id', $id)->first();
        $competitionCategory = CompetitionCategory::get();
        $userType = array(1,2,3,4);
        $compStudents = CompetitionStudent::where('competition_controller_id', $id)->pluck('user_id')->toArray();
        $students = User::whereIn('user_type_id', $userType)->where('approve_status', 1)->whereNotIn('id', $compStudents)->get();
        // $worksheets = Worksheet::orderBy('id','desc')->get();
        return view('admin.competition.assignstudent', compact('title', 'competition', 'students', 'competitionCategory'));
        
    }

    public function store(Request $request){
        //dd($request->all());
        $compId = $request->competitionId;
        $category = $request->category;
        $status = $request->status;
        if($status != 1){
            $status = 'null';
        }
        foreach($request->students as $student){
            $user = User::where('id', $student)->first();
            $compStudent = new CompetitionStudent();
            $compStudent->user_id = $student;
            $compStudent->instructor_id = $user->instructor_id;
            $compStudent->competition_controller_id = $compId;
            $compStudent->category_id = $category;
            $compStudent->approve_status = $status;
            $compStudent->save();
        }
        return redirect()->back()->with('success',  'Assigned');
    }
}
