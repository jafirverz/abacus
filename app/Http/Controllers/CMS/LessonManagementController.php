<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\LessonManagement;
use App\QuestionTemplate;
use App\User;
use Illuminate\Http\Request;

class LessonManagementController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.LESSON_MANAGEMENT');
        $this->module = 'LESSON_MANAGEMENT';
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
        //
        $title = $this->title;
        $lessons = LessonManagement::paginate($this->pagination);

        return view('admin.master.lesson.index', compact('title', 'lessons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = $this->title;
        $questionTempleates = QuestionTemplate::where('id', 9)->get();
        $onlinestudents = User::where('user_type_id', 3)->get();
        return view('admin.master.lesson.create', compact('title', 'questionTempleates', 'onlinestudents'));
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
        $messages = [
            'amount.required_if' => 'This field is required',
        ];
        $request->validate([
            'title'  =>  'required',
        ], $messages);

        //dd($request->all());
        $lesson = New LessonManagement();
        $lesson->title = $request->title;
        $lesson->question_template_id = 9;
        $lesson->description = $request->description;
        $lesson->question_type = 3;
        $lesson->status = $request->status;
        $lesson->save();

        return redirect()->route('lessons.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LessonManagement  $lessonManagement
     * @return \Illuminate\Http\Response
     */
    public function show(LessonManagement $lessonManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LessonManagement  $lessonManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = $this->title;
        $lesson = LessonManagement::find($id);
        return view('admin.master.lesson.edit', compact('title', 'lesson'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LessonManagement  $lessonManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $messages = [
            'amount.required_if' => 'This field is required',
        ];
        $request->validate([
            'title'  =>  'required',
        ], $messages);

        //dd($request->all());
        $lesson = LessonManagement::where('id', $id)->first();
        $lesson->title = $request->title;
        $lesson->question_template_id = 9;
        $lesson->description = $request->description;
        $lesson->question_type = 3;
        $lesson->status = $request->status;
        $lesson->save();

        return redirect()->route('lessons.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LessonManagement  $lessonManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(LessonManagement $lessonManagement)
    {
        //
    }
}
