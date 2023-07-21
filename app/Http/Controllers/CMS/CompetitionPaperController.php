<?php

namespace App\Http\Controllers\CMS;

use App\CategoryCompetition;
use App\Competition;
use App\CompetitionCategory;
use App\CompetitionPaper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaperCategory;
use App\QuestionTemplate;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;

class CompetitionPaperController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.COMPETITIONPAPER');
        $this->module = 'COMPETITIONPAPER';
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
        $competitionPaper = CompetitionPaper::paginate($this->pagination);
        
        return view('admin.competition_paper.index', compact('title', 'competitionPaper'));
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
        $questionTempleates = QuestionTemplate::get();
        $competitionCategory = CompetitionCategory::get();
        $competition = Competition::get();
        // $competitionCategory = CompetitionPaper::get();
        // $worksheets = Worksheet::orderBy('id','desc')->get();
        return view('admin.competition_paper.create', compact('title', 'questionTempleates', 'competition', 'competitionCategory'));
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
            'questiontemplate.required_if' => 'This field is required',
        ];
        $request->validate([
            'title'  =>  'required',
            'category'  =>  'required',
            'competition' => 'required',
            'price'  =>  'required_if:competionT,2',
            'pdf_upload'  =>  'required_if:competionT,2',
            'questiontemplate'  =>  'required_if:competionT,1',
            'time'  =>  'required_if:competionT,1',
            'question_type'  =>  'required_if:competionT,1',
            'paper_type'  =>  'required',
        ], $messages);

        if ($request->hasfile('pdf_upload')) {
            $file = $request->file('pdf_upload');
            $name = $file->getClientOriginalName();
            $file->move(public_path() . '/upload-file/', $name);

            // $json['input_1']=$data;
            // $json['input_2']=$request->input_2;
        }

        $competitionPaper = new CompetitionPaper();
        $competitionPaper->title = $request->title;
        $competitionPaper->question_template_id = $request->questiontemplate;
        $competitionPaper->competition_controller_id = $request->competition;
        $competitionPaper->description = $request->description;
        $competitionPaper->time = $request->time;
        $competitionPaper->price = $request->price;
        $competitionPaper->pdf_file = $name??null;
        $competitionPaper->type = $request->question_type;
        $competitionPaper->paper_type = $request->paper_type;
        $competitionPaper->timer = $request->timer;
        $competitionPaper->category_id = $request->category;
        $competitionPaper->save();

        // $competitionPaperId = $competitionPaper->id;
        // foreach($request->category as $cate){
        //     $catCompt = new PaperCategory();
        //     $catCompt->competition_paper_id = $competitionPaperId;
        //     $catCompt->competition_id = $request->competition;
        //     $catCompt->category_id = $cate;
        //     $catCompt->save();
        // }

        return redirect()->route('papers.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CompetitionPaper  $competitionPaper
     * @return \Illuminate\Http\Response
     */
    public function show(CompetitionPaper $competitionPaper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CompetitionPaper  $competitionPaper
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = $this->title;
        $competitionPaper = CompetitionPaper::with('comp_contro')->find($id);
        $questionTempleates = QuestionTemplate::get();
        $competition = Competition::get();

        $catComp = CategoryCompetition::where('competition_id', $competitionPaper->competition_controller_id)->get();
        //dd($catComp);
        // $categoryCompetition1 = PaperCategory::where('competition_paper_id', $id)->pluck('competition_id')->toArray();
        // $catComp = CategoryCompetition::whereIn('competition_id', $categoryCompetition1)->pluck('category_id')->toArray();
        // $competitionCategory = CompetitionCategory::whereIn('id', $catComp)->get();

        // $categoryCompetition = PaperCategory::where('competition_paper_id', $id)->pluck('category_id')->toArray();
        

        return view('admin.competition_paper.edit', compact('title', 'competitionPaper', 'catComp', 'questionTempleates', 'competition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompetitionPaper  $competitionPaper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // $messages = [
        //     // 'amount.required_if' => 'This field is required',
        // ];
        // $request->validate([
        //     'title'  =>  'required',
        //     'questiontemplate'  =>  'required',
        //     'competition' => 'required',
        //     'time'  =>  'required',
        //     'question_type'  =>  'required',
        //     'category'  =>  'required',
        // ], $messages);

        $messages = [
            'questiontemplate.required_if' => 'This field is required',
            'paper_type.required_if' => 'This field is required',
        ];
        $request->validate([
            'title'  =>  'required',
            'category'  =>  'required',
            'competition' => 'required',
            'price'  =>  'required_if:competionT,2',
            // 'pdf_upload'  =>  'required_if:competionT,2',
            'questiontemplate'  =>  'required_if:competionT,1',
            'time'  =>  'required_if:competionT,1',
            'question_type'  =>  'required_if:competionT,1',
            'paper_type'  =>  'required',
        ], $messages);

        

        $competitionPaper = CompetitionPaper::where('id', $id)->first();
        $competitionPaper->title = $request->title;
        $competitionPaper->question_template_id = $request->questiontemplate;
        $competitionPaper->competition_controller_id = $request->competition;
        $competitionPaper->description = $request->description;
        $competitionPaper->time = $request->time;
        $competitionPaper->paper_type = $request->paper_type;
        $competitionPaper->price = $request->price;
        $competitionPaper->category_id = $request->category;
        if ($request->hasfile('pdf_upload')) {
            $file = $request->file('pdf_upload');
            $name = $file->getClientOriginalName();
            $file->move(public_path() . '/upload-file/', $name);
            $competitionPaper->pdf_file = $name;
            // $json['input_1']=$data;
            // $json['input_2']=$request->input_2;
        }
        
        $competitionPaper->type = $request->question_type;
        $competitionPaper->timer = $request->timer;
        $competitionPaper->save();

        // $categoryCompetition = PaperCategory::where('competition_paper_id', $id)->get();
        // foreach($categoryCompetition as $deleteCategory){
        //     $deleteCategory->delete();
        // }

        // $competitionPaperId = $competitionPaper->id;
        // foreach($request->category as $cate){
        //     $catCompt = new PaperCategory();
        //     $catCompt->competition_paper_id = $competitionPaperId;
        //     $catCompt->competition_id = $request->competition;
        //     $catCompt->category_id = $cate;
        //     $catCompt->save();
        // }

        return redirect()->route('papers.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CompetitionPaper  $competitionPaper
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompetitionPaper $competitionPaper)
    {
        //
    }
}
