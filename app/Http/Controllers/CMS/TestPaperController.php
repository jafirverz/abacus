<?php

namespace App\Http\Controllers\CMS;

use App\TestPaper;
use App\TestPaperDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;

class TestPaperController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.TEST_PAPER');
        $this->module = 'TEST_PAPER';
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
        $testPaper = TestPaper::paginate($this->pagination);
        return view('admin.test-paper.index', compact('title', 'testPaper'));
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
        $testPaper = TestPaper::get();
        return view('admin.test-paper.create', compact('title', 'testPaper'));
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
        $paper_id  = $request->paper_id ;
        $question_template_id = $request->question_template_id;
        if($question_template_id == 4 || $question_template_id == 5){
            $count = count($request->input_1);
            for($i=0; $i<$count; $i++){
                $testPaperDetail = new TestPaperDetail();
                $testPaperDetail->paper_id  = $paper_id ;
                $testPaperDetail->question = $request->input_1[$i];
                $testPaperDetail->save();
            }
        }
        elseif($question_template_id == 1)
        {

            if ($request->hasfile('input_1')) {
                $i = 0;
                foreach ($request->file('input_1') as $file) {

                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/upload-file/', $name);
                    $testPaperDetail = new TestPaperDetail();
                    $testPaperDetail->paper_id  = $paper_id ;
                    $testPaperDetail->question = $name;
                    $testPaperDetail->save();
                    $i++;
                }

                // $json['input_1']=$data;
                // $json['input_2']=$request->input_2;
            }
        }

        return redirect()->route('comp-questions.index')->with('success', __('constant.CREATED', ['module' => $this->title]));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CompetitionQuestions  $competitionQuestions
     * @return \Illuminate\Http\Response
     */
    public function show()
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
        $testPaper = TestPaper::where('id', $id)->first();
        $testPaperDetail = TestPaperDetail::where('competition_paper_id', $id)->get();
        return view('admin.test-paper.edit', compact('title', 'testPaper', 'testPaperDetail'));
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
        $paper_id  = $request->paper_id ;
        $question_template_id = $request->question_template_id;
        $testPaperDetail = TestPaperDetail::where('paper_id', $paper_id)->get();
        foreach($testPaperDetail as $detail){
            $detail->delete();
        }
        if($question_template_id == 4 || $question_template_id == 5){
            $count = count($request->input_1);
            for($i=0; $i<$count; $i++){
                $testPaperDetail = new TestPaperDetail();
                $testPaperDetail->paper_id  = $paper_id ;
                $testPaperDetail->question = $request->input_1[$i];
                $testPaperDetail->save();
            }
        }
        elseif($question_template_id == 1)
        {

            if ($request->hasfile('input_1')) {
                $i = 0;
                foreach ($request->file('input_1') as $file) {

                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/upload-file/', $name);
                    $testPaperDetail = new TestPaperDetail();
                    $testPaperDetail->paper_id  = $paper_id ;
                    $testPaperDetail->question = $name;
                    $testPaperDetail->save();
                }

            }
        }


        return redirect()->route('comp-questions.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
