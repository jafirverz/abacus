<?php

namespace App\Http\Controllers\CMS;

use App\StandalonePage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\QuestionTemplate;
use App\StandaloneQuestions;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class StandalonePageController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.STANDALONE_PAGE');
        $this->module = 'STANDALONE_PAGE';
        $this->middleware('grant.permission:' . $this->module);
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
        $standalonepage = StandalonePage::orderBy('id','desc')->paginate($this->pagination);

        return view('admin.standalone', compact('title', 'standalonepage'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StandalonePage  $standalonePage
     * @return \Illuminate\Http\Response
     */
    public function show(StandalonePage $standalonePage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StandalonePage  $standalonePage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = $this->title;
        $standalonepage = StandalonePage::find($id);

        return view('admin.standalone-edit', compact('title', 'standalonepage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StandalonePage  $standalonePage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $fields = [
            'title' => 'required',

        ];
        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $request->validate($fields, $messages);

        $standPage = StandalonePage::find($id);
        $standPage->title = $request->title;
        $standPage->description = $request->description;
        $standPage->status = $request->status;
        $standPage->save();

        return redirect()->route('standalone.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StandalonePage  $standalonePage
     * @return \Illuminate\Http\Response
     */
    public function destroy(StandalonePage $standalonePage)
    {
        //
    }

    public function questionslist($id){
        $standalonePageId = $id;
        $title = 'Standalone Questions';
        $questions = StandaloneQuestions::groupBy('question_template_id')->get();
        return view('admin.standalone-questions', compact('title', 'questions', 'standalonePageId'));
    }

    public function questionsAdd(){
        $title = 'Standalone Questions';
        $questionsTemplate = QuestionTemplate::whereIn('id', [3,4,5,6,7])->get();
        $questions = StandaloneQuestions::groupBy('question_template_id')->pluck('question_template_id')->toArray();
        return view('admin.standalone-questionsadd', compact('title', 'questionsTemplate', 'questions'));
    }

    public function questionsStore(Request $request){
        if($request->question_type==2 || $request->question_type==1 || $request->question_type==3)
        {
            if ($request->hasfile('input_1')) {
                
                $i = 0;
                foreach ($request->file('input_1') as $file) {

                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/upload-file/', $name);
                    $data[] = $name;

                    $storQues = new StandaloneQuestions();
                    $storQues->standalone_page_id = 1;
                    $storQues->question_template_id = $request->question_type;
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
            

            $count = count($request->input_1);
            for($i=0; $i<$count; $i++){
                $storQues = new StandaloneQuestions();
                $json['input_1']=$request->input_1[$i];
                $storQues->standalone_page_id = 1;
                $storQues->question_template_id = $request->question_type;
                $storQues->question_1 = $request->input_1[$i];
                //$storQues->question_2 = $request->input_3[$i];
                //$storQues->symbol = $request->input_2[$i];
                $storQues->answer = $request->input_2[$i];
                $storQues->marks = $request->marks[$i];
                $storQues->save();
            }
        }
        elseif($request->question_type==6){
            $count = count($request->input_1);
            

            for($i=0; $i<$count; $i++){
                $storQues = new StandaloneQuestions();
                $storQues->standalone_page_id = 1;
                $storQues->question_template_id = $request->question_type;
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
            

            for($i=0; $i<$count; $i++){
                $storQues = new StandaloneQuestions();
                $storQues->standalone_page_id = 1;
                $storQues->question_template_id = $request->question_type;
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
        
        return redirect()->route('standalone.questions.add', 1)->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }
}
