<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\User;
use App\GradingExam;
use App\Competition;
use App\CompetitionStudentResult;
use App\GradingStudentResults;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AchievementController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.ACHIEVEMENT');
        $this->module = 'ACHIEVEMENT';
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
        $achievements = CompetitionStudentResult::get();
        $competition = Competition::get();
        $actualCompetitionPaperSubted = CompetitionStudentResult::orderBy('id', 'desc')->get();
        $gradingExamResult = GradingStudentResults::orderBy('id', 'desc')->get();
        $achievements = $actualCompetitionPaperSubted->merge($gradingExamResult)->sortByDesc('created_at')->paginate(10);
        return view('admin.achievement.index', compact('title','achievements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;

        $grading = GradingExam::get();
        $competition = Competition::get();
        return view('admin.achievement.create', compact('title','grading','competition'));

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
            'result'  =>  'required',
            'rank'  =>  'required',
        ]);


        if($request->type==2)
        {
            $competitionStudentResult = new CompetitionStudentResult();
            $competitionStudentResult->competition_id  = $request->event ?? null;
            $competitionStudentResult->user_id  = $request->user_id ?? null;
            $competitionStudentResult->category_id  = $request->category ?? null;
            $competitionStudentResult->result = $request->result ?? null;
            $competitionStudentResult->rank = $request->rank ?? null;
            $competitionStudentResult->save();
        }
        else
        {
            $gradingStudentResults = new GradingStudentResults();
            $gradingStudentResults->grading_id   = $request->event ?? null;
            $gradingStudentResults->user_id  = $request->user_id ?? null;
            $gradingStudentResults->result = $request->result ?? null;
            $gradingStudentResults->rank = $request->rank ?? null;
            $gradingStudentResults->save();
        }
        return redirect()->route('achievement.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $competition = CompetitionStudentResult::find();
        return view('admin.achievement.show', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$type)
    {
        $title = $this->title;
        $grading = GradingExam::get();
        $competition = Competition::get();
        if($type==2)
        {
            $event = CompetitionStudentResult::find($id);
        }
        else
        {
            $event = GradingStudentResults::find($id);
        }

        return view('admin.achievement.edit', compact('title','grading','competition','event','type'));

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
            'result'  =>  'required',
            'rank'  =>  'required',
        ]);

        if($request->type==2)
        {
        $competitionStudentResult = CompetitionStudentResult::find($id);
        $competitionStudentResult->result = $request->result ?? null;
        $competitionStudentResult->rank = $request->rank ?? null;
        $competitionStudentResult->save();
        }
        else
        {
            $gradingStudentResults = GradingStudentResults::find($id);;
            $gradingStudentResults->result = $request->result ?? null;
            $gradingStudentResults->rank = $request->rank ?? null;
            $gradingStudentResults->save();
        }

        return redirect()->route('achievement.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id,$type)
    {
        if($type==2)
        {
            CompetitionStudentResult::destroy($id);
        }
        else
        {
            GradingStudentResults::destroy($id);
        }
        //

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        //DB::enableQueryLog();
		$title = $this->title;
        //$grades = Grade::search($request->search)->join('grade_types','grade_types.id','grades.grade_type_id')->select('grades.*')->paginate($this->systemSetting()->pagination);

       // dd(DB::getQueryLog());
        return view('admin.achievement.index', compact('title'));

    }
}
