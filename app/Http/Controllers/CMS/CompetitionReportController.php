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
use App\CompetitionCategory;
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

class CompetitionReportController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.COMPETITION_REPORTS');
        $this->module = 'COMPETITION_REPORTS';
        $this->middleware('grant.permission:' . $this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = 'Competition Report';
        $allOrders = array();
        $instructor = User::where('user_type_id', 5)->get();
        $competitions = Competition::where('status', 1)->get();
        $compStudents = CompetitionStudent::paginate($this->pagination);
        // $countries = Country::get();
        $countries = Admin::where('admin_role', 2)->pluck('country_id')->toArray();
        $countries = Country::whereIn('id', $countries)->get();
        $learningLocation = LearningLocation::get();
        $competitoinCategory = CompetitionCategory::get();
        return view('admin.cms.reports.competition_students', compact('title', 'compStudents', 'countries', 'allOrders','instructor','competitions', 'learningLocation', 'competitoinCategory'));
    }

    public function competition_search(Request $request)
    {
        // dd($request->all());
        $title = 'Competition Report';
        $name = $request->name  ?? '';
        $status = $request->status ?? '';
        $countries = Admin::where('admin_role', 2)->pluck('country_id')->toArray();
        $countries = Country::whereIn('id', $countries)->get();
        $instructor = User::where('user_type_id', 5)->get();
        $competitions = Competition::where('status', 1)->get();
        $learningLocation = LearningLocation::get();
        $competitoinCategory = CompetitionCategory::get();
        if($request->downloadexcel == 0){
            $q = CompetitionStudent::query();
            $q->join('users','competition_students.user_id','users.id');
            $q->select('competition_students.*');

            if ($request->country) {
                $q->where('users.country_code', 'like', $request->country);
            }

            if ($request->event) {
                $q->where('competition_students.competition_controller_id', $request->event);
            }

            if ($request->category) {
                $q->where('competition_students.category_id', $request->category);
            }

            if ($request->learning_location) {
                $q->where('users.learning_locations', $request->learning_location);
            }

            if ($request->instructor) {
                $q->where('competition_students.instructor_id', $request->instructor);
            }
            $compStudents = $q->paginate($this->pagination);
            session()->flashInput($request->input());
            return view('admin.cms.reports.competition_students', compact('title', 'compStudents', 'countries', 'instructor','competitions', 'learningLocation', 'competitoinCategory'));
            //dd($allItems);

        }else{
            $q = CompetitionStudent::query();
            $q->join('users','competition_students.user_id','users.id');
            $q->select('competition_students.*');
            if ($request->country) {
                $q->where('users.country_code', 'like', $request->country);
            }

            if ($request->event) {
                $q->where('competition_students.competition_controller_id', $request->event);
            }

            if ($request->category) {
                $q->where('competition_students.category_id', $request->category);
            }

            if ($request->learning_location) {
                $q->where('users.learning_locations', $request->learning_location);
            }

            if ($request->instructor) {
                $q->where('competition_students.instructor_id', $request->instructor);
            }
            $allItems = $q->get();
            ob_end_clean();
            ob_start();
            return Excel::download(new CompetetitionStudentExport($allItems), 'CompetetitionStudentExport.xlsx');
        }



        //dd($allUsers);
    }
}
