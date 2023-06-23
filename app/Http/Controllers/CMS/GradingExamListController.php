<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\GradingExam;
use App\GradingExamList;
use App\User;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class GradingExamListController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.GRADING_EXAM_LIST');
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
    public function index($exam_id)
    {
        $title = $this->title;
        $list = GradingExamList::where('grading_exams_id',$exam_id)->paginate($this->pagination);

        return view('admin.grading-exam.listing.index', compact('title', 'list','exam_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($exam_id)
    {
        $title = $this->title;
        return view('admin.grading-exam.listing.create', compact('title','exam_id'));
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
            'heading'  =>  'required',

        ]);

        $gradingExamList = new GradingExamList();
        $gradingExamList->heading = $request->heading ?? NULL;
        $gradingExamList->grading_exams_id  = $request->exam_id;
        if ($request->hasfile('input_3')) {
            foreach ($request->file('input_3') as $file) {

                //$name = $file->getClientOriginalName();
                //$file->move(public_path() . '/upload-file/', $name);
                $data[] = uploadPicture($file, 'upload-file');;
            }

            $json['input_3']=$data;
            $json['input_2']=$request->input_2;
            $json['input_1']=$request->input_1;
            $gradingExamList->json_content = json_encode($json);
        }
        $gradingExamList->save();

        return redirect()->route('grading-exam-list.index',$request->exam_id)->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        return view('admin.grading-exam.listing.show', compact('title', 'exam','students'));
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
        return view('admin.grading-exam.listing.edit', compact('title', 'exam','students'));
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
            'heading'  =>  'required',

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

        return redirect()->route('grading-exam-list.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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

    public function search(Request $request,$exam_id)
    {
        $search_term = $request->search;
        $title = $this->title;
        $list = GradingExamList::where('grading_exams_id',$exam_id)->search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $list->appends('search', $search_term);
        }

        return view('admin.grading-exam.listing.index', compact('title', 'list','exam_id'));
    }
}
