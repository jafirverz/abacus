<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\CategoryCompetition;
use App\Competition;
use App\CompetitionCategory;
use App\CompetitionResultUpload;
use App\CompetitionStudent;
use App\Exports\CompetetitionStudentList;
use App\Imports\ImportCompetitionResult;
use App\Imports\TempImportCompetitionResult;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Excel;

class CompetitionResultUploadController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.COMPETITION_RESULT_UPLOAD');
        $this->module = 'COMPETITION_RESULT_UPLOAD';
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
        $title = 'Upload Result';
        $competition = Competition::orderBy('id', 'desc')->get();
        return view('admin.competition.result-upload', compact('title', 'competition'));
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

    /**
     * Display the specified resource.
     *
     * @param  \App\CompetitionResultUpload  $competitionResultUpload
     * @return \Illuminate\Http\Response
     */
    public function show(CompetitionResultUpload $competitionResultUpload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CompetitionResultUpload  $competitionResultUpload
     * @return \Illuminate\Http\Response
     */
    public function edit(CompetitionResultUpload $competitionResultUpload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompetitionResultUpload  $competitionResultUpload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompetitionResultUpload $competitionResultUpload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CompetitionResultUpload  $competitionResultUpload
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompetitionResultUpload $competitionResultUpload)
    {
        //
    }
}
