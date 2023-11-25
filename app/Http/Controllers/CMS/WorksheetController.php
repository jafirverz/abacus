<?php

namespace App\Http\Controllers\CMS;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Level;
use App\LevelTopic;
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
        $worksheet = Worksheet::orderBy('id', 'desc')->paginate($this->pagination);

        return view('admin.master.worksheet.index', compact('title', 'worksheet'));
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
        $levels = Level::get();
        $topics = Topic::get();
        $users = User::get();
        $franchiseAccounts = Admin::where('admin_role', 2)->get();
        $questionTempleates = QuestionTemplate::get();
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
            'amount' => 'required_if:fee,2',
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
        $worksheet->amount = $request->amount;
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
        $levelTopic = LevelTopic::where('worksheet_id', $id)->pluck('topic_id')->toArray();
        $topics = Topic::whereIn('id', $levelTopic)->pluck('title')->toArray();
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
        $levels = Level::get();
        $topics = Topic::get();
        $questionTempleates = QuestionTemplate::get();
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
            'amount' => 'required_if:fee,2',
            'questiontemplate'  =>  'required',
            'stopwatch'  =>  'required',
            'presettiming'  =>  'required',
            //'questiontype' => 'required',
        ], $messages);

        //dd($request->all());
        $worksheet = Worksheet::findorfail($id);
//        $worksheet->topic = $request->topic;
        $worksheet->title = $request->title;
        $worksheet->type = $request->fee;
        $worksheet->amount = $request->amount;
        $worksheet->question_template_id = $request->questiontemplate;
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
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        $worksheet = Worksheet::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $worksheet->appends('search', $search_term);
        }

        return view('admin.master.worksheet.index', compact('title', 'worksheet'));
    }
}
