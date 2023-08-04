<?php

namespace App\Http\Controllers\CMS;

use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use App\User;
use App\UserType;
use Illuminate\Support\Facades\Auth;

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

    public function index(){
        $title = 'Student Report';
        //$pages = Page::orderBy('view_order', 'asc')->get();
        $users = User::whereIn('user_type_id', [1,2,3,4])->paginate($this->pagination);
        $instructor = User::where('user_type_id', 5)->get();
        $userType = UserType::whereIn('id', [1,2,3,4])->get();
        $countries = Country::get();
        return view('admin.cms.reports.student_report', compact('title', 'users', 'instructor', 'countries', 'userType'));
    }

    public function search(Request $request){
        //dd($request->instructor);
        $name = $request->name;
        $status = $request->status;
        $user_type = $request->user_type;
        $instructor = $request->instructor;
        $allUsers = User::where(function ($query) use ($name) {
		    // $query->where('vehicle_main_id', $carId);
		    $query->where('name', 'like', '%' .  $name . '%');
		})->where(function ($query) use ($status) {
		    $query->where('approve_status', $status);
        })->where(function ($query) use ($user_type) {
            $query->where('user_type_id', $user_type);
        })->where(function ($query) use ($instructor) {
            $query->whereIn('instructor_id', $instructor);
        })->get();
        dd($allUsers);
    }
}
