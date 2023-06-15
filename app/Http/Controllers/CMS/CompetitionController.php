<?php

namespace App\Http\Controllers\CMS;

use App\CategoryCompetition;
use App\Competition;
use App\CompetitionCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;

class CompetitionController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.COMPETITION');
        $this->module = 'COMPETITION';
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
        $competition = Competition::paginate($this->pagination);
        
        return view('admin.competition.index', compact('title', 'competition'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $competitionCategory = CompetitionCategory::get();
        // $worksheets = Worksheet::orderBy('id','desc')->get();
        return view('admin.competition.create', compact('title', 'competitionCategory'));
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
            // 'amount.required_if' => 'This field is required',
        ];
        $request->validate([
            'title'  =>  'required',
            'competition_type'  =>  'required',
            'category' => 'required',
            'date_of_competition'  =>  'required',
            'start_time_of_competition'  =>  'required',
            'end_time_of_competition'  =>  'required',
        ], $messages);

        $competition = new Competition();
        $competition->title = $request->title;
        $competition->date_of_competition = $request->date_of_competition;
        $competition->start_time_of_competition = $request->start_time_of_competition;
        $competition->end_time_of_competition = $request->end_time_of_competition;
        $competition->description = $request->description;
        $competition->competition_type = $request->competition_type;
        $competition->save();

        $competitionId = $competition->id;
        foreach($request->category as $cate){
            $catCompt = new CategoryCompetition();
            $catCompt->competition_id = $competitionId;
            $catCompt->category_id = $cate;
            $catCompt->save();
        }

        return redirect()->route('competition.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = $this->title;
        $competition = Competition::find($id);
        $competitionCategory = CompetitionCategory::get();
        $categoryCompetition = CategoryCompetition::where('competition_id', $id)->pluck('category_id')->toArray();
        return view('admin.competition.show', compact('title', 'competition', 'categoryCompetition','competitionCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->title;
        $competition = Competition::find($id);
        $competitionCategory = CompetitionCategory::get();
        $categoryCompetition = CategoryCompetition::where('competition_id', $id)->pluck('category_id')->toArray();
        
        return view('admin.competition.edit', compact('title', 'competition', 'categoryCompetition','competitionCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $messages = [
            // 'amount.required_if' => 'This field is required',
        ];
        $request->validate([
            'title'  =>  'required',
            'competition_type'  =>  'required',
            'category' => 'required',
            'date_of_competition'  =>  'required',
            'start_time_of_competition'  =>  'required',
            'end_time_of_competition'  =>  'required',
        ], $messages);

        $competition = Competition::where('id', $id)->first();
        $competition->title = $request->title;
        $competition->date_of_competition = $request->date_of_competition;
        $competition->start_time_of_competition = $request->start_time_of_competition;
        $competition->end_time_of_competition = $request->end_time_of_competition;
        $competition->description = $request->description;
        $competition->competition_type = $request->competition_type;
        $competition->save();

        $categoryCompetition = CategoryCompetition::where('competition_id', $id)->get();
        foreach($categoryCompetition as $deleteCategory){
            $deleteCategory->delete();
        }
        foreach($request->category as $cate){
            $catCompt = new CategoryCompetition();
            $catCompt->competition_id = $id;
            $catCompt->category_id = $cate;
            $catCompt->save();
        }

        return redirect()->route('competition.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        $competition = Competition::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $competition->appends('search', $search_term);
        }

        return view('admin.competition.index', compact('title', 'competition'));
    }
}
