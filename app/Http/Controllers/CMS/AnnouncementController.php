<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Announcement;
use App\User;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.ANNOUNCEMENT');
        $this->module = 'ANNOUNCEMENT';
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
        $announcements = Announcement::orderBy('view_order', 'asc')->paginate($this->pagination);

        return view('admin.announcement.index', compact('title', 'announcements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $announcement = Announcement::orderBy('title', 'asc')->get();
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.announcement.create', compact('title', 'announcement','instructors'
    ));
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
            'announcement_date'  =>  'required|date',
            'teacher_id'  =>  'required',
        ]);

        $announcement = new Announcement;
        $announcement->title = $request->title;
        $announcement->announcement_date = $request->announcement_date;
        $announcement->description = $request->description;
        $announcement->teacher_id = $request->teacher_id;
        $announcement->created_at = Carbon::now();
        $announcement->save();

        return redirect()->route('announcement.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $announcement = Announcement::findorfail($id);
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.announcement.show', compact('title', 'announcement','instructors'));
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
        $announcement = Announcement::findorfail($id);
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.announcement.edit', compact('title', 'announcement','instructors'));
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

        $announcement = Announcement::findorfail($id);
        $announcement->title = $request->title;
        $announcement->announcement_date = $request->announcement_date;
        $announcement->description = $request->description;
        $announcement->teacher_id = $request->teacher_id;
        $announcement->updated_at = Carbon::now();
        $announcement->save();

        return redirect()->route('announcement.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        Announcement::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        //DB::enableQueryLog();
		$title = $this->title;
        $announcements = Announcement::search($request->search)->orderBy('view_order', 'asc')->paginate($this->systemSetting()->pagination);
       // dd(DB::getQueryLog());
        return view('admin.announcement.index', compact('title', 'announcements'));
    }
}
