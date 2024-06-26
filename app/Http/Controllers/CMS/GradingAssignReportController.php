<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GradingStudentResults;
use App\CategoryGrading;
use App\GradingExam;
use App\GradingCategory;
use App\Exports\GradingResultExport;
use App\Imports\ImportGradingResult;
use App\GradingSubmitted;
use App\GradingStudent;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use Excel;

class GradingAssignReportController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.GRADING_ASSIGN');
        $this->module = 'GRADING_ASSIGN';
        $this->middleware('grant.permission:'.$this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(){
        $title = 'Grading Assign';
        $competition = GradingExam::orderBy('id','desc')->paginate($this->pagination);

        return view('admin.grading_result.assign', compact('title', 'competition'));
    }

    public function edit($id = null){
        $title = 'Grading Assign';
        $competition = GradingExam::where('id', $id)->first();
        $competitionCategory = GradingCategory::join('category_gradings','grading_categories.id','category_gradings.category_id')->where('category_gradings.competition_id', $id)->get();
        $mental_grades = CategoryGrading::join('grading_categories','grading_categories.id','category_gradings.category_id')->where('grading_categories.grade_type_id', 1)->where('category_gradings.competition_id', $id)->orderBy('grading_categories.category_name','asc')->select('grading_categories.*')->get();
        $abacus_grades = CategoryGrading::join('grading_categories','grading_categories.id','category_gradings.category_id')->where('grading_categories.grade_type_id', 2)->where('category_gradings.competition_id', $id)->orderBy('grading_categories.category_name','asc')->select('grading_categories.*')->get();
        $userType = array(1,2,3,4);
        $compStudents = GradingStudent::where('grading_exam_id', $id)->pluck('user_id')->toArray();
        $students = User::whereIn('user_type_id', $userType)->where('approve_status', 1)->whereNotIn('id', $compStudents)->get();
        $instructors = User::whereIn('user_type_id', [5])->where('approve_status', 1)->get();
        return view('admin.grading_result.assignstudent', compact('title', 'competition', 'students', 'competitionCategory','mental_grades','abacus_grades','instructors'));

    }

    public function store(Request $request){
        //dd($request->all());
        $compId = $request->competitionId;
        $status = $request->status;
        if($status != 1){
            $status = 'null';
        }
        foreach($request->students as $student){
            //dd($student);
            $compStudent = new GradingStudent();
            $compStudent->user_id = $student;
            $compStudent->grading_exam_id  = $compId;
            $compStudent->instructor_id = $request->instructor_id??NULL;
            $compStudent->mental_grade = $request->mental_grade??NULL;
            $compStudent->abacus_grade = $request->abacus_grade??NULL;
            $compStudent->approve_status = $status;
            $compStudent->save();
        }
        return redirect()->back()->with('success',  'Assigned');
    }
}
