<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\GradingExam;
use App\Grade;
use App\GradingCategory;
use App\CategoryGrading;
use App\GradingStudent;
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
        $competition = GradingExam::paginate($this->pagination);

        return view('admin.grading-exam.index', compact('title', 'competition'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $competitionCategory = GradingCategory::get();
        $grades = Grade::get();
        $userType = array(1,2,3,4);
        $students = User::whereIn('user_type_id', $userType)->where('approve_status', 1)->get();
        return view('admin.grading-exam.create',compact('title', 'competitionCategory', 'students','grades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            // 'amount.required_if' => 'This field is required',
        ];
        $request->validate([
            'title'  =>  'required',
            'competition_type'  =>  'required',
            //'students' => 'required',
            'category' => 'required',
            'date_of_competition'  =>  'required',
            'start_time_of_competition'  =>  'required',
            //'end_time_of_competition'  =>  'required',
        ], $messages);

        $competition = new GradingExam();
        if ($request->hasFile('compoverimage')) {

            $compoverimage = $request->file('compoverimage');

            $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $compoverimage->getClientOriginalName();

            $filepath = 'storage/grading/';

            Storage::putFileAs(

                'public/competition',
                $compoverimage,
                $filename

            );

            $compoverimage_path = $filepath . $filename;

            $competition->overview_image =  $compoverimage_path;
        }
        if ($request->hasFile('compimage')) {

            $compimage = $request->file('compimage');

            $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $compimage->getClientOriginalName();

            $filepath = 'storage/grading/';

            Storage::putFileAs(

                'public/competition',
                $compimage,
                $filename

            );

            $competition_path = $filepath . $filename;

            $competition->comp_image = $competition_path;
        }
        $competition->title = $request->title;
        $competition->exam_venue = $request->exam_venue;
        // if(isset($request->grade))
        // {
        //     $competition->grade = json_encode($request->grade);
        // }

        $competition->date_of_competition = $request->date_of_competition;
        $competition->start_time_of_competition = $request->start_time_of_competition;
        $competition->end_time_of_competition = $request->end_time_of_competition;
        $competition->description = $request->description;
        $competition->competition_type = $request->competition_type;
        $competition->status = $request->status ?? null;
        $competition->save();

        $competitionId = $competition->id;
        foreach($request->category as $cate){
            $catCompt = new CategoryGrading();
            $catCompt->competition_id = $competitionId;
            $catCompt->category_id = $cate;
            $catCompt->save();
        }

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
        $categoyy = array();
        $competition = GradingExam::find($id);
        $competitionCategory = GradingCategory::get();
        $categoryCompetition = CategoryGrading::where('competition_id', $id)->pluck('category_id')->toArray();
        if($categoryCompetition){
            $categoyy = GradingCategory::whereIn('id', $categoryCompetition)->pluck('category_name')->toArray();
        }
        return view('admin.grading-exam.show', compact('title', 'competition', 'categoryCompetition','competitionCategory', 'categoyy'));
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
        $competition = GradingExam::find($id);
        $competitionCategory = GradingCategory::get();
        $userType = array(1,2,3,4);
        $students = User::whereIn('user_type_id', $userType)->where('approve_status', 1)->get();
        $grades = Grade::get();
        $categoryCompetition = CategoryGrading::where('competition_id', $id)->pluck('category_id')->toArray();

        return view('admin.grading-exam.edit', compact('title', 'competition','grades', 'categoryCompetition','competitionCategory', 'students'));
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
        $messages = [
            // 'amount.required_if' => 'This field is required',
        ];
        $request->validate([
            'title'  =>  'required',
            //'competition_type'  =>  'required',
            'category' => 'required',
            'date_of_competition'  =>  'required',
            'start_time_of_competition'  =>  'required',
            // 'end_time_of_competition'  =>  'required',
        ], $messages);


        $competition = GradingExam::where('id', $id)->first();
        if ($request->hasFile('compoverimage')) {

            $compoverimage = $request->file('compoverimage');

            $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $compoverimage->getClientOriginalName();

            $filepath = 'storage/grading/';

            Storage::putFileAs(

                'public/grading',
                $compoverimage,
                $filename

            );

            $compoverimage_path = $filepath . $filename;

            $competition->overview_image =  $compoverimage_path;
        }
        if ($request->hasFile('compimage')) {

            $compimage = $request->file('compimage');

            $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $compimage->getClientOriginalName();

            $filepath = 'storage/grading/';

            Storage::putFileAs(

                'public/competition',
                $compimage,
                $filename

            );

            $competition_path = $filepath . $filename;

            $competition->comp_image = $competition_path;
        }
        $competition->title = $request->title;
        $competition->exam_venue = $request->exam_venue;
        // if(isset($request->grade))
        // {
        //     $competition->grade = json_encode($request->grade);
        // }
        $competition->date_of_competition = $request->date_of_competition;
        $competition->start_time_of_competition = $request->start_time_of_competition;
        $competition->end_time_of_competition = $request->end_time_of_competition;
        $competition->description = $request->description;
        //$competition->competition_type = $request->competition_type;
        $competition->status = $request->status ?? null;
        $competition->save();

        $categoryCompetition = CategoryGrading::where('competition_id', $id)->get();
        foreach($categoryCompetition as $deleteCategory){
            $deleteCategory->delete();
        }
        foreach($request->category as $cate){
            $catCompt = new CategoryGrading();
            $catCompt->competition_id = $id;
            $catCompt->category_id = $cate;
            $catCompt->save();
        }

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
        $competition = GradingExam::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $competition->appends('search', $search_term);
        }

        return view('admin.grading-exam.index', compact('title', 'competition'));
    }


    public function studentList($id){
        $title = 'Student List';
        $studentList = GradingStudent::where('grading_exam_id', $id)->orderBy('id', 'desc')->paginate($this->pagination);
        return view('admin.grading-exam.studentList', compact('title', 'studentList'));
    }

    public function rejectstudentList($id){
        //dd($id);
        $title = 'Student List';
        $compStudent = GradingStudent::where('id', $id)->first();
        $compStudent->approve_status = 2;
        $compStudent->save();
        return redirect()->back()->with('success', __('constant.UPDATED', ['module' => $title]));
    }

    public function approvestudentList(Request $request, $id){
        //dd($id);
        $title = 'Student List';
        $compStudent = GradingStudent::where('id', $id)->first();
        $compStudent->approve_status = 1;
        $compStudent->save();
        return redirect()->back()->with('success', __('constant.UPDATED', ['module' => $title]));
    }
}
