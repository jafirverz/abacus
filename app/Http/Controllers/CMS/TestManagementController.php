<?php

namespace App\Http\Controllers\CMS;

use App\Allocation;
use App\Http\Controllers\Controller;
use App\TestManagement;
use App\User;
use App\Course;
use App\TestSubmission;
use App\TestPaper;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestManagementController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.TEST_MANAGEMENT');
        $this->module = 'TEST_MANAGEMENT';
        $this->middleware('grant.permission:'.$this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $test = TestManagement::orderBy('id', 'desc')->paginate($this->pagination);

        return view('admin.test-management.index', compact('title', 'test'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $students = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        $courses = Course::orderBy('id','desc')->get();
        $papers = TestPaper::where('paper_type', 1)->orderBy('id','desc')->get();
        $userStudent = User::whereIn('user_type_id', [1,2])->orderBy('id','desc')->get();
        return view('admin.test-management.create', compact('title','courses','papers','students', 'userStudent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'  =>  'required',
            'paper_id'  =>  'required',
            'course_id'  =>  'required',
        ]);

        $testManagement = new TestManagement;
        $testManagement->title = $request->title ?? '';
        $testManagement->paper_id = $request->paper_id ?? '';
        $testManagement->start_date = $request->start_date ?? '';
        $testManagement->end_date = $request->end_date ?? '';
        $testManagement->course_id = $request->course_id ?? '';
        //$testManagement->template = $request->template ?? '';
        $testManagement->student_id = isset($request->student_id)?json_encode($request->student_id):NULL;
        $testManagement->created_at = Carbon::now();
        $testManagement->save();

        if(isset($request->student_idd))
        {
            foreach($request->student_idd as $studentid){
                foreach($request->student_id as $teacher){
                $allocation = new Allocation();
                $allocation->student_id  = $studentid ?? NULL;
                $allocation->assigned_by  = $teacher; // Instructor
                $allocation->assigned_id  = $testManagement->id;   //Test /Survey
                $allocation->start_date  = $request->start_date ?? NULL;
                $allocation->end_date  = $request->end_date ?? NULL;
                $allocation->type  = 1;
                $allocation->save();
                }
            }
        }

        return redirect()->route('test-management.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = $this->title;
        $test = TestManagement::findorfail($id);
        $students = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        $courses = Course::orderBy('id','desc')->get();
        $papers = TestPaper::where('paper_type', 1)->orderBy('id','desc')->get();
        $userStudent = User::whereIn('user_type_id', [1,2])->orderBy('id','desc')->get();
        $allocationInsList = Allocation::where('assigned_id', $id)->where('type', 1)->pluck('assigned_by')->toArray();
        $allocationStudentList = Allocation::where('assigned_id', $id)->where('type', 1)->pluck('student_id')->toArray();
        return view('admin.test-management.show', compact('title', 'test','courses','papers','students', 'userStudent', 'allocationStudentList','allocationInsList'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->title;
        $test = TestManagement::findorfail($id);
        $students = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        $courses = Course::orderBy('id','desc')->get();
        $papers = TestPaper::where('paper_type', 1)->orderBy('id','desc')->get();
        $userStudent = User::whereIn('user_type_id', [1,2])->orderBy('id','desc')->get();
        $allocationInsList = Allocation::where('assigned_id', $id)->where('type', 1)->pluck('assigned_by')->toArray();
        $allocationStudentList = Allocation::where('assigned_id', $id)->where('type', 1)->pluck('student_id')->toArray();
        return view('admin.test-management.edit', compact('title', 'test','courses','papers','students', 'userStudent', 'allocationStudentList','allocationInsList'));
    }


    public function studentList($id)
    {
        $title = $this->title;
        $testSubmissions = TestSubmission::where('test_id', $id)->paginate($this->pagination);
        //dd($testSubmissions);
        return view('admin.test-management.test-submissions', compact('title', 'testSubmissions'));
    }

    public function studentEdit($id)
    {
        $title = $this->title;
        $test = TestSubmission::findorfail($id);
        return view('admin.test-management.studentEdit', compact('title', 'test'));
    }

    public function studentUpdate(Request $request, $id)
    {


        $testManagement = TestSubmission::findorfail($id);
        $testManagement->result = $request->result ?? '';
        $testManagement->updated_at = Carbon::now();
        $testManagement->save();

        return redirect()->route('test-management.studentlist',[$testManagement->test_id])->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'  =>  'required',
            'paper_id'  =>  'required',
            'course_id'  =>  'required',
        ]);

        $testManagement = TestManagement::findorfail($id);
        $testManagement->title = $request->title ?? '';
        $testManagement->paper_id = $request->paper_id ?? '';
        $testManagement->start_date = $request->start_date ?? '';
        $testManagement->end_date = $request->end_date ?? '';
        $testManagement->course_id = $request->course_id ?? '';
        $testManagement->student_id = isset($request->student_id)?json_encode($request->student_id):NULL;
        $testManagement->created_at = Carbon::now();
        $testManagement->save();

        $allocationStudentList = Allocation::where('assigned_id', $id)->where('type', 1)->get();
        foreach($allocationStudentList as $list){
            $list->delete();
        }

        //dd($request->student_idd);

        if(isset($request->student_idd))
        {
            foreach($request->student_idd as $studentid){
                foreach($request->student_id as $teacher){
                $allocation = new Allocation();
                $allocation->student_id  = $studentid ?? NULL;
                $allocation->assigned_by  = $teacher; // Instructor
                $allocation->assigned_id  = $id;   //Test /Survey
                $allocation->start_date  = $request->start_date ?? NULL;
                $allocation->end_date  = $request->end_date ?? NULL;
                $allocation->type  = 1;
                $allocation->save();
                }
            }
        }


        return redirect()->route('test-management.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = explode(',', $request->multiple_delete);
        TestManagement::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        //DB::enableQueryLog();
		$title = $this->title;
        $test = TestManagement::orderBy('id', 'asc')->paginate($this->systemSetting()->pagination);
       //dd(DB::getQueryLog());
        return view('admin.test-management.index', compact('title', 'test'));
    }
}
