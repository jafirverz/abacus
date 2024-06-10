<?php

namespace App\Http\Controllers\CMS;

use App\CategoryCompetition;
use App\Competition;
use App\CompetitionCategory;
use App\CompetitionPaper;
use App\CompetitionQuestions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaperCategory;
use App\QuestionTemplate;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $competitionPaper = CompetitionPaper::orderBy('id', 'desc')->paginate($this->pagination);
        
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
        $questionTempleates = QuestionTemplate::whereIn('id', [1,2,3,4,5,6,7])->get();
        $competitionCategory = CompetitionCategory::get();
        $competition = Competition::orderBy('id', 'desc')->get();
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
            //'questiontemplate.required_if' => 'This field is required',
            'price.required_if' => 'Price field is required',
            'pdf_upload.required_if' => 'PDF Upload field is required',
            'questiontemplate.required_if' => 'Question Template field is required',
            'time.required_if' => 'Time field is required',
        ];
        $request->validate([
            'title'  =>  'required',
            'category'  =>  'required',
            'competition' => 'required',
            'price'  =>  'required_if:competionT,2',
            'pdf_upload'  =>  'required_if:competionT,2',
            'questiontemplate'  =>  'required_if:competionT,1',
            'time'  =>  'required_if:competionT,1',
            //'question_type'  =>  'required_if:competionT,1',
            'paper_type'  =>  'required',
            'status' => 'required',
        ], $messages);

        if ($request->hasfile('pdf_upload')) {
            $file = $request->file('pdf_upload');
            $name = Carbon::now()->timestamp . '__' . guid() . '__' . $file->getClientOriginalName();
            //$name = $file->getClientOriginalName();
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
        $competitionPaper->type = $request->question_type ?? null;
        $competitionPaper->paper_type = $request->paper_type;
        $competitionPaper->timer = $request->timer;
        $competitionPaper->category_id = $request->category;
        $competitionPaper->status = $request->status;
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
    public function show($id)
    {
        //
        $title = $this->title;
        $competitionPaper = CompetitionPaper::with('comp_contro')->find($id);
        $questionTempleates = QuestionTemplate::whereIn('id', [1,2,3,4,5,6,7,8])->get();
        $competition = Competition::get();

        $catComp = CategoryCompetition::where('competition_id', $competitionPaper->competition_controller_id)->get();
        return view('admin.competition_paper.show', compact('title', 'competitionPaper', 'catComp', 'questionTempleates', 'competition'));
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
        $questionTempleates = QuestionTemplate::whereIn('id', [1,2,3,4,5,6,7,8])->get();
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
            //'question_type'  =>  'required_if:competionT,1',
            'paper_type'  =>  'required',
            'status' => 'required',
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
            $name = Carbon::now()->timestamp . '__' . guid() . '__' . $file->getClientOriginalName();
            //$name = $file->getClientOriginalName();
            $file->move(public_path() . '/upload-file/', $name);
            $competitionPaper->pdf_file = $name;
            // $json['input_1']=$data;
            // $json['input_2']=$request->input_2;
        }
        
        $competitionPaper->type = $request->question_type ?? null;
        $competitionPaper->timer = $request->timer;
        $competitionPaper->status = $request->status;
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
    public function destroy(Request $request)
    {
        //dd($request->all());
        $ids = $request->multiple_delete;
        $ids = explode(',', $ids);
        //dd($ids);
        $compPaper = CompetitionPaper::whereIn('id', $ids)->get();
        foreach($compPaper as $paper){
            $compQues = CompetitionQuestions::where('competition_paper_id', $paper->id)->get();
            foreach($compQues as $ques){
                $ques->delete();
            }
            $paper->delete();
        }
        return redirect()->back()->with('success',  "Deleted successfully");
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        $competitionPaper = CompetitionPaper::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $competitionPaper->appends('search', $search_term);
        }

        return view('admin.competition_paper.index', compact('title', 'competitionPaper'));
    }

    public function questions($id){
        // dd($id);
        $title = 'Online Competition Question';
        $pId = $id;
        $papercheck = CompetitionPaper::where('id', $id)->first();
        $questemplate = $papercheck->question_template_id;
        // $competitionQuestions = CompetitionQuestions::with('comp_paper')->groupBy('competition_paper_id')->paginate($this->pagination);
        $competitionPaper = CompetitionPaper::whereHas('comp_ques')->where('id', $id)->paginate($this->pagination);
        return view('admin.competition_paper.question', compact('title', 'competitionPaper', 'pId', 'questemplate', 'papercheck'));
    }

    public function questionCreate($pId = null, $qId = null)
    {
        $title = 'Online Competition Question create';
        $papers = CompetitionPaper::get();
        return view('admin.competition_paper.question_create', compact('title', 'papers', 'pId', 'qId'));
    }

    public function questionsEdit($pId = null, $qId = null)
    {
        //
        $title = 'Online Competition Question edit';
        $papers = CompetitionPaper::get();
        $competitionPaper = CompetitionPaper::where('id', $pId)->first();
        $compQues = CompetitionQuestions::where('competition_paper_id', $pId)->get();
        return view('admin.competition_paper.question_edit', compact('title', 'competitionPaper', 'compQues', 'papers', 'pId'));
    }

    public function questionsShow($pId = null, $qId = null)
    {
        //
        $title = 'Online Competition Question show';
        $papers = CompetitionPaper::get();
        $competitionPaper = CompetitionPaper::where('id', $pId)->first();
        $compQues = CompetitionQuestions::where('competition_paper_id', $pId)->get();
        return view('admin.competition_paper.question_show', compact('title', 'competitionPaper', 'compQues', 'papers', 'pId'));
    }
}
