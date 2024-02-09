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

class ExternalCenterReportController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.EXTERNAL_CENTRE_REPORT');
        $this->module = 'EXTERNAL_CENTRE_REPORT';
        $this->middleware('grant.permission:' . $this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = 'External Centre Report';
        $allOrders = array();
        //$pages = Page::orderBy('view_order', 'asc')->get();
        //$users = User::whereIn('user_type_id', [5])->paginate($this->pagination);
        $external_centre = User::where('user_type_id', 6)->paginate($this->pagination);
        //$userType = UserType::whereIn('id', [1, 2, 3, 4])->get();
        $countries = Country::get();
        return view('admin.cms.reports.external_centre_report', compact('title', 'external_centre', 'countries', 'allOrders'));
    }

    public function search_external_centre(Request $request)
    {
        DB::enableQueryLog();

        $q = User::query();



        if ($request->status!="" && in_array($request->status, [0,1,2])) {
            $q->where('approve_status', $request->status);
        }

        $q->whereIn('user_type_id',  [4]);


        $q->where('instructor_id',  $request->user_id);






        $allUsers = $q->get();
        //$query = DB::getQueryLog();
        //dd($query);
        ob_end_clean();
        ob_start();
        return Excel::download(new StudentExport($allUsers), 'external-center.xlsx');
        //dd($allUsers);
    }

    public function external_centre_students_list($id)
    {
        $title = 'Student List';
        $external_center=User::find($id);
       // $users = User::whereIn('user_type_id', [4])->where('instructor_id',$id)->paginate($this->pagination);
        $q = User::query();



        if (isset($_GET['status']) && in_array($_GET['status'], [0,1,2])) {
            $q->where('approve_status', $_GET['status']);
        }

        $q->whereIn('user_type_id',  [4]);
        $q->where('instructor_id',  $id);




        $users = $q->paginate($this->pagination);

        $countries = Country::get();

        return view('admin.cms.reports.external-centre-students-list', compact('title', 'users', 'countries','external_center'));
    }
}
