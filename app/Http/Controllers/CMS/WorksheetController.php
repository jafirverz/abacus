<?php

namespace App\Http\Controllers\CMS;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Level;
use App\LevelTopic;
use App\MiscQuestion;
use App\Question;
use App\Topic;
use App\Traits\SystemSettingTrait;
use App\Worksheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\QuestionTemplate;
use App\User;

class WorksheetController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.WORKSHEET');
        $this->module = 'WORKSHEET';
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
        $worksheet = Worksheet::orderBy('title', 'asc')->paginate($this->pagination);
        $questionTemplate = QuestionTemplate::whereIn('id', [1,2,3,4,5,6,7,10,11])->get();

        return view('admin.master.worksheet.index', compact('title', 'worksheet', 'questionTemplate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $worksheet = Worksheet::get();
        $levels = Level::where('status', 1)->get();
        $topics = Topic::get();
        $users = User::get();
        $franchiseAccounts = Admin::where('admin_role', 2)->get();
        $questionTempleates = QuestionTemplate::whereIn('id', [1,2,3,4,5,6,7,10,11])->get();
        return view('admin.master.worksheet.create', compact('title','worksheet', 'levels', 'topics', 'questionTempleates', 'users', 'franchiseAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $messages = [
            'amount.required_if' => 'This field is required',
        ];
        $request->validate([
            'level'  =>  'required|array|min:1',
            'title'  =>  'required',
            'fee'  =>  'required',
            //'amount' => 'required_if:fee,2',
           'questiontemplate'  =>  'required',
            //'stopwatch'  =>  'required',
            //'presettiming'  =>  'required',
            //'questiontype' => 'required',
        ], $messages);

        //dd($request->all());
        $worksheet = New Worksheet();
//        $worksheet->topic = $request->topic;
        $worksheet->title = $request->title;
        $worksheet->type = $request->fee;
        //$worksheet->amount = $request->amount;
        $worksheet->question_template_id = $request->questiontemplate;
        $worksheet->stopwatch_timing = $request->stopwatch;
        $worksheet->preset_timing = $request->presettiming;
        $worksheet->description = $request->description;
        $worksheet->question_type = $request->questiontype ?? null;
        $worksheet->status = $request->status;
        $worksheet->timing = $request->timing;
        $worksheet->account_accessibility = $request->account_accessibility;
        $worksheet->save();

        $worksheetId = $worksheet->id;


        foreach ($request->level as $topic){
            $levelTopic = new LevelTopic();
            // $topicLevel = Topic::where('id', $topic)->first();
            // $level = Level::where('id', $topic->id)->first();
            $levelTopic->worksheet_id  = $worksheetId;
            $levelTopic->level_id  = $topic;
            // $levelTopic->topic_id  = $topic;
            $levelTopic->save();
        }

        return redirect()->route('worksheet.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $worksheet = Worksheet::find($id);
        $levelTopic = LevelTopic::where('worksheet_id', $id)->pluck('level_id')->toArray();
        $topics = Level::whereIn('id', $levelTopic)->pluck('title')->toArray();
        return view('admin.master.worksheet.show', compact('title', 'worksheet', 'topics'));
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
        $worksheet = Worksheet::find($id);
        $levels = Level::where('status', 1)->get();
        $topics = Topic::get();
        $questionTempleates = QuestionTemplate::whereIn('id', [1,2,3,4,5,6,7,10,11])->get();
        $levelTopic = LevelTopic::where('worksheet_id', $id)->pluck('level_id')->toArray();
        return view('admin.master.worksheet.edit', compact('title', 'worksheet', 'levels', 'topics', 'levelTopic', 'questionTempleates'));
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
        $messages = [
            'amount.required_if' => 'This field is required',
        ];
        $request->validate([
            'level'  =>  'required|array|min:1',
            'title'  =>  'required',
            'fee'  =>  'required',
            //'amount' => 'required_if:fee,2',
            // 'questiontemplate'  =>  'required',
            'stopwatch'  =>  'required',
            'presettiming'  =>  'required',
            //'questiontype' => 'required',
        ], $messages);

        //dd($request->all());
        $worksheet = Worksheet::findorfail($id);
//        $worksheet->topic = $request->topic;
        $worksheet->title = $request->title;
        $worksheet->type = $request->fee;
        //$worksheet->amount = $request->amount;
        // $worksheet->question_template_id = $request->questiontemplate;
        $worksheet->stopwatch_timing = $request->stopwatch;
        $worksheet->preset_timing = $request->presettiming;
        $worksheet->description = $request->description;
        $worksheet->question_type = $request->questiontype ?? null;
        $worksheet->status = $request->status;
        $worksheet->account_accessibility = $request->account_accessibility;
        $worksheet->timing = $request->timing;
        $worksheet->save();

        $worksheetId = $worksheet->id;
        $levelTopic = LevelTopic::where('worksheet_id', $id)->get();
        foreach ($levelTopic as $deleteleveltopic){
            $deleteleveltopic->delete();
        }


        foreach ($request->level as $topic){
            $levelTopic = new LevelTopic();
            // $topicLevel = Topic::where('id', $topic)->first();
            // $level = Level::where('id', $topicLevel->level_id)->first();
            $levelTopic->worksheet_id  = $worksheetId;
            $levelTopic->level_id  = $topic;
            // $levelTopic->topic_id  = $topic;
            $levelTopic->save();
        }

        return redirect()->route('worksheet.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // dd($request->multiple_delete);
        $worksheetIds = explode(',', $request->multiple_delete);
        $levelTopics = LevelTopic::whereIn('worksheet_id', $worksheetIds)->get();
        foreach($levelTopics as $levelTopic){
            $levelTopic->delete();
        }

        $questions = Question::whereIn('worksheet_id', $worksheetIds)->get();
        foreach($questions as $question){
            $miscQuestions = MiscQuestion::where('question_id', $question->id)->get();
            foreach($miscQuestions as $miscQuestion){
                $miscQuestion->delete();
            }
            $question->delete();
        }


        $worksheets = Worksheet::whereIn('id', $worksheetIds)->get();
        // dd($worksheetIds);
        foreach($worksheets as $worksheet){
            $worksheet->delete();
        }
        return redirect()->route('worksheet.index')->with('success', __('constant.DELETED', ['module' => $this->title]));
    }

    public function search(Request $request)
    {
        // dd($request->all());
        $questionTemplate = QuestionTemplate::whereIn('id', [1,2,3,4,5,6,7,8,10])->get();
        if($request->qId){
            $title = $this->title;
            $worksheet = Worksheet::where('question_template_id', $request->qId)->paginate($this->pagination);
        }else{
            $search_term = $request->search;
            $title = $this->title;
            $worksheet = Worksheet::search($search_term)->paginate($this->pagination);
            if ($search_term) {
                $worksheet->appends('search', $search_term);
            }
        }
        

        return view('admin.master.worksheet.index', compact('title', 'worksheet', 'questionTemplate'));
    }

    public function questions($id)
    {
        $title = 'Worksheet Question';
        $worksheet = Worksheet::where('id', $id)->first();
        $worksheetId = $id;
        $questionTemplateId = $worksheet->question_template_id;
        $questions = Question::where('worksheet_id', $id)->orderBy('id','desc')->paginate($this->pagination);
        return view('admin.master.worksheet.qestions', compact('title', 'questions', 'worksheetId', 'questionTemplateId', 'worksheet'));
    }

    public function questionCreate($wId = null, $qId = null)
    {
        
        $title = 'Worksheet Question Add';
        return view('admin.master.worksheet.qestions_create', compact('title', 'wId', 'qId'));
    }

    public function questionsEdit($wId = null, $qid = null)
    {
        // dd($qid);
        $title = 'Worksheet Question Edit';
        $question = Question::findorfail($qid);
        // $worksheets = Worksheet::orderBy('id','desc')->get();
        return view('admin.master.worksheet.question_edit', compact('title', 'question', 'qid', 'wId'));

    }

    public function questionsShow($wId = null, $qid = null)
    {
        // dd($qid);
        $title = 'Worksheet Question Show';
        $question = Question::findorfail($qid);
        $worksheets = Worksheet::orderBy('id','desc')->get();
        // $worksheets = Worksheet::orderBy('id','desc')->get();
        return view('admin.master.worksheet.question_show', compact('title', 'question', 'qid', 'wId'));

    }
}
