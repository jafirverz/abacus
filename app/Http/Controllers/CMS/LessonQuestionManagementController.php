<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\LessonManagement;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use App\LessonQuestionManagement;
use App\LessonQuestionMisc;
use App\QuestionTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class LessonQuestionManagementController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.LESSON_QUESTION_MANAGEMENT');
        $this->module = 'LESSON_QUESTION_MANAGEMENT';
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
        $title = $this->title;
        $lessons = LessonQuestionManagement::paginate($this->pagination);

        return view('admin.master.lesson-question.index', compact('title', 'lessons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = $this->title;
        $lessons = LessonManagement::get();
        $questionTemplates = QuestionTemplate::whereIn('id', [3,4,5,6,7])->get();
        return view('admin.master.lesson-question.create', compact('title', 'lessons', 'questionTemplates'));
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
        $fields = [
            'title' => 'required',
            'questionTemplate'  =>  'required',
            'lesson'  =>  'required',

        ];
        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $messages['worksheet.required'] = 'The worksheet field is required.';
        $request->validate($fields, $messages);

        if($request->question_type==2 || $request->question_type==1 || $request->question_type==3)
        {
            if ($request->hasfile('input_1')) {
                $question = new LessonQuestionManagement();
                $question->title = $request->title;
                $question->lesson_id = $request->lesson;
                $question->question_template_id = $request->question_type;
                if ($request->hasFile('videofile')) {

                    $videofile = $request->file('videofile');
    
                    $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $videofile->getClientOriginalName();
    
                    $filepath = 'storage/video/';
    
                    Storage::putFileAs(
    
                        'public/video',
                        $videofile,
                        $filename
    
                    );
    
                    $path_profile_picture = $filepath . $filename;
                    $question->video = $path_profile_picture;
                }
                if ($request->hasFile('pdf')) {

                    $pdf = $request->file('pdf');
    
                    $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $pdf->getClientOriginalName();
    
                    $filepath = 'storage/pdf/';
    
                    Storage::putFileAs(
    
                        'public/pdf',
                        $pdf,
                        $filename
    
                    );
    
                    $pdf_path = $filepath . $filename;
                    $question->pdf = $pdf_path;
                }
                if ($request->hasFile('powerpoint')) {

                    $powerpoint = $request->file('powerpoint');
    
                    $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $powerpoint->getClientOriginalName();
    
                    $filepath = 'storage/powerpoint/';
    
                    Storage::putFileAs(
    
                        'public/powerpoint',
                        $powerpoint,
                        $filename
    
                    );
    
                    $powerpoint_path = $filepath . $filename;
                    $question->powerpoint = $powerpoint_path;
                }
                
                $question->abacus_link = $request->abacus;
                $question->description = $request->description;
                $question->status = $request->status;
                // $question->json_question = json_encode($json);
                $question->created_at = Carbon::now();
                $question->save();
                $i = 0;
                foreach ($request->file('input_1') as $file) {

                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/upload-file/', $name);
                    $data[] = $name;

                    $storQues = new LessonQuestionMisc();
                    $storQues->lesson_question_management_id = $question->id;
                    $storQues->question_1 = $name;
                    // $storQues->question_2 = $request->input_3[$i];
                    // $storQues->symbol = $request->input_2[$i];
                    $storQues->answer = $request->input_2[$i];
                    $storQues->marks = $request->marks[$i];
                    if($request->question_type==1){
                        $storQues->block = $request->blocks[$i];
                    }
                    $storQues->save();
                    $i++;
                }

                // $json['input_1']=$data;
                // $json['input_2']=$request->input_2;
            }
            

            
            
        }
        elseif($request->question_type==4)
        {
            $json['input_1']=$request->input_1;
            $json['input_2']=$request->input_2;
            $question = new LessonQuestionManagement();
            $question->title = $request->title;
            $question->lesson_id = $request->lesson;
            $question->question_template_id = $request->question_type;
            if ($request->hasFile('videofile')) {

                $videofile = $request->file('videofile');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $videofile->getClientOriginalName();

                $filepath = 'storage/video/';

                Storage::putFileAs(

                    'public/video',
                    $videofile,
                    $filename

                );

                $path_profile_picture = $filepath . $filename;
                $question->video = $path_profile_picture;
            }
            if ($request->hasFile('pdf')) {

                $pdf = $request->file('pdf');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $pdf->getClientOriginalName();

                $filepath = 'storage/pdf/';

                Storage::putFileAs(

                    'public/pdf',
                    $pdf,
                    $filename

                );

                $pdf_path = $filepath . $filename;
                $question->pdf = $pdf_path;
            }
            if ($request->hasFile('powerpoint')) {

                $powerpoint = $request->file('powerpoint');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $powerpoint->getClientOriginalName();

                $filepath = 'storage/powerpoint/';

                Storage::putFileAs(

                    'public/powerpoint',
                    $powerpoint,
                    $filename

                );

                $powerpoint_path = $filepath . $filename;
                $question->powerpoint = $powerpoint_path;
            }
            $question->abacus_link = $request->abacus;
            $question->description = $request->description;
            $question->status = $request->status;
            $question->created_at = Carbon::now();
            $question->save();
        }
        elseif($request->question_type==6){
            $count = count($request->input_1);
            $question = new LessonQuestionManagement();
            $question->title = $request->title;
            $question->lesson_id = $request->lesson;
            $question->question_template_id = $request->question_type;
            if ($request->hasFile('videofile')) {

                $videofile = $request->file('videofile');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $videofile->getClientOriginalName();

                $filepath = 'storage/video/';

                Storage::putFileAs(

                    'public/video',
                    $videofile,
                    $filename

                );

                $path_profile_picture = $filepath . $filename;
                $question->video = $path_profile_picture;
            }
            if ($request->hasFile('pdf')) {

                $pdf = $request->file('pdf');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $pdf->getClientOriginalName();

                $filepath = 'storage/pdf/';

                Storage::putFileAs(

                    'public/pdf',
                    $pdf,
                    $filename

                );

                $pdf_path = $filepath . $filename;
                $question->pdf = $pdf_path;
            }
            if ($request->hasFile('powerpoint')) {

                $powerpoint = $request->file('powerpoint');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $powerpoint->getClientOriginalName();

                $filepath = 'storage/powerpoint/';

                Storage::putFileAs(

                    'public/powerpoint',
                    $powerpoint,
                    $filename

                );

                $powerpoint_path = $filepath . $filename;
                $question->powerpoint = $powerpoint_path;
            }
            $question->abacus_link = $request->abacus;
            $question->description = $request->description;
            $question->status = $request->status;
            // $question->json_question = json_encode($json);
            $question->created_at = Carbon::now();
            $question->save();

            for($i=0; $i<$count; $i++){
                $storQues = new LessonQuestionMisc();
                $storQues->lesson_question_management_id = $question->id;
                $storQues->question_1 = $request->input_1[$i];
                $storQues->question_2 = $request->input_3[$i];
                $storQues->symbol = $request->input_2[$i];
                $storQues->answer = $request->answer[$i];
                $storQues->marks = $request->marks[$i];
                $storQues->save();
            }
        }
        elseif($request->question_type==5){
            $count = count($request->input_1);
            $question = new LessonQuestionManagement();
            $question->title = $request->title;
            $question->lesson_id = $request->lesson;
            $question->question_template_id = $request->question_type;
            if ($request->hasFile('videofile')) {

                $videofile = $request->file('videofile');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $videofile->getClientOriginalName();

                $filepath = 'storage/video/';

                Storage::putFileAs(

                    'public/video',
                    $videofile,
                    $filename

                );

                $path_profile_picture = $filepath . $filename;
                $question->video = $path_profile_picture;
            }
            if ($request->hasFile('pdf')) {

                $pdf = $request->file('pdf');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $pdf->getClientOriginalName();

                $filepath = 'storage/pdf/';

                Storage::putFileAs(

                    'public/pdf',
                    $pdf,
                    $filename

                );

                $pdf_path = $filepath . $filename;
                $question->pdf = $pdf_path;
            }
            if ($request->hasFile('powerpoint')) {

                $powerpoint = $request->file('powerpoint');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $powerpoint->getClientOriginalName();

                $filepath = 'storage/powerpoint/';

                Storage::putFileAs(

                    'public/powerpoint',
                    $powerpoint,
                    $filename

                );

                $powerpoint_path = $filepath . $filename;
                $question->powerpoint = $powerpoint_path;
            }
            $question->abacus_link = $request->abacus;
            $question->description = $request->description;
            $question->status = $request->status;
            // $question->json_question = json_encode($json);
            $question->created_at = Carbon::now();
            $question->save();

            for($i=0; $i<$count; $i++){
                $storQues = new LessonQuestionMisc();
                $storQues->lesson_question_management_id = $question->id;
                $storQues->question_1 = $request->input_1[$i];
                $storQues->question_2 = $request->input_3[$i];
                $storQues->symbol = $request->input_2[$i];
                $storQues->answer = $request->answer[$i];
                $storQues->marks = $request->marks[$i];
                $storQues->save();
            }
        }
        // elseif($request->question_type==1){
        //     if ($request->hasfile('input_1')) {
        //         foreach ($request->file('input_1') as $file) {

        //             $name = $file->getClientOriginalName();
        //             $file->move(public_path() . '/upload-file/', $name);
        //             $data[] = $name;
        //         }

        //         $json['input_1']=$data;
        //         $json['input_2']=$request->input_2;
        //     }
        // }

        //dd($question);
        
        return redirect()->route('lesson-questions.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LessonQuestionManagement  $lessonQuestionManagement
     * @return \Illuminate\Http\Response
     */
    public function show(LessonQuestionManagement $lessonQuestionManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LessonQuestionManagement  $lessonQuestionManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = $this->title;
        $lessons = LessonManagement::get();
        $question = LessonQuestionManagement::findorfail($id);
        $questionTemplates = QuestionTemplate::whereIn('id', [3,4,5,6,7])->get();
        return view('admin.master.lesson-question.edit', compact('title', 'question', 'questionTemplates', 'lessons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LessonQuestionManagement  $lessonQuestionManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $competition_paper_id = $id;
        $question_template_id = $request->question_template_id;

        $question = LessonQuestionManagement::where('id', $id)->first();
        $question->title = $request->title;
        $question->lesson_id = $request->lesson;
        // $question->question_template_id = $request->question_type;
        if ($request->hasFile('videofile')) {

            $videofile = $request->file('videofile');

            $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $videofile->getClientOriginalName();

            $filepath = 'storage/video/';

            Storage::putFileAs(

                'public/video',
                $videofile,
                $filename

            );

            $path_profile_picture = $filepath . $filename;
            $question->video = $path_profile_picture;
        }
        if ($request->hasFile('pdf')) {

            $pdf = $request->file('pdf');

            $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $pdf->getClientOriginalName();

            $filepath = 'storage/pdf/';

            Storage::putFileAs(

                'public/pdf',
                $pdf,
                $filename

            );

            $pdf_path = $filepath . $filename;
            $question->pdf = $pdf_path;
        }
        if ($request->hasFile('powerpoint')) {

            $powerpoint = $request->file('powerpoint');

            $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $powerpoint->getClientOriginalName();

            $filepath = 'storage/powerpoint/';

            Storage::putFileAs(

                'public/powerpoint',
                $powerpoint,
                $filename

            );

            $powerpoint_path = $filepath . $filename;
            $question->powerpoint = $powerpoint_path;
        }
        
        $question->abacus_link = $request->abacus;
        $question->description = $request->description;
        $question->status = $request->status;
        // $question->json_question = json_encode($json);
        $question->created_at = Carbon::now();
        $question->save();

        $storQues = LessonQuestionMisc::where('lesson_question_management_id', $id)->get();
        foreach($storQues as $quess){
            $quess->delete();
        }
        if($question_template_id == 4 || $question_template_id == 5 || $question_template_id == 6 || $question_template_id == 7){
            $count = count($request->input_1);
            for($i=0; $i<$count; $i++){
                $storQues = new LessonQuestionMisc();
                $storQues->lesson_question_management_id = $competition_paper_id;
                $storQues->question_1 = $request->input_1[$i];
                $storQues->question_2 = $request->input_3[$i];
                $storQues->symbol = $request->input_2[$i];
                $storQues->answer = $request->answer[$i];
                $storQues->marks = $request->marks[$i];
                $storQues->save();
            }
        }
        elseif($question_template_id == 1)
        {

            if ($request->hasfile('input_1')) {
                $i = 0;
                foreach ($request->file('input_1') as $file) {

                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/upload-file/', $name);
                    //$data[] = $name;
                    $storQues = new LessonQuestionMisc();
                    $storQues->lesson_question_management_id = $competition_paper_id;
                    $storQues->question_1 = $name;
                    $storQues->symbol = 'listening';
                    $storQues->answer = $request->input_2[$i];
                    $storQues->marks = $request->marks[$i];
                    $storQues->save();
                    $i++;
                }

                // $json['input_1']=$data;
                // $json['input_2']=$request->input_2;
            }
        }
        elseif($question_template_id == 2)
        {

            if ($request->hasfile('input_1')) {
                $i = 0;
                foreach ($request->file('input_1') as $file) {

                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/upload-file/', $name);
                    //$data[] = $name;
                    $storQues = new LessonQuestionMisc();
                    $storQues->lesson_question_management_id = $competition_paper_id;
                    $storQues->question_1 = $name;
                    $storQues->symbol = 'video';
                    $storQues->answer = $request->input_2[$i];
                    $storQues->marks = $request->marks[$i];
                    $storQues->save();
                    $i++;
                }

                // $json['input_1']=$data;
                // $json['input_2']=$request->input_2;
            }
        }
        elseif($question_template_id == 3)
        {
            
            if ($request->hasfile('input_1')) {
                $i = 0;
                foreach ($request->file('input_1') as $file) {

                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/upload-file/', $name);
                    //$data[] = $name;
                    $storQues = new LessonQuestionMisc();
                    $storQues->lesson_question_management_id = $competition_paper_id;
                    $storQues->question_1 = $name;
                    $storQues->symbol = 'number_question';
                    $storQues->answer = $request->input_2[$i];
                    $storQues->marks = $request->marks[$i];
                    $storQues->save();
                    $i++;
                }

                // $json['input_1']=$data;
                // $json['input_2']=$request->input_2;
            }
        }

        return redirect()->route('lesson-questions.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LessonQuestionManagement  $lessonQuestionManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(LessonQuestionManagement $lessonQuestionManagement)
    {
        //
    }
}
