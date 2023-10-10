<?php

namespace App\Http\Controllers\CMS;

use App\Grade;
use App\GradingExam;
use App\Imports\ImportGradingResult;
use App\GradingExamList;
use App\GradingStudent;
use App\GradingResultsUpload;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use Excel;

class GradingResultController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.GRADING_RESULT');
        $this->module = 'GRADING_RESULT';
        $this->middleware('grant.permission:'.$this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {

        $title = $this->title;
        $grading = GradingStudent::paginate($this->pagination);
        //dd($grading);
        return view('admin.grading_result.index', compact('title', 'grading'));
    }

    public function studentList($id){
        $title = $this->title;
        $userList = CompetitionPaperSubmitted::where('competition_id', $id)->where('paper_type', 'actual')->paginate($this->pagination);
        return view('admin.grading_result.userList', compact('title', 'userList'));
    }

    public function edit($id){
        $title = $this->title;
        $grading = GradingStudent::where('id', $id)->first();
        $mental_grades = Grade::where('grade_type_id', 1)->orderBy('id','desc')->get();
        $abacus_grades = Grade::where('grade_type_id', 2)->orderBy('id','desc')->get();
        $gradingExam = GradingExam::where('status', 1)->get();
        //dd($grading);
        return view('admin.grading_result.edit', compact('title', 'grading','mental_grades','abacus_grades','gradingExam'));

    }

    public function update(Request $request, $id){
         $request->validate([
            'mental_grade' => 'required',
            'abacus_grade' => 'required',
        ]);


        $gradingStudent = GradingStudent::find($id);
        $gradingStudent->mental_grade  = $request->mental_grade ?? NULL;
        $gradingStudent->abacus_grade  = $request->abacus_grade ?? NULL;
        $gradingStudent->remarks  = $request->remarks ?? NULL;
        $gradingStudent->approve_status  = $request->approve_status ?? NULL;
        $gradingStudent->save();

        return redirect()->route('grading-students.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }

    public function destroy(Request $request)
    {
        $id = explode(',', $request->multiple_delete);
        GradingExam::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function uploadCompResult(){
        $title = 'Upload Result';
        $grading = GradingExam::get();
        //dd($grading);
        return view('admin.grading_result.result-upload', compact('title', 'grading'));
    }

    public function compResultUpload(Request $request){
        $title = 'Upload Result';
        $messages = [
            // 'amount.required_if' => 'This field is required',
        ];
        $request->validate([
            'grading_id'  =>  'required',
            'list_id'  =>  'required',
            'paper_id'  =>  'required',
            'fileupload'  =>  'required',
        ], $messages);

        $gradingResultsUpload = new GradingResultsUpload();
        if ($request->hasFile('fileupload')) {

            $file = $request->file('fileupload');
            $result = Excel::import(new ImportGradingResult($request->grading_id,$request->paper_id), $file);

            $imported_files[] = "Grading Result Upload";

            if(count($imported_files))
            {
                $implode_files = implode(', ', $imported_files);

                $fileupload = $request->file('fileupload');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $fileupload->getClientOriginalName();

                $filepath = 'storage/grading/result';

                Storage::putFileAs(

                    'public/grading/result',
                    $fileupload,
                    $filename

                );

                $fileupload_path = $filepath . $filename;

                $gradingResultsUpload->uploaded_file =  $fileupload_path;
                $gradingResultsUpload->grading_id  =  $request->grading_id;
                $gradingResultsUpload->save();

                return redirect()->back()->with('success', __('constant.UPDATED', ['module' => $implode_files]));
            }

            return redirect()->back()->with('error',  'Upload files to import data.');

        }
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
