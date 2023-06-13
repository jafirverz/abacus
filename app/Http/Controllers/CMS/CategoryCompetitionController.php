<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\CompetitionCategory;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class CategoryCompetitionController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.CATEGORY_COMPETITION');
        $this->module = 'CATEGORY_COMPETITION';
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
        $category = CompetitionCategory::paginate($this->pagination);

        return view('admin.master.category-competition.index', compact('title', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        return view('admin.master.category-competition.create', compact('title'));
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
            'category_name'  =>  'required|max:191',
        ]);

        $category = new CompetitionCategory();

        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('category-competition.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $category = CompetitionCategory::find($id);

        return view('admin.master.category-competition.show', compact('title', 'category'));
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
        $category = CompetitionCategory::findorfail($id);

        return view('admin.master.category-competition.edit', compact('title', 'category'));
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
            'category_name'  =>  'required|max:191',
        ]);

        $category = CompetitionCategory::findorfail($id);

        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('category-competition.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
        CompetitionCategory::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        $category = CompetitionCategory::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $category->appends('search', $search_term);
        }

        return view('admin.master.category-competition.index', compact('title', 'category'));
    }
}
