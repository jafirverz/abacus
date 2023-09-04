<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Level;
use App\CourseAssignToUser;
use App\Course;
use App\User;
use App\TestPaper;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.COURSE');
        $this->module = 'COURSE';
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
        $course = Course::paginate($this->pagination);

        return view('admin.master.course.index', compact('title', 'course'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $levels = Level::get();
        $papers = TestPaper::where('paper_type',2)->orderBy('id','desc')->get();
        $students = User::where('user_type_id', 3)->orderBy('id','desc')->get();
        return view('admin.master.course.create', compact('title','students','levels','papers'));
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
            'level'  =>  'required',
            'content'  =>  'required',
            'paper_id'  =>  'required',
            'students.0'  =>  'required',
            'title'  =>  'required|unique:courses,title|max:191',
        ],['students.0.required'    => 'Student field is required.']);

        $course = new Course();
        $course->level_id = $request->level;
        $course->title = $request->title;
        $course->paper_id = $request->paper_id;
        $course->content = $request->content;
        $course->status = $request->status;
        $course->save();

        foreach($request->students as $student)
        {
            $courseAssignToUser = new CourseAssignToUser();
            $courseAssignToUser->course_id =$course->id;
            $courseAssignToUser->user_id =$student;
            $courseAssignToUser->save();
        }


        return redirect()->route('course.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $course = Course::find($id);
        $courseAssignToUser = CourseAssignToUser::where('course_id',$id)->pluck('user_id')->toArray();

        return view('admin.master.course.show', compact('title', 'course','courseAssignToUser'));
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
        $course = Course::findorfail($id);
        $levels = Level::get();
        $papers = TestPaper::where('paper_type',2)->orderBy('id','desc')->get();
        $students = User::where('user_type_id', 3)->orderBy('id','desc')->get();
        $courseAssignToUser = CourseAssignToUser::where('course_id',$id)->pluck('user_id')->toArray();
        //dd($courseAssignToUser);

        return view('admin.master.course.edit', compact('title', 'course','students', 'levels','papers','courseAssignToUser'));
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
            'level'  =>  'required',
            'content'  =>  'required',
            'paper_id'  =>  'required',
            'students.0'  =>  'required',
            'title'  =>  'required|unique:courses,title,'.$id.',id|max:191',
        ],['students.0.required'    => 'Student field is required.']);

        $course = Course::findorfail($id);
        $course->level_id = $request->level;
        $course->title = $request->title;
        $course->paper_id = $request->paper_id;
        $course->content = $request->content;
        $course->status = $request->status;
        $course->save();

        CourseAssignToUser::where('course_id', $id)->delete();

        foreach($request->students as $student)
        {
            $courseAssignToUser = new CourseAssignToUser();
            $courseAssignToUser->course_id =$course->id;
            $courseAssignToUser->user_id =$student;
            $courseAssignToUser->save();
        }

        return redirect()->route('course.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = explode(',', $request->multiple_delete);
        Course::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module' =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        $course = Course::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $course->appends('search', $search_term);
        }
        $papers = TestPaper::orderBy('id','desc')->get();
        return view('admin.master.course.index', compact('title', 'course','papers'));
    }
}
