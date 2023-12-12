<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\InstructorCalendar;
use App\User;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstructorCalendarController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.INSTRUCTOR_CALENDAR');
        $this->module = 'INSTRUCTOR_CALENDAR';
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
        $calendar = InstructorCalendar::orderBy('id', 'desc')->paginate($this->pagination);

        return view('admin.instructor-calendar.index', compact('title', 'calendar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.instructor-calendar.create', compact('title','instructors'));
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
            'teacher_id' => 'required',
            'full_name' => 'required',
            'start_date' => 'date|required',
            'start_time' => 'required',
            'note' => 'required',
            'reminder' => 'required',
        ]);
        if($request->teacher_id)
        {
            foreach($request->teacher_id as $key => $value)
            {
                $instructorCalendar = new InstructorCalendar();
                $instructorCalendar->full_name  = $request->full_name ?? NULL;
                $instructorCalendar->teacher_id  = $value;
                $instructorCalendar->start_date  = $request->start_date ?? NULL;
                $instructorCalendar->start_time  = $request->start_time ?? NULL;
                $instructorCalendar->note  = $request->note ?? NULL;
                $instructorCalendar->reminder  = $request->reminder ?? NULL;
                $instructorCalendar->save();
            }

        }


        return redirect()->route('instructor-calendar.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $calendar = InstructorCalendar::findorfail($id);
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.instructor-calendar.show', compact('title', 'calendar','instructors'));
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
        $calendar = InstructorCalendar::findorfail($id);
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.instructor-calendar.edit', compact('title', 'calendar','instructors'));
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
            'full_name' => 'required',
            'start_date' => 'date|required',
            'start_time' => 'required',
            'note' => 'required',
            'reminder' => 'required',
        ]);

        $instructorCalendar = InstructorCalendar::findorfail($id);
        $instructorCalendar->full_name  = $request->full_name ?? NULL;
        $instructorCalendar->teacher_id  = $request->teacher_id ?? NULL;
        $instructorCalendar->start_date  = $request->start_date ?? NULL;
        $instructorCalendar->start_time  = $request->start_time ?? NULL;
        $instructorCalendar->note  = $request->note ?? NULL;
        $instructorCalendar->reminder  = $request->reminder ?? NULL;
        $instructorCalendar->save();

        return redirect()->route('instructor-calendar.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        InstructorCalendar::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        //DB::enableQueryLog();
		$title = $this->title;
        $calendar = InstructorCalendar::join('users','users.id','instructor_calendars.teacher_id')->search($request->search)->select('instructor_calendars.*')->orderBy('instructor_calendars.id', 'asc')->paginate($this->systemSetting()->pagination);
       //dd(DB::getQueryLog());
        return view('admin.instructor-calendar.index', compact('title', 'calendar'));
    }
}
