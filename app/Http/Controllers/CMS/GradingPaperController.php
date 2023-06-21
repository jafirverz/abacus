<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\GradingPaper;
use App\User;
use App\QuestionTemplate;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class GradingPaperController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.GRADING_PAPER');
        $this->module = 'GRADING_PAPER';
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
        $paper = GradingPaper::paginate($this->pagination);

        return view('admin.master.grading-paper.index', compact('title', 'paper'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $templates = QuestionTemplate::get();
        return view('admin.master.grading-paper.create', compact('title','templates'));
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
            'question_type'  =>  'required',
        ]);

        if($request->question_type==5)
        {
        $json['input_1']=$request->input_1;
        $json['input_2']=$request->input_2;
        $json['input_3']=$request->input_3;
        }
        elseif($request->question_type==2)
        {
            if ($request->hasfile('input_1')) {
                foreach ($request->file('input_1') as $file) {

                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/upload-file/', $name);
                    $data[] = $name;
                }

                $json['input_1']=$data;
                $json['input_2']=$request->input_2;
            }
        }
        elseif($request->question_type==4)
        {
            $json['input_1']=$request->input_1;
            $json['input_2']=$request->input_2;
        }elseif($request->question_type==1){
            if ($request->hasfile('input_1')) {
                foreach ($request->file('input_1') as $file) {

                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/upload-file/', $name);
                    $data[] = $name;
                }

                $json['input_1']=$data;
                $json['input_2']=$request->input_2;
            }
        }

        //dd($question);
        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $messages['question_type.required'] = 'The question type field is required.';
        $request->validate($fields, $messages);

        $paper = new GradingPaper();
        $paper->title = $request->title;
        $paper->worksheet_id = $request->worksheet_id;
        $paper->question_type = $request->question_type;
        $paper->json_question = json_encode($json);
        $paper->created_at = Carbon::now();
        $paper->save();

        return redirect()->route('grading-paper.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $paper = GradingPaper::find($id);
        $templates = QuestionTemplate::get();
        return view('admin.master.grading-paper.show', compact('title', 'paper','templates'));
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
        $paper = GradingPaper::findorfail($id);
        $templates = QuestionTemplate::get();
        return view('admin.master.grading-paper.edit', compact('title', 'paper','templates'));
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
            'question_type'  =>  'required',
        ]);

        if($request->question_type==1)
        {
        $json['input_1']=$request->input_1;
        $json['input_2']=$request->input_2;
        $json['input_3']=$request->input_3;
        }
        elseif($request->question_type==2)
        {
            $input_1_old=$request->input_1_old;
            if ($request->hasfile('input_1')) {
                foreach ($request->file('input_1') as $file) {

                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/upload-file/', $name);
                    array_push($input_1_old,$name);
                }




            }
            $json['input_1']=$input_1_old;
            $json['input_2']=$request->input_2;
        }
        elseif($request->question_type==4)
        {
            $json['input_1']=$request->input_1;
            $json['input_2']=$request->input_2;
        }

        //dd($question);
        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $messages['question_type.required'] = 'The question type field is required.';
        $request->validate($fields, $messages);

        $paper = GradingPaper::findorfail($id);
        $paper->title = $request->title;
        $paper->question_type = $request->question_type;
        $paper->json_question = json_encode($json);
        $paper->updated_at = Carbon::now();
        $paper->save();

        return redirect()->route('grading-paper.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
        GradingPaper::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $templates = QuestionTemplate::get();
        $title = $this->title;
        $paper = GradingPaper::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $category->appends('search', $search_term);
        }

        return view('admin.master.grading-paper.index', compact('title', 'templates','paper'));
    }
}
