<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use App\CategoryCompetition;
use App\Competition;
use App\CompetitionCategory;
use App\CompetitionPassUpload;
use App\CompetitionResultUpload;
use App\CompetitionStudent;
use App\Exports\CompetetitionStudentList;
use App\GradingExam;
use App\Imports\ImportCompetitionResult;
use App\Imports\ImportGradingPass;
use App\Imports\TempImportCompetitionResult;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Excel;

class GradingPassUploadController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.GRADING_PASS_UPLOAD');
        $this->module = 'GRADING_PASS_UPLOAD';
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
        //
        $title = 'Upload Grading Pass';
        $competition = GradingExam::where('competition_type', 'physical')->where('status', 1)->get();
        return view('admin.grading-exam.pass-upload', compact('title', 'competition'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $title = 'Upload Pass';
        $messages = [
            // 'amount.required_if' => 'This field is required',
        ];
        $request->validate([
            'competition'  =>  'required',
            //'category' => 'required',
            'fileupload'  =>  'required|mimes:xlsx',
        ], $messages);

        $compPassUpload = new CompetitionPassUpload();
        if ($request->hasFile('fileupload')) {

            $file = $request->file('fileupload');
            
            $imported_files[] = "Grading Pass Upload";

            if(count($imported_files))
            {
                $implode_files = implode(', ', $imported_files);

                $fileupload = $request->file('fileupload');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $fileupload->getClientOriginalName();

                $filepath = 'storage/competition/pass';

                Storage::putFileAs(

                    'public/competition/pass',
                    $fileupload,
                    $filename

                );

                $fileupload_path = $filepath . $filename;

                $result = Excel::import(new ImportGradingPass($request->competition), $file);

                // if($request->result_publish_date == date('Y-m-d')){
                //     $is_published = 1;
                // }else{
                //     $is_published = 0;
                // }

                // $compPassUpload->uploaded_file =  $fileupload_path;
                // $compPassUpload->competition_id =  $request->competition;
                // $compPassUpload->category_id =  $request->category;
                // $compPassUpload->result_publish_date =  $request->result_publish_date;
                // $compPassUpload->is_published =  $is_published;
                // $compPassUpload->save();

                // if($request->result_publish_date == date('Y-m-d')){
                //     $result = Excel::import(new ImportCompetitionResult($request->competition, $request->category), $file);
                // }else{
                //     $result = Excel::import(new TempImportCompetitionResult($request->competition, $request->category, $compPassUpload->id), $file);
                // }

                return redirect()->back()->with('success', __('constant.UPDATED', ['module' => $implode_files]));
            }

            return redirect()->back()->with('error',  'Upload files to import data.');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
