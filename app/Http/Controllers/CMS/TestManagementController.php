<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\TestManagement;
use App\User;
use App\Course;
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
        $test = TestManagement::orderBy('id', 'asc')->paginate($this->pagination);

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
        $papers = TestPaper::orderBy('id','desc')->get();
        return view('admin.test-management.create', compact('title','courses','papers','students'));
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
            'student_id'  =>  'required',
            'template'  =>  'required',
        ]);

        $testManagement = new TestManagement;
        $testManagement->title = $request->title ?? '';
        $testManagement->paper_id = $request->paper_id ?? '';
        $testManagement->course_id = $request->course_id ?? '';
        $testManagement->template = $request->template ?? '';
        $testManagement->student_id = json_encode($request->student_id);
        $testManagement->created_at = Carbon::now();
        $testManagement->save();

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
        $material = TestManagement::findorfail($id);
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.test_management.show', compact('title', 'material','instructors'));
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
        $papers = TestPaper::orderBy('id','desc')->get();
        return view('admin.test-management.edit', compact('title', 'test','courses','papers','students'));
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
            'student_id'  =>  'required',
            'template'  =>  'required',
        ]);

        $testManagement = TestManagement::findorfail($id);
        $testManagement->title = $request->title ?? '';

        $testManagement->teacher_id = $request->teacher_id ?? '';
        $testManagement->paper_id = $request->paper_id ?? '';
        $testManagement->course_id = $request->course_id ?? '';
        $testManagement->student_id = json_encode($request->student_id);
        $testManagement->created_at = Carbon::now();
        $testManagement->save();

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
        $materials = TestManagement::join('users','users.id','teaching_materials.teacher_id')->search($request->search)->select('teaching_materials.*')->orderBy('teaching_materials.id', 'asc')->paginate($this->systemSetting()->pagination);
       //dd(DB::getQueryLog());
        return view('admin.test_management.index', compact('title', 'materials'));
    }
}
