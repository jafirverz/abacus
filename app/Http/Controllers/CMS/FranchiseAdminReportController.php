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

class FranchiseAdminReportController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.INSTRUCTOR_REPORTS');
        $this->module = 'INSTRUCTOR_REPORTS';
        $this->middleware('grant.permission:' . $this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = __('constant.INSTRUCTOR_REPORTS');
        //$pages = Page::orderBy('view_order', 'asc')->get();
        //$users = User::whereIn('user_type_id', [5])->paginate($this->pagination);
        $instructor = User::where('user_type_id', 5)->get();
        //$userType = UserType::whereIn('id', [1, 2, 3, 4])->get();
        $countries = Country::get();
        $franshises = Admin::where('admin_role', 2)->where('status', 1)->get();
        return view('admin.cms.reports.instructor_report', compact('title', 'instructor', 'countries', 'franshises'));
    }

    public function searchInstructor(Request $request)
    {
        // dd($request->all());
        $country_code = $request->country_code  ?? '';
        // $status = $request->status ?? '';

        $q = User::query();
        $q->where('user_type_id', 5)->where('country_code', $request->country_code);
        // if ($request->country_code) {
        //     // simple where here or another scope, whatever you like
        //     $q->where('country_code', $request->country_code);
        // }

        // if ($request->status!='' && in_array($request->status, [0,1,2])) {
        //     $q->where('approve_status', $request->status);
        // }


        $allUsers = $q->get();
        ob_end_clean();
        ob_start();
        return Excel::download(new InstructorExport($allUsers), 'InstructorReport.xlsx');
        //dd($allUsers);
    }
}
