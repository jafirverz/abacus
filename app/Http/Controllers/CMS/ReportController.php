<?php

namespace App\Http\Controllers\CMS;

use App\Country;
use App\Exports\InstructorExport;
use App\Exports\SalesExport;
use App\Exports\StudentExport;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use App\User;
use App\UserType;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.REPORTS');
        $this->module = 'REPORTS';
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
        $users = User::whereIn('user_type_id', [1, 2, 3, 4])->paginate($this->pagination);
        $instructor = User::where('user_type_id', 5)->get();
        $userType = UserType::whereIn('id', [1, 2, 3, 4])->get();
        $countries = Country::get();
        return view('admin.cms.reports.student_report', compact('title', 'users', 'instructor', 'countries', 'userType'));
    }

    public function search(Request $request)
    {
        //dd($request->instructor);
        $name = $request->name  ?? '';
        $status = $request->status ?? '';
        $user_type = $request->user_type ?? '';
        $instructor = $request->instructor ?? array();
        
        $q = User::query();

        if ($request->name) {
            // simple where here or another scope, whatever you like
            $q->where('name', 'like', $request->name);
        }

        if (in_array($request->status, [0,1,2])) {
            $q->where('approve_status', $request->status);
        }

        if ($request->user_type) {
            $q->where('user_type_id', $request->user_type);
        }

        if ($request->instructor) {
            $q->whereIn('instructor_id', $instructor);
        }

        $allUsers = $q->get();
        ob_end_clean();
        ob_start();
        return Excel::download(new StudentExport($allUsers), 'StudentReport.xlsx');
        //dd($allUsers);
    }

    public function instructor()
    {
        $title = 'Instructor Report';
        //$pages = Page::orderBy('view_order', 'asc')->get();
        //$users = User::whereIn('user_type_id', [5])->paginate($this->pagination);
        $instructor = User::where('user_type_id', 5)->get();
        //$userType = UserType::whereIn('id', [1, 2, 3, 4])->get();
        $countries = Country::get();
        return view('admin.cms.reports.instructor_report', compact('title', 'instructor', 'countries'));
    }

    public function searchInstructor(Request $request)
    {
        // dd($request->all());
        $name = $request->name  ?? '';
        $status = $request->status ?? '';

        $q = User::query();
        $q->where('user_type_id', 5);
        if ($request->name) {
            // simple where here or another scope, whatever you like
            $q->where('name', 'like', $request->name);
        }

        if (in_array($request->status, [0,1,2])) {
            $q->where('approve_status', $request->status);
        }


        $allUsers = $q->get();
        ob_end_clean();
        ob_start();
        return Excel::download(new InstructorExport($allUsers), 'InstructorReport.xlsx');
        //dd($allUsers);
    }


    public function sales()
    {
        $title = 'Sales Report';
        //$pages = Page::orderBy('view_order', 'asc')->get();
        //$users = User::whereIn('user_type_id', [5])->paginate($this->pagination);
        $instructor = User::where('user_type_id', 5)->get();
        //$userType = UserType::whereIn('id', [1, 2, 3, 4])->get();
        $countries = Country::get();
        return view('admin.cms.reports.sales_report', compact('title', 'instructor', 'countries'));
    }


    public function searchSales(Request $request)
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

        $allOrders = $q->pluck('user_id')->toArray();
        ob_end_clean();
        ob_start();
        return Excel::download(new SalesExport($allOrders), 'SalesReport.xlsx');
        //dd($allUsers);
    }
}
