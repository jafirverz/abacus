<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use App\Country;
use App\Exports\InstructorExport;
use App\Exports\SalesExport;
use App\Exports\StudentExport;
use App\Exports\WorksheetExport;
use App\Exports\GradingStudentExport;
use App\Exports\CompetetitionStudentExport;
use App\Level;
use App\GradingStudentResults;
use App\LearningLocation;
use App\Grade;
use App\Competition;
use App\GradingExam;
use App\CompetitionStudent;
use App\CourseAssignToUser;
use App\Exports\OnlineStudentExport;
use App\GradingStudent;
use App\Order;
use App\OrderDetail;
use App\Traits\SystemSettingTrait;
use App\User;
use App\UserType;
use App\WorksheetSubmitted;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class GradingExamReportController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.GRADING_EXAMINATION_REPORTS');
        $this->module = 'GRADING_EXAMINATION_REPORTS';
        $this->middleware('grant.permission:' . $this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = 'Grading Examination Report';
        $allOrders = array();
        $instructor = User::where('user_type_id', 5)->get();
        $grading_exam = GradingExam::where('status', 1)->get();
        DB::connection()->enableQueryLog();
        //$grading_students = GradingStudent::paginate($this->pagination);
        $q = GradingStudent::query();
        $q->join('users','grading_students.user_id','users.id');
        $q->select('grading_students.*','users.learning_locations','users.name','users.country_code','users.instructor_id','users.user_type_id');
        if (isset($_GET['name']) && $_GET['name']!='') {
            $q->where('users.name', 'like', '%'.$_GET['name'].'%');
        }

        if (isset($_GET['country']) && $_GET['country']!='') {
            $q->where('users.country_code', $_GET['country']);
        }

        if (isset($_GET['event_name']) && $_GET['event_name']!='') {
            $q->where('grading_students.grading_exam_id', $_GET['event_name']);
        }

        if (isset($_GET['learning_Location']) && $_GET['learning_Location']!='') {
            $q->where('users.learning_locations', $_GET['learning_Location']);
        }

        if (isset($_GET['grades']) && $_GET['grades']!='') {
           // dd($request->grades);
            $q->where('grading_students.mental_grade', $_GET['grades'])->orWhere('grading_students.abacus_grade', $_GET['grades']);
        }

        $grading_students = $q->paginate($this->pagination);

        //$query = DB::getQueryLog();
        //dd($query);
        $countries = Country::orderBy('phonecode')->get();
        $grades = Grade::get();
        $locations = LearningLocation::get();
        return view('admin.cms.reports.grading_students', compact('title',"grades","locations","instructor","grading_exam", 'grading_students', 'countries', 'allOrders'));
    }


    public function grading_examination_search(Request $request)
    {
        DB::connection()->enableQueryLog();

        $q = GradingStudent::query();
        $q->join('users','grading_students.user_id','users.id');
        $q->select('grading_students.*','users.learning_locations','users.name','users.country_code','users.instructor_id','users.user_type_id');
        if ($request->name) {
            $q->where('users.name', 'like', '%'.$request->name.'%');
        }

        if ($request->country) {
            $q->where('users.country_code', $request->country);
        }

        if ($request->learning_Location) {
            $q->where('users.learning_locations', $request->learning_Location);
        }

        if ($request->grades) {
           // dd($request->grades);
            $q->where('grading_students.mental_grade', $request->grades)->orWhere('grading_students.abacus_grade', $request->grades);
        }



        $allItems = $q->get();
        //$query = DB::getQueryLog();

        //dd($query);

        ob_end_clean();
        ob_start();
        return Excel::download(new GradingStudentExport($allItems), 'GradingStudentReport.xlsx');
        //dd($allUsers);
    }
}
