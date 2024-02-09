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

class SalesReportController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.SALES_REPORTS');
        $this->module = 'SALES_REPORTS';
        $this->middleware('grant.permission:' . $this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = 'Sales Report';
        $allOrders = array();
        //$pages = Page::orderBy('view_order', 'asc')->get();
        //$users = User::whereIn('user_type_id', [5])->paginate($this->pagination);
        $instructor = User::where('user_type_id', 5)->get();
        //$userType = UserType::whereIn('id', [1, 2, 3, 4])->get();
        //$countries = Country::get();
        $franchiseCountry = Admin::where('admin_role', 2)->pluck('country_id')->toArray();
        $countries = Country::whereIn('id', $franchiseCountry)->get();
        return view('admin.cms.reports.sales_report', compact('title', 'instructor', 'countries', 'allOrders'));
    }

    public function searchInSales(Request $request)
    {
        // dd($request->all());
        $start_date = $request->start_date  ?? '';
        $end_date = $request->end_date ?? '';
        $country = $request->country ?? '';

        $q = Order::query();

        if ($request->country) {
            // simple where here or another scope, whatever you like
            $q->where('country_id', $country);
        }

        if ($request->start_date) {
            // simple where here or another scope, whatever you like
            $q->where('created_at', '>=', $start_date);
        }

        if ($request->end_date) {
            $q->where('created_at', '<=', $end_date);
        }

        // if ($request->user_type) {
        //     $q->where('user_type_id', $request->user_type);
        // }

        // if ($request->instructor) {
        //     $q->whereIn('instructor_id', $instructor);
        // }
        $q->orderBy('id', 'desc');
        $allOrders = $q->paginate(30);
        //$allOrders = array_unique($allOrders);
        //$allUsers = User::whereIn('id', $allOrders)->get();
        $title = 'Sales Report';
        $instructor = User::where('user_type_id', 5)->get();
        //$countries = Country::get();
        $franchiseCountry = Admin::where('admin_role', 2)->pluck('country_id')->toArray();
        $countries = Country::whereIn('id', $franchiseCountry)->get();
        return view('admin.cms.reports.sales_report', compact('title', 'instructor', 'countries', 'allOrders'));

        // ob_end_clean();
        // ob_start();
        //return Excel::download(new SalesExport($allOrders), 'SalesReport.xlsx');
        //dd($allUsers);
    }

    public function searchSales(Request $request)
    {
        $start_date = $request->start_date  ?? '';
        $end_date = $request->end_date ?? '';
        $country = $request->country ?? '';
        $orderId = explode(',', $request->excel_id);
        //dd($userId);
        $q = OrderDetail::query();
        $q->whereIn('order_id', $orderId);
        // if ($request->country) {
        //     // simple where here or another scope, whatever you like
        //     $q->where('country_id', $country);
        // }

        // if ($request->start_date) {
        //     // simple where here or another scope, whatever you like
        //     $q->where('created_at', '>=', $start_date);
        // }

        // if ($request->end_date) {
        //     $q->where('created_at', '<=', $end_date);
        // }

        // if ($userId) {
        //     $q->whereIn('user_id', $userId);
        // }



        $allOrders = $q->get();
        ob_end_clean();
        ob_start();
        return Excel::download(new SalesExport($allOrders), 'SalesReport.xlsx');
        //dd($allUsers);
    }

}
