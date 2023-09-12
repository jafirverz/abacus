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
        $announcements = Announcement::orderBy('id', 'asc')->paginate($this->pagination);

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
        $announcement->title = $request->title ?? Null;
        $announcement->announcement_date = $request->announcement_date ?? Null;
        if ($request->hasFile('image')) {
            $announcement->image = uploadPicture($request->file('image'), $this->title);
        }
        if ($request->hasfile('attachments')) {
            $i=0;
            foreach ($request->file('attachments') as $file) {
                $i++;
                $today=strtotime(date('Y-m-d H:i:s'));
                $name = $today.$i.'_'.$file->getClientOriginalName();
                $file->move(public_path() . '/upload-file/', $name);
                $data[] = $name;
            }

            $announcement->attachments = json_encode($data);
        }
        $announcement->description = $request->description ?? Null;
        $announcement->function = $request->function ?? Null;
        $announcement->teacher_id = $request->teacher_id ?? Null;
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
            'image'  =>  'nullable|mimes:jpeg,jpg,png,gif,doc,docx,pdf',
            'announcement_date'  =>  'required|date',
            'teacher_id'  =>  'required',
        ]);

        $announcement = Announcement::findorfail($id);
        $announcement->title = $request->title ?? Null;
        $announcement->announcement_date = $request->announcement_date ?? Null;
        if ($request->hasFile('image')) {
            $announcement->image = uploadPicture($request->file('image'), $this->title);
        }
        if ($request->hasfile('attachments')) {
            $input_1_old=$request->input_1_old;
            $i=0;
            foreach ($request->file('attachments') as $file) {
                $i++;
                $today=strtotime(date('Y-m-d H:i:s'));
                $name = $today.$i.'_'.$file->getClientOriginalName();
                $file->move(public_path() . '/upload-file/', $name);
                if(isset($input_1_old))
                {
                    array_push($input_1_old,$name);
                }
                else
                {
                    $input_1_old[]=$name;
                }

            }
            $announcement->attachments = json_encode($input_1_old);
        }
        else
        {
            $input_1_old=$request->input_1_old;
            $announcement->attachments = json_encode($input_1_old);
        }
        $announcement->description = $request->description ?? Null;
        $announcement->function = $request->function ?? Null;
        $announcement->teacher_id = $request->teacher_id ?? Null;
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
        $announcements = Announcement::join('users','users.id','announcements.teacher_id')->select('announcements.*')->search($request->search)->orderBy('announcements.id', 'asc')->paginate($this->systemSetting()->pagination);
       // dd(DB::getQueryLog());
        return view('admin.announcement.index', compact('title', 'announcements'));
    }
}
