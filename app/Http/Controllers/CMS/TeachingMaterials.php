<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\TeachingMaterials;
use App\User;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeachingMaterials extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.TEACHING_MATERIALS');
        $this->module = 'TEACHING_MATERIALS';
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
        $materials = TeachingMaterials::orderBy('view_order', 'asc')->paginate($this->pagination);

        return view('admin.materials.index', compact('title', 'materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $materials = TeachingMaterials::orderBy('title', 'asc')->get();
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.materials.create', compact('title', 'materials','instructors'));
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
            'image'  =>  'required|mimes:jpeg,jpg,png,gif,doc,docx,pdf',
            'teacher_id'  =>  'required',
        ]);

        $announcement = new Announcement;
        $announcement->title = $request->title;
        $announcement->created_at = Carbon::now();
        $announcement->save();

        return redirect()->route('teaching-materials.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $announcement = TeachingMaterials::findorfail($id);
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.materials.show', compact('title', 'announcement','instructors'));
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
        $announcement = TeachingMaterials::findorfail($id);
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.materials.edit', compact('title', 'announcement','instructors'));
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
            'view_order'   =>  'required|numeric',
        ]);

        $materials = TeachingMaterials::findorfail($id);
        $materials->title = $request->title;
        $materials->updated_at = Carbon::now();
        $materials->save();

        return redirect()->route('teaching-materials.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        TeachingMaterials::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        //DB::enableQueryLog();
		$title = $this->title;
        $materials = TeachingMaterials::search($request->search)->orderBy('view_order', 'asc')->paginate($this->systemSetting()->pagination);
       // dd(DB::getQueryLog());
        return view('admin.materials.index', compact('title', 'materials'));
    }
}
