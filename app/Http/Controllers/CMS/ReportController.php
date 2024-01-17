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
        $instructor = User::where('user_type_id', 5)->orderBy('name', 'asc')->get();
        $userType = UserType::whereIn('id', [1, 2, 3, 4])->get();
        $countries = Country::get();
        return view('admin.cms.reports.student_report', compact('title', 'users', 'instructor', 'countries', 'userType'));
    }

    public function search(Request $request)
    {
        // dd($request->all());
        //dd($request->instructor);
        $title = 'Student Report';
        DB::enableQueryLog();
        $instructor = $request->instructor ?? array();
        $q = User::query();
        if($request->downloadexcel == 1){
            

            // if ($request->name) {
            //     // simple where here or another scope, whatever you like
            //     $q->where('name', 'like', $request->name);
            // }

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
            $instructor = User::where('user_type_id', 5)->orderBy('name', 'asc')->get();
            $userType = UserType::whereIn('id', [1, 2, 3, 4])->get();
            // $countries = Country::get();
            return view('admin.cms.reports.student_report', compact('title', 'users', 'instructor', 'userType'));
        }
        //dd($allUsers);
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

    public function instructor()
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


    public function sales()
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

    public function onlineStudent()
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
        $users = User::where('user_type_id', 3)->get();
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

    public function external_centre()
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

    public function grading_examination()
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

    public function competition()
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
        return view('admin.cms.reports.competition_students', compact('title', 'compStudents', 'countries', 'allOrders','instructor','competitions', 'learningLocation'));
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

            if ($request->learning_location) {
                $q->where('users.learning_locations', $request->learning_location);
            }

            if ($request->instructor) {
                $q->where('competition_students.instructor_id', $request->instructor);
            }
            $compStudents = $q->paginate($this->pagination);
            session()->flashInput($request->input());
            return view('admin.cms.reports.competition_students', compact('title', 'compStudents', 'countries', 'instructor','competitions', 'learningLocation'));
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


    public function worksheet()
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
