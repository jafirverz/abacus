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

class OnlineStudentReportController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.ONLINESTUDENT_REPORTS');
        $this->module = 'ONLINESTUDENT_REPORTS';
        $this->middleware('grant.permission:' . $this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = 'Online Student Report';
        $allOrders = array();
        //$pages = Page::orderBy('view_order', 'asc')->get();
        //$users = User::whereIn('user_type_id', [5])->paginate($this->pagination);
        // $instructor = User::where('user_type_id', 5)->get();
        //$userType = UserType::whereIn('id', [1, 2, 3, 4])->get();
        //$countries = Country::get();
        // $franchiseCountry = Admin::where('admin_role', 2)->pluck('country_id')->toArray();
        // $countries = Country::whereIn('id', $franchiseCountry)->get();
        if(Auth::user()->admin_role == 1){
            $users = User::where('user_type_id', 3)->get();
        }else{
            $users = User::where('country_code', Auth::user()->country_id)->where('user_type_id', 3)->get();
        }
        
        return view('admin.cms.reports.onlinestudent', compact('title', 'users'));
    }

    public function searchOnline(Request $request)
    {
        // dd($request->all());
        $status = $request->status  ?? '';
        $student = $request->student ?? '';

        // $q = User::query();
        if($request->downloadexcel == 0 && !empty($student)){
            $q = CourseAssignToUser::query();
            $q->join('courses','course_assign_to_users.course_id','courses.id');
            $q->select('course_assign_to_users.*');
            if ($request->student) {
                // simple where here or another scope, whatever you like
                $q->where('course_assign_to_users.user_id', $student);
            }
            $allOrders = $q->get();
            $title = 'Online Student Report';
            $users = User::where('user_type_id', 3)->get();

            return view('admin.cms.reports.onlinestudent', compact('title', 'users', 'allOrders'));
        }elseif($request->downloadexcel == 1){
            $q = CourseAssignToUser::query();
            $q->join('courses','course_assign_to_users.course_id','courses.id');
            $q->select('course_assign_to_users.*');
            if ($request->student) {
                // simple where here or another scope, whatever you like
                $q->where('course_assign_to_users.user_id', $student);
            }
            $allItems = $q->get();
            ob_end_clean();
            ob_start();
            return Excel::download(new OnlineStudentExport($allItems), 'OnlineStudentExport.xlsx');
        }else{
            $title = 'Online Student Report';
            $allOrders = array();
            $users = User::where('user_type_id', 3)->get();
            return view('admin.cms.reports.onlinestudent', compact('title', 'users'));
        }





        // ob_end_clean();
        // ob_start();
        //return Excel::download(new SalesExport($allOrders), 'SalesReport.xlsx');
        //dd($allUsers);
    }
}
