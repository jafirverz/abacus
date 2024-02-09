<?php

namespace App\Http\Controllers\CMS;

use App\Admin;
use App\Country;
use App\Exports\InstructorExport;
use App\Exports\SalesExport;
use App\Exports\StudentExport;
use App\Exports\WorksheetExport;
use App\Exports\GradingStudentExport;
use App\Exports\CompetetitionStudentExport;
use App\Http\Controllers\Controller;
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
use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use App\User;
use App\UserType;
use App\WorksheetSubmitted;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class ReportController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.STUDENT_REPORTS');
        $this->module = 'STUDENT_REPORTS';
        $this->middleware('grant.permission:' . $this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = 'Student Report';
        //$pages = Page::orderBy('view_order', 'asc')->get();
        if(Auth::user()->admin_role == 1){
            $users = User::whereIn('user_type_id', [1, 2, 3, 4])->paginate($this->pagination);
            $instructor = User::where('user_type_id', 5)->orderBy('name', 'asc')->get();
        }else{
            $users = User::where('country_code', Auth::user()->country_id)->whereIn('user_type_id', [1, 2, 3, 4])->paginate($this->pagination);
            $instructor = User::where('country_code', Auth::user()->country_id)->where('user_type_id', 5)->orderBy('name', 'asc')->get();
        }
        
        
        $userType = UserType::whereIn('id', [1, 2, 3, 4])->get();
        $countries = Country::get();
        return view('admin.cms.reports.student_report', compact('title', 'users', 'instructor', 'countries', 'userType'));
    }

    public function search(Request $request)
    {
        // dd($request->all());
        $title = 'Student Report';
        DB::enableQueryLog();
        $instructor = $request->instructor ?? array();
        $q = User::query();
        if(Auth::user()->admin_role == 1){
        }else{
            $q->where('country_code', Auth::user()->country_id);
        }
        if($request->downloadexcel == 1){
            if ($request->status!='' && in_array($request->status, [0,1,2])) {
                $q->where('approve_status', $request->status);
            }

            if ($request->user_type) {
                $q->where('user_type_id', $request->user_type);
            }

            if ($request->instructor) {
                $q->whereIn('instructor_id', $instructor);
            }

            $allUsers = $q->get();
            //$query = DB::getQueryLog();
            //dd($query);
            ob_end_clean();
            ob_start();
            return Excel::download(new StudentExport($allUsers), 'StudentReport.xlsx');
        }else{
            // dd($request->all());
            if ($request->status!='' && in_array($request->status, [0,1,2])) {
                $q->where('approve_status', $request->status);
            }

            if ($request->user_type) {
                $q->where('user_type_id', $request->user_type);
            }

            if ($request->instructor) {
                $q->whereIn('instructor_id', $instructor);
            }

            $users = $q->paginate($this->pagination);
            // $users = User::whereIn('user_type_id', [1, 2, 3, 4])->paginate($this->pagination);
            if(Auth::user()->admin_role == 1){
                $instructor = User::where('user_type_id', 5)->orderBy('name', 'asc')->get();
            }else{
                $instructor = User::where('country_code', Auth::user()->country_id)->where('user_type_id', 5)->orderBy('name', 'asc')->get();
            }
            // $instructor = User::where('user_type_id', 5)->orderBy('name', 'asc')->get();
            $userType = UserType::whereIn('id', [1, 2, 3, 4])->get();
            // $countries = Country::get();
            return view('admin.cms.reports.student_report', compact('title', 'users', 'instructor', 'userType'));
        }
        //dd($allUsers);
    }  




    // public function searchWorksheet(Request $request)
    // {
    //     $start_date = $request->start_date  ?? '';
    //     $end_date = $request->end_date ?? '';
    //     $country = $request->country ?? '';
    //     $orderId = explode(',', $request->excel_id);
    //     //dd($userId);
    //     $q = OrderDetail::query();
    //     $q->whereIn('order_id', $orderId);
    //     // if ($request->country) {
    //     //     // simple where here or another scope, whatever you like
    //     //     $q->where('country_id', $country);
    //     // }

    //     // if ($request->start_date) {
    //     //     // simple where here or another scope, whatever you like
    //     //     $q->where('created_at', '>=', $start_date);
    //     // }

    //     // if ($request->end_date) {
    //     //     $q->where('created_at', '<=', $end_date);
    //     // }

    //     // if ($userId) {
    //     //     $q->whereIn('user_id', $userId);
    //     // }



    //     $allOrders = $q->get();
    //     ob_end_clean();
    //     ob_start();
    //     return Excel::download(new SalesExport($allOrders), 'SalesReport.xlsx');
    //     //dd($allUsers);
    // }
}
