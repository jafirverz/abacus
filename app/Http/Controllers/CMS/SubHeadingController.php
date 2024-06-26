<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\SubHeading;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubHeadingController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.SUB_HEADING');
        $this->module = 'SUB_HEADING';
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
        $topic = SubHeading::paginate($this->pagination);

        return view('admin.master.sub-heading.index', compact('title', 'topic'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        return view('admin.master.sub-heading.create', compact('title'));
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
            'title'  =>  'required|unique:sub_headings,title|max:191',
        ]);

        $topic = new SubHeading();
        $topic->title = $request->title;
        $topic->save();

        return redirect()->route('sub-heading.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $topic = SubHeading::find($id);

        return view('admin.master.sub-heading.show', compact('title', 'topic'));
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
        $topic = SubHeading::findorfail($id);
        return view('admin.master.sub-heading.edit', compact('title', 'topic'));
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
            'title'  =>  'required|unique:learning_locations,title,'.$id.',id|max:191',
        ]);

        $topic = SubHeading::findorfail($id);
        $topic->title = $request->title;
        $topic->save();

        return redirect()->route('sub-heading.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
        SubHeading::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module' =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        $topic = SubHeading::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $topic->appends('search', $search_term);
        }

        return view('admin.master.sub-heading.index', compact('title', 'topic'));
    }
}
