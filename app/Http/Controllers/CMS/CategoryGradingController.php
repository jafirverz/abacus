<?php

namespace App\Http\Controllers\CMS;
use App\GradeType;
use App\Http\Controllers\Controller;
use App\GradingCategory;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class CategoryGradingController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.GRADE');
        $this->module = 'CATEGORY_GRADING';
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
        $category = GradingCategory::orderBy('id', 'desc')->paginate($this->pagination);

        return view('admin.master.category-grading.index', compact('title', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $grade_types = GradeType::orderBy('id', 'asc')->get();
        return view('admin.master.category-grading.create', compact('title','grade_types'));
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
            'grade_type_id'  =>  'required|max:191',
        ]);

        $category = new GradingCategory();
        $category->category_name = $request->category_name;
        $category->grade_type_id = $request->grade_type_id;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('category-grading.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $category = GradingCategory::find($id);

        return view('admin.master.category-grading.show', compact('title', 'category'));
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
        $category = GradingCategory::findorfail($id);
        $grade_types = GradeType::orderBy('id', 'asc')->get();
        return view('admin.master.category-grading.edit', compact('title', 'category','grade_types'));
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
            'grade_type_id'  =>  'required|max:191',
        ]);

        $category = GradingCategory::findorfail($id);
        $category->category_name = $request->category_name;
        $category->grade_type_id = $request->grade_type_id;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('category-grading.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = explode(',', $request->multiple_delete);

        foreach($ids as $id){
            $compCat = GradingCategory::where('id', $id)->first();
            $compCat->delete();
        }
        // GradingCategory::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        $category = GradingCategory::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $category->appends('search', $search_term);
        }

        return view('admin.master.category-grading.index', compact('title', 'category'));
    }
}
