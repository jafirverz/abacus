<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\GradingPaper;
use App\Grade;
use App\GradingExam;
use App\GradingCategory;
use App\CategoryGrading;
use App\GradingStudent;
use App\GradingPaperQuestion;
use App\QuestionTemplate;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class GradingPaperController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.GRADING_PAPER');
        $this->module = 'GRADING_PAPER';
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
        $competitionPaper = GradingPaper::orderBy('id', 'desc')->paginate($this->pagination);

        return view('admin.master.grading-paper.index', compact('title', 'competitionPaper'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $templates = QuestionTemplate::get();
        $grades = Grade::get();
        $questionTempleates = QuestionTemplate::whereIn('id', [1,2,3,4,5,6,7])->get();
        $competitionCategory = GradingCategory::get();
        $competition = GradingExam::get();
        return view('admin.master.grading-paper.create', compact('title','templates','grades','questionTempleates','competitionCategory','competition'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            //'question_type'  =>  'required_if:competionT,1',
            'paper_type'  =>  'required',
        ], $messages);

        if ($request->hasfile('pdf_upload')) {
            $file = $request->file('pdf_upload');
            $name = $file->getClientOriginalName();
            $file->move(public_path() . '/upload-file/', $name);

            // $json['input_1']=$data;
            // $json['input_2']=$request->input_2;
        }

        $competitionPaper = new GradingPaper();
 $competitionPaper->title = $request->title;
        $competitionPaper->question_template_id = $request->questiontemplate;
        $competitionPaper->grading_exam_id = $request->competition;
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


        return redirect()->route('grading-paper.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $competitionPaper = GradingPaper::with('comp_contro')->find($id);
        $questionTempleates = QuestionTemplate::whereIn('id', [1,2,3,4,5,6,7,8])->get();
        $competition = GradingExam::get();

        $catComp = CategoryGrading::where('competition_id', $competitionPaper->grading_exam_id)->get();
        return view('admin.master.grading-paper.show', compact('title', 'competitionPaper','questionTempleates','competition','catComp'));
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
        $competitionPaper = GradingPaper::with('comp_contro')->find($id);
        $questionTempleates = QuestionTemplate::whereIn('id', [1,2,3,4,5,6,7])->get();
        $competitionCategory = CategoryGrading::get();
        $competition = GradingExam::get();
        $grades = Grade::get();
        $catComp = CategoryGrading::where('competition_id', $competitionPaper->grading_exam_id)->get();
        return view('admin.master.grading-paper.edit', compact('title','catComp', 'competitionPaper','grades','questionTempleates', 'competition', 'competitionCategory'));
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
        ], $messages);

        $competitionPaper = GradingPaper::where('id', $id)->first();
        $competitionPaper->title = $request->title;
        $competitionPaper->question_template_id = $request->questiontemplate;
        $competitionPaper->grading_exam_id = $request->competition;
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

        $competitionPaper->type = $request->question_type ?? null;
        $competitionPaper->timer = $request->timer;
        $competitionPaper->status = $request->status;
        $competitionPaper->save();


        return redirect()->route('grading-paper.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->multiple_delete;
        $ids = explode(',', $ids);
        //dd($ids);
        $compPaper = GradingPaper::whereIn('id', $ids)->get();
        foreach($compPaper as $paper){
            $compQues = GradingPaperQuestion::where('grading_paper_id', $paper->id)->get();
            foreach($compQues as $ques){
                $ques->delete();
            }
            $paper->delete();
        }

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $templates = QuestionTemplate::get();
        $title = $this->title;
        $paper = GradingPaper::join('question_templates','question_templates.id','grading_papers.question_type')->search($search_term)->select('grading_papers.*')->paginate($this->pagination);
        if ($search_term) {
            $paper->appends('search', $search_term);
        }

        return view('admin.master.grading-paper.index', compact('title', 'templates','paper'));
    }


    public function questions($id){
        // dd($id);
        $title = 'Online Grading Question';
        $pId = $id;
        $papercheck = GradingPaper::where('id', $id)->first();
        $questemplate = $papercheck->question_template_id;
        // $competitionQuestions = CompetitionQuestions::with('comp_paper')->groupBy('grading_paper_id')->paginate($this->pagination);
        if($questemplate==7)
        {
            $competitionPaper = GradingPaper::join('grading_paper_details','grading_paper_details.paper_id','grading_papers.id')->select('grading_papers.*','grading_paper_details.template','grading_paper_details.id as paper_detail_id')->where('grading_paper_details.paper_id', $id)->paginate($this->pagination);
        }
        else
        {
            $competitionPaper = GradingPaper::whereHas('comp_ques')->where('id', $id)->paginate($this->pagination);
        }

        return view('admin.master.grading-paper.question', compact('title', 'competitionPaper', 'pId', 'questemplate'));
    }

    public function questionCreate($pId = null, $qId = null)
    {
        $title = 'Online Grading Question create';
        $papers = GradingPaper::get();
        return view('admin.master.grading-paper.question_create', compact('title', 'papers', 'pId', 'qId'));
    }

    public function questionsEdit($pId = null, $qId = null)
    {
        //
        $title = 'Online Grading Question edit';
        $papers = GradingPaper::get();
        $competitionPaper = GradingPaper::where('id', $pId)->first();
        $compQues = GradingPaperQuestion::where('grading_paper_id', $pId)->get();
        return view('admin.master.grading-paper.question_edit', compact('title', 'competitionPaper', 'compQues', 'papers', 'pId'));
    }

    public function questionsShow($pId = null, $qId = null)
    {
        //
        $title = 'Online Grading Question show';
        $papers = GradingPaper::get();
        $competitionPaper = GradingPaper::where('id', $pId)->first();
        $compQues = GradingPaperQuestion::where('grading_paper_id', $pId)->get();
        return view('admin.master.grading-paper.question_show', compact('title', 'competitionPaper', 'compQues', 'papers', 'pId'));
    }
}
