<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Level;
use App\Topic;
use App\Traits\SystemSettingTrait;
use App\Worksheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $worksheet = Worksheet::paginate($this->pagination);

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
        return view('admin.master.worksheet.create', compact('title','worksheet', 'levels', 'topics'));
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
