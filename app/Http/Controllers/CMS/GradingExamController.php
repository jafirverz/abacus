<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\GradingExam;
use App\User;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class GradingExamController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.GRADING_EXAM');
        $this->module = 'GRADING_EXAM';
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
        $category = GradingExam::paginate($this->pagination);

        return view('admin.grading-exam.index', compact('title', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $students = User::orderBy('id','desc')->where('user_type_id','!=',5)->where('approve_status','!=',0)->get();
        return view('admin.grading-exam.create', compact('title','students'));
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
            'type'  =>  'required',
            'layout'  =>  'required',
            'exam_date'  =>  'required',
            'student_id.*'  =>  'required',
            'status'  =>  'required',
        ]);

        $gradingExam = new GradingExam();
        $gradingExam->title = $request->title ?? NULL;
        $gradingExam->type = $request->type ?? NULL;
        $gradingExam->layout = $request->layout ?? NULL;
        $gradingExam->exam_date = $request->exam_date ?? NULL;
        $gradingExam->student_id = $request->student_id?json_encode($request->student_id): NULL;
        $gradingExam->layout = $request->layout ?? NULL;
        $gradingExam->important_note = $request->important_note ?? NULL;
        $gradingExam->status = $request->status ?? NULL;
        $gradingExam->save();

        return redirect()->route('grading-exam.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $exam = GradingExam::find($id);
        $students = User::orderBy('id','desc')->where('user_type_id','!=',5)->where('approve_status','!=',0)->get();
        return view('admin.grading-exam.show', compact('title', 'exam','students'));
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
        $exam = GradingExam::findorfail($id);
        $students = User::orderBy('id','desc')->where('user_type_id','!=',5)->where('approve_status','!=',0)->get();
        return view('admin.grading-exam.edit', compact('title', 'exam','students'));
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
            'type'  =>  'required',
            'layout'  =>  'required',
            'exam_date'  =>  'required',
            'student_id.*'  =>  'required',
            'status'  =>  'required',
        ]);

        $gradingExam = GradingExam::findorfail($id);
        $gradingExam->title = $request->title ?? NULL;
        $gradingExam->type = $request->type ?? NULL;
        $gradingExam->layout = $request->layout ?? NULL;
        $gradingExam->exam_date = $request->exam_date ?? NULL;
        $gradingExam->student_id = $request->student_id?json_encode($request->student_id): NULL;
        $gradingExam->layout = $request->layout ?? NULL;
        $gradingExam->important_note = $request->important_note ?? NULL;
        $gradingExam->status = $request->status ?? NULL;
        $gradingExam->save();

        return redirect()->route('grading-exam.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
        GradingExam::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        $category = GradingExam::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $category->appends('search', $search_term);
        }

        return view('admin.grading-exam.index', compact('title', 'category'));
    }
}
