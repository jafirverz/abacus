<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\MiscQuestion;
use App\Traits\SystemSettingTrait;
use App\Question;
use App\Worksheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class QuestionController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.QUESTION_MANAGEMENT');
        $this->module = 'QUESTION_MANAGEMENT';
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
        $title = $this->title;
        $questions = Question::orderBy('id','desc')->paginate($this->pagination);

        return view('admin.question.index', compact('title', 'questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $worksheets = Worksheet::orderBy('id','desc')->get();
        return view('admin.question.create', compact('title','worksheets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function find_worksheet(Request $request)
     {
        dd($request);
     }

    public function store(Request $request)
    {


        $fields = [
            'title' => 'required',
            'worksheet_id'  =>  'required',

        ];
        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $messages['worksheet.required'] = 'The worksheet field is required.';
        $request->validate($fields, $messages);

        if($request->question_type==5)
        {
            $json['input_1']=$request->input_1;
            $json['input_2']=$request->input_2;
            $json['input_3']=$request->input_3;
            $question = new Question();
            $question->title = $request->title;
            $question->worksheet_id = $request->worksheet_id;
            $question->question_type = $request->question_type;
            $question->json_question = json_encode($json);
            $question->created_at = Carbon::now();
            $question->save();
        }
        elseif($request->question_type==2 || $request->question_type==1 || $request->question_type==3)
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
            $question = new Question();
            $question->title = $request->title;
            $question->worksheet_id = $request->worksheet_id;
            $question->question_type = $request->question_type;
            $question->json_question = json_encode($json);
            $question->created_at = Carbon::now();
            $question->save();
        }
        elseif($request->question_type==4)
        {
            $json['input_1']=$request->input_1;
            $json['input_2']=$request->input_2;
            $question = new Question();
            $question->title = $request->title;
            $question->worksheet_id = $request->worksheet_id;
            $question->question_type = $request->question_type;
            $question->json_question = json_encode($json);
            $question->created_at = Carbon::now();
            $question->save();
        }
        elseif($request->question_type==6){
            $count = count($request->input_1);
            $question = new Question();
            $question->title = $request->title;
            $question->worksheet_id = $request->worksheet_id;
            $question->question_type = $request->question_type;
            // $question->json_question = json_encode($json);
            $question->created_at = Carbon::now();
            $question->save();

            for($i=0; $i<$count; $i++){
                $storQues = new MiscQuestion();
                $storQues->question_id = $question->id;
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
        
        return redirect()->route('question.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $question = Question::findorfail($id);
        $worksheets = Worksheet::orderBy('id','desc')->get();
        return view('admin.question.show', compact('title', 'question','worksheets'));
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
        $question = Question::findorfail($id);
        $worksheets = Worksheet::orderBy('id','desc')->get();
        return view('admin.question.edit', compact('title', 'question','worksheets'));
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
        $fields = [
            'title' => 'required',
            'worksheet_id'  =>  'required',

        ];
        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $messages['worksheet.required'] = 'The worksheet field is required.';
        $request->validate($fields, $messages);

        if($request->question_type==5)
        {
            $json['input_1']=$request->input_1;
            $json['input_2']=$request->input_2;
            $json['input_3']=$request->input_3;
            $question = Question::find($id);
            $question->title = $request->title;
            $question->worksheet_id = $request->worksheet_id;
            $question->json_question = json_encode($json);
            $question->updated_at = Carbon::now();
            $question->save();
        }
        elseif($request->question_type==2 || $request->question_type==1 || $request->question_type==3)
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
            $question = Question::find($id);
            $question->title = $request->title;
            $question->worksheet_id = $request->worksheet_id;
            $question->json_question = json_encode($json);
            $question->updated_at = Carbon::now();
            $question->save();
        }
        elseif($request->question_type==4)
        {
            $json['input_1']=$request->input_1;
            $json['input_2']=$request->input_2;
            $question = Question::find($id);
            $question->title = $request->title;
            $question->worksheet_id = $request->worksheet_id;
            $question->json_question = json_encode($json);
            $question->updated_at = Carbon::now();
            $question->save();
        }
        elseif($request->question_type==6){
            $count = count($request->input_1);
            $question = Question::find($id);
            $question->title = $request->title;
            // $question->worksheet_id = $request->worksheet_id;
            // $question->json_question = json_encode($json);
            $question->updated_at = Carbon::now();
            $question->save();

            $storQues = MiscQuestion::where('question_id', $id)->get();
            foreach($storQues as $quess){
                $quess->delete();
            }

            for($i=0; $i<$count; $i++){
                $storQues = new MiscQuestion();
                $storQues->question_id = $question->id;
                $storQues->question_1 = $request->input_1[$i];
                $storQues->question_2 = $request->input_3[$i];
                $storQues->symbol = $request->input_2[$i];
                $storQues->answer = $request->answer[$i];
                $storQues->marks = $request->marks[$i];
                $storQues->save();
            }
        }

        //dd($question);
        

        

        return redirect()->route('question.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = explode(',', $request->multiple_delete);
        Question::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;

        $title = $this->title;
        $questions = Question::join('worksheets','worksheets.id','questions.worksheet_id')->select('questions.*')->search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $questions->appends('search', $search_term);
        }
        //dd($customer);
        return view('admin.question.index', compact('title', 'questions'));
    }
}
