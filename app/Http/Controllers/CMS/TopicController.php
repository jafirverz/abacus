<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Level;
use App\Topic;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.TOPIC');
        $this->module = 'TOPIC';
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
        $topic = Topic::paginate($this->pagination);

        return view('admin.master.topic.index', compact('title', 'topic'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $levels = Level::get();
        return view('admin.master.topic.create', compact('title','levels'));
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
            'level'  =>  'required',
            'title'  =>  'required|unique:topics,title|max:191',
        ]);

        $topic = new Topic();
        $topic->level_id = $request->level;
        $topic->title = $request->title;
        $topic->status = $request->status;
        $topic->save();

        return redirect()->route('topic.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $topic = Topic::find($id);

        return view('admin.master.topic.show', compact('title', 'topic'));
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
        $topic = Topic::findorfail($id);
        $levels = Level::get();
        return view('admin.master.topic.edit', compact('title', 'topic', 'levels'));
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
            'level'  =>  'required',
            'title'  =>  'required|unique:topics,title,'.$id.',id|max:191',
        ]);

        $topic = Topic::findorfail($id);
        $topic->level_id = $request->level;
        $topic->title = $request->title;
        $topic->status = $request->status;
        $topic->save();

        return redirect()->route('topic.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
        Topic::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module' =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        $topic = Topic::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $topic->appends('search', $search_term);
        }

        return view('admin.master.topic.index', compact('title', 'topic'));
    }
}
