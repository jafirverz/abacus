<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GradingResultsUpload;
use App\GradingStudentResults;
use App\GradingExam;
use App\GradingCategory;
use App\Exports\GradingResultExport;
use App\Imports\ImportGradingResult;
use App\GradingSubmitted;
use App\GradingStudent;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use Excel;

class GradingAssignUploadReportController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.GRADING_RESULT_UPLOAD');
        $this->module = 'GRADING_RESULT_UPLOAD';
        $this->middleware('grant.permission:'.$this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(){
        $title = 'Upload Result';
        $competition = GradingExam::get();
        return view('admin.grading_result.result-upload', compact('title', 'competition'));
    }

    public function store(Request $request){
        $title = 'Upload Result';
        $messages = [
            // 'amount.required_if' => 'This field is required',
        ];
        $request->validate([
            'competition'  =>  'required',
            'category' => 'required',
            'fileupload'  =>  'required|mimes:xlsx',
        ], $messages);

        $compResultUpload = new GradingResultsUpload();
        if ($request->hasFile('fileupload')) {

            $file = $request->file('fileupload');

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

                if($request->result_publish_date == date('Y-m-d')){
                    $is_published = 1;
                }else{
                    $is_published = 0;
                }

                $compResultUpload->uploaded_file =  $fileupload_path;
                $compResultUpload->grading_id  =  $request->competition;
                $compResultUpload->category_id =  $request->category;
                $compResultUpload->result_publish_date =  $request->result_publish_date;
                $compResultUpload->is_published =  $is_published;
                $compResultUpload->save();

                if($request->result_publish_date == date('Y-m-d')){
                    $result = Excel::import(new ImportGradingResult($request->competition, $request->category), $file);
                }else{
                    $result = Excel::import(new ImportGradingResult($request->competition, $request->category, $compResultUpload->id), $file);
                }

                return redirect()->back()->with('success', __('constant.UPDATED', ['module' => $implode_files]));
            }

            return redirect()->back()->with('error',  'Upload files to import data.');

        }
    }
}
