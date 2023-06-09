<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Grade;
use App\GradeType;
use App\User;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.GRADE');
        $this->module = 'GRADE';
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
        $grades = Grade::paginate($this->pagination);
        return view('admin.grade.index', compact('title', 'grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $grade = Grade::orderBy('title', 'asc')->get();
        $grade_types = GradeType::orderBy('id', 'asc')->get();
        return view('admin.grade.create', compact('title', 'grade','grade_types'));

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
            'grade_type_id'  =>  'required',
        ]);

        $grade = new Grade;
        $grade->title = $request->title;
        $grade->grade_type_id = $request->grade_type_id;
        $grade->created_at = Carbon::now();
        $grade->save();

        return redirect()->route('grade.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $grade = Grade::findorfail($id);
        $grade_types = GradeType::orderBy('id', 'asc')->get();
        return view('admin.grade.show', compact('title', 'grade','grade_types'));
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
        $grade = Grade::findorfail($id);
        $grade_types = GradeType::orderBy('id', 'asc')->get();
        return view('admin.grade.edit', compact('title', 'grade','grade_types'));

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
            'grade_type_id'  =>  'required',
        ]);

        $grade = Grade::findorfail($id);
        $grade->title = $request->title;
        $grade->grade_type_id = $request->grade_type_id;
        $grade->updated_at = Carbon::now();
        $grade->save();

        return redirect()->route('grade.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        grade::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        //DB::enableQueryLog();
		    $title = $this->title;
        $grades = Grade::search($request->search)->join('grade_types','grade_types.id','grades.grade_type_id')->select('grades.*')->paginate($this->systemSetting()->pagination);

       // dd(DB::getQueryLog());
        return view('admin.grade.index', compact('title', 'grades'));

    }
}
