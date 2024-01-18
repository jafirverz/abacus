<?php

namespace App\Http\Controllers\CMS;

use App\CategoryCompetition;
use App\Competition;
use App\CompetitionCategory;
use App\CompetitionResultUpload;
use App\CompetitionStudent;
use App\Exports\CompetetitionStudentList;
use App\Http\Controllers\Controller;
use App\Imports\ImportCompetitionResult;
use App\Imports\TempImportCompetitionResult;
use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Excel;

class CompetitionController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.COMPETITION');
        $this->module = 'COMPETITION';
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
        $competition = Competition::orderBy('date_of_competition', 'desc')->paginate($this->pagination);
        
        return view('admin.competition.index', compact('title', 'competition'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $competitionCategory = CompetitionCategory::get();
        $userType = array(1,2,3,4);
        $students = User::whereIn('user_type_id', $userType)->where('approve_status', 1)->get();
        // $worksheets = Worksheet::orderBy('id','desc')->get();
        return view('admin.competition.create', compact('title', 'competitionCategory', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

        $competition = new Competition();
        if ($request->hasFile('compoverimage')) {

            $compoverimage = $request->file('compoverimage');

            $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $compoverimage->getClientOriginalName();

            $filepath = 'storage/competition/';

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

            $filepath = 'storage/competition/';

            Storage::putFileAs(

                'public/competition',
                $compimage,
                $filename

            );

            $competition_path = $filepath . $filename;

            $competition->comp_image = $competition_path;
        }
        $competition->title = $request->title;
        $competition->date_of_competition = $request->date_of_competition;
        $competition->start_time_of_competition = $request->start_time_of_competition;
        $competition->end_time_of_competition = $request->end_time_of_competition;
        $competition->description = $request->description;
        $competition->competition_type = $request->competition_type;
        $competition->status = $request->status ?? null;
        $competition->save();

        $competitionId = $competition->id;
        foreach($request->category as $cate){
            $catCompt = new CategoryCompetition();
            $catCompt->competition_id = $competitionId;
            $catCompt->category_id = $cate;
            $catCompt->save();
        }

        // foreach($request->students as $student){
        //     $comptStu = new CompetitionStudent();
        //     $comptStu->competition_controller_id = $competitionId;
        //     $comptStu->user_id = $student;
        //     $comptStu->save();
        // }

        return redirect()->route('competition.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = $this->title;
        $categoyy = array();
        $competition = Competition::find($id);
        $competitionCategory = CompetitionCategory::get();
        $categoryCompetition = CategoryCompetition::where('competition_id', $id)->pluck('category_id')->toArray();
        if($categoryCompetition){
            $categoyy = CompetitionCategory::whereIn('id', $categoryCompetition)->pluck('category_name')->toArray();
        }
        
        return view('admin.competition.show', compact('title', 'competition', 'categoryCompetition','competitionCategory', 'categoyy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->title;
        $competition = Competition::find($id);
        $competitionCategory = CompetitionCategory::get();
        $userType = array(1,2,3,4);
        $students = User::whereIn('user_type_id', $userType)->where('approve_status', 1)->get();
        $categoryCompetition = CategoryCompetition::where('competition_id', $id)->pluck('category_id')->toArray();
        $comptStu = CompetitionStudent::where('competition_controller_id', $id)->pluck('user_id')->toArray();
        return view('admin.competition.edit', compact('title', 'competition', 'categoryCompetition','competitionCategory', 'students', 'comptStu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

        $competition = Competition::where('id', $id)->first();
        if ($request->hasFile('compoverimage')) {

            $compoverimage = $request->file('compoverimage');

            $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $compoverimage->getClientOriginalName();

            $filepath = 'storage/competition/';

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

            $filepath = 'storage/competition/';

            Storage::putFileAs(

                'public/competition',
                $compimage,
                $filename

            );

            $competition_path = $filepath . $filename;

            $competition->comp_image = $competition_path;
        }
        $competition->title = $request->title;
        $competition->date_of_competition = $request->date_of_competition;
        $competition->start_time_of_competition = $request->start_time_of_competition;
        $competition->end_time_of_competition = $request->end_time_of_competition;
        $competition->description = $request->description;
        //$competition->competition_type = $request->competition_type;
        $competition->status = $request->status ?? null;
        $competition->save();

        $categoryCompetition = CategoryCompetition::where('competition_id', $id)->get();
        foreach($categoryCompetition as $deleteCategory){
            $deleteCategory->delete();
        }
        foreach($request->category as $cate){
            $catCompt = new CategoryCompetition();
            $catCompt->competition_id = $id;
            $catCompt->category_id = $cate;
            $catCompt->save();
        }

        // $studentCompetition = CompetitionStudent::where('competition_controller_id', $id)->get();
        
        // foreach($studentCompetition as $deleteStudent){
        //     $deleteStudent->delete();
        // }
        // foreach($request->students as $key=>$studenttt){
        //     $student = new CompetitionStudent();
        //     $student->competition_controller_id = $id;
        //     $student->user_id = $studenttt;
        //     $student->save();
        // }

        return redirect()->route('competition.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        $competition = Competition::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $competition->appends('search', $search_term);
        }

        return view('admin.competition.index', compact('title', 'competition'));
    }

    public function studentList($id){
        $title = 'Student List';
        $studentList = CompetitionStudent::where('competition_controller_id', $id)->orderBy('id', 'desc')->paginate($this->pagination);
        $competition = Competition::where('id', $id)->first();
        return view('admin.competition.studentList', compact('title', 'studentList', 'competition'));
    }

    public function rejectstudentList($id){
        //dd($id);
        $title = 'Student List';
        $compStudent = CompetitionStudent::where('id', $id)->first();
        $compStudent->approve_status = 2;
        $compStudent->save();
        return redirect()->back()->with('success', __('constant.UPDATED', ['module' => $title]));
    }

    public function approvestudentList(Request $request, $id){
        //dd($id);
        $title = 'Student List';
        $compStudent = CompetitionStudent::where('id', $id)->first();
        $compStudent->approve_status = 1;
        $compStudent->save();
        return redirect()->back()->with('success', __('constant.UPDATED', ['module' => $title]));
    }

    public function uploadCompResult(){
        $title = 'Upload Result';
        $competition = Competition::get();
        return view('admin.competition.result-upload', compact('title', 'competition'));
    }

    public function compResultUpload(Request $request){
        $title = 'Upload Result';
        $messages = [
            // 'amount.required_if' => 'This field is required',
        ];
        $request->validate([
            'competition'  =>  'required',
            'category' => 'required',
            'fileupload'  =>  'required|mimes:xlsx',
        ], $messages);

        $compResultUpload = new CompetitionResultUpload();
        if ($request->hasFile('fileupload')) {

            $file = $request->file('fileupload');
            
            $imported_files[] = "Competition Result Upload";

            if(count($imported_files))
            {
                $implode_files = implode(', ', $imported_files);

                $fileupload = $request->file('fileupload');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $fileupload->getClientOriginalName();

                $filepath = 'storage/competition/result';

                Storage::putFileAs(

                    'public/competition/result',
                    $fileupload,
                    $filename

                );

                $fileupload_path = $filepath . $filename;

                if($request->result_publish_date == date('Y-m-d')){
                    $is_published = 1;
                }else{
                    $is_published = 0;
                }

                $compResultUpload->uploaded_file =  $fileupload_path;
                $compResultUpload->competition_id =  $request->competition;
                $compResultUpload->category_id =  $request->category;
                $compResultUpload->result_publish_date =  $request->result_publish_date;
                $compResultUpload->is_published =  $is_published;
                $compResultUpload->save();

                if($request->result_publish_date == date('Y-m-d')){
                    $result = Excel::import(new ImportCompetitionResult($request->competition, $request->category), $file);
                }else{
                    $result = Excel::import(new TempImportCompetitionResult($request->competition, $request->category, $compResultUpload->id), $file);
                }

                return redirect()->back()->with('success', __('constant.UPDATED', ['module' => $implode_files]));
            }

            return redirect()->back()->with('error',  'Upload files to import data.');

        }
    }

    public function assignCompetition(){
        $title = 'Assign Competition';
        $competition = Competition::paginate($this->pagination);
        
        return view('admin.competition.assign', compact('title', 'competition'));
    }

    public function assignCompetitionEdit($id = null){
        $title = 'Assign Competition';
        $competition = Competition::where('id', $id)->first();
        $competitionCategory = CompetitionCategory::get();
        $userType = array(1,2,3,4);
        $compStudents = CompetitionStudent::where('competition_controller_id', $id)->pluck('user_id')->toArray();
        $students = User::whereIn('user_type_id', $userType)->where('approve_status', 1)->whereNotIn('id', $compStudents)->get();
        // $worksheets = Worksheet::orderBy('id','desc')->get();
        return view('admin.competition.assignstudent', compact('title', 'competition', 'students', 'competitionCategory'));
        
    }

    public function assignCompetitionStore(Request $request){
        //dd($request->all());
        $compId = $request->competitionId;
        $category = $request->category;
        $status = $request->status;
        if($status != 1){
            $status = 'null';
        }
        foreach($request->students as $student){
            $user = User::where('id', $student)->first();
            $compStudent = new CompetitionStudent();
            $compStudent->user_id = $student;
            $compStudent->instructor_id = $user->instructor_id;
            $compStudent->competition_controller_id = $compId;
            $compStudent->category_id = $category;
            $compStudent->approve_status = $status;
            $compStudent->save();
        }
        return redirect()->back()->with('success',  'Assigned');
    }

    public function studentDelete(Request $request){
        $items = explode(',', $request->multiple_delete);
        foreach($items as $item){
            $comStu = CompetitionStudent::where('id', $item)->first();
            $comStu->delete();
        }
        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  'Competition Student']));
    }

    public function studentExcel(Request $request, $id){
        $allItems = CompetitionStudent::where('competition_controller_id', $id)->get();
        ob_end_clean();
        ob_start();
        return Excel::download(new CompetetitionStudentList($allItems), 'CompetitionStudentList.xlsx');
    }
}
