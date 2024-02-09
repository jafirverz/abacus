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

class WorksheetReportController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.WORKSHEET_REPORTS');
        $this->module = 'WORKSHEET_REPORTS';
        $this->middleware('grant.permission:' . $this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = 'Worksheet Report';
        $allOrders = array();
        $levels = Level::get();
        $students = User::whereIn('user_type_id', [1,2])->where('approve_status', 1)->get();
        return view('admin.cms.reports.worksheet_reports', compact('title', 'levels', 'students'));
    }

    public function searchInWorksheet(Request $request)
    {
        // dd($request->all());
        $level = $request->level  ?? '';
        $start_date = $request->start_date ?? '';
        $end_date = $request->end_date ?? '';
        $student = $request->student ?? '';


        $q = WorksheetSubmitted::query();

        if ($request->level) {
            // simple where here or another scope, whatever you like
            $q->where('level_id', $level);
        }

        if ($request->start_date) {
            // simple where here or another scope, whatever you like
            $q->where('created_at', '>=', $start_date);
        }

        if ($request->end_date) {
            $q->where('created_at', '<=', $end_date);
        }

        if ($request->student) {
            $q->where('user_id', $student);
        }

        // if ($request->instructor) {
        //     $q->whereIn('instructor_id', $instructor);
        // }

        $allOrders = $q->get();
        //$allOrders = array_unique($allOrders);
        //$allUsers = User::whereIn('id', $allOrders)->get();
        // $title = 'Sales Report';
        // $instructor = User::where('user_type_id', 5)->get();
        // $countries = Country::get();
        // return view('admin.cms.reports.sales_report', compact('title', 'instructor', 'countries', 'allOrders'));

        ob_end_clean();
        ob_start();
        return Excel::download(new WorksheetExport($allOrders), 'WorksheetReport.xlsx');
        //dd($allUsers);
    }
}
