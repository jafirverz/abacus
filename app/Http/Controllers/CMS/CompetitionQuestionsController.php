<?php

namespace App\Http\Controllers\CMS;

use App\CompetitionPaper;
use App\CompetitionQuestions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;

class CompetitionQuestionsController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.COMPETITIONQUESTIONS');
        $this->module = 'COMPETITIONQUESTIONS';
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
        // $competitionQuestions = CompetitionQuestions::with('comp_paper')->groupBy('competition_paper_id')->paginate($this->pagination);
        $competitionPaper = CompetitionPaper::whereHas('comp_ques')->paginate($this->pagination);
        return view('admin.competition_question.index', compact('title', 'competitionPaper'));
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
        $papers = CompetitionPaper::get();
        return view('admin.competition_question.create', compact('title', 'papers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $competition_paper_id = $request->paperId;
        $question_template_id = $request->question_template_id;
        if($question_template_id == 4){
            $count = count($request->input_1);
            for($i=0; $i<$count; $i++){
                $storQues = new CompetitionQuestions();
                $storQues->competition_paper_id = $competition_paper_id;
                $storQues->question_1 = $request->input_1[$i];
                $storQues->question_2 = $request->input_3[$i];
                $storQues->symbol = $request->input_2[$i];
                $storQues->answer = $request->answer[$i];
                $storQues->save();
            }
        }
        return redirect()->route('competition-questions.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CompetitionQuestions  $competitionQuestions
     * @return \Illuminate\Http\Response
     */
    public function show(CompetitionQuestions $competitionQuestions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CompetitionQuestions  $competitionQuestions
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = $this->title;
        $papers = CompetitionPaper::get();
        $competitionPaper = CompetitionPaper::where('id', $id)->first();
        $compQues = CompetitionQuestions::where('competition_paper_id', $id)->get();
        return view('admin.competition_question.edit', compact('title', 'competitionPaper', 'compQues', 'papers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompetitionQuestions  $competitionQuestions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request->all());
        $competition_paper_id = $id;
        $question_template_id = $request->question_template_id;
        if($question_template_id == 4){
            $count = count($request->input_1);
            $storQues = CompetitionQuestions::where('competition_paper_id', $competition_paper_id)->get();
            foreach($storQues as $quess){
                $quess->delete();
            }
            for($i=0; $i<$count; $i++){
                $storQues = new CompetitionQuestions();
                $storQues->competition_paper_id = $competition_paper_id;
                $storQues->question_1 = $request->input_1[$i];
                $storQues->question_2 = $request->input_3[$i];
                $storQues->symbol = $request->input_2[$i];
                $storQues->answer = $request->answer[$i];
                $storQues->save();
            }
        }
        return redirect()->route('competition-questions.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CompetitionQuestions  $competitionQuestions
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompetitionQuestions $competitionQuestions)
    {
        //
    }
}
