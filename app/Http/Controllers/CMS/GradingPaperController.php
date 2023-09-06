<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\GradingPaper;
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
        $paper = GradingPaper::paginate($this->pagination);

        return view('admin.master.grading-paper.index', compact('title', 'paper'));
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
        return view('admin.master.grading-paper.create', compact('title','templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields=[
            'title'  =>  'required',
            'question_type'  =>  'required',
            'time' => 'required_if:timer,==,Yes',
        ];

        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $messages['question_type.required'] = 'The question type field is required.';
        $request->validate($fields, $messages);

        $paper = new GradingPaper();
        $paper->title = $request->title;
        $paper->timer = $request->timer ?? '';
        $paper->time = $request->time ?? '';
        $paper->question_type = $request->question_type;
        $paper->created_at = Carbon::now();
        $paper->save();

        if($request->question_type==5 || $request->question_type==7)
        {

            for($k=0;$k<count($request->input_1);$k++)
            {
                $gradingPaperQuestion = new GradingPaperQuestion();
                $gradingPaperQuestion->input_1   = $request->input_1[$k];
                $gradingPaperQuestion->input_2   = $request->input_2[$k];
                $gradingPaperQuestion->input_3   = $request->input_3[$k];
                $gradingPaperQuestion->answer   = $request->answer[$k];
                $gradingPaperQuestion->grading_paper_question_id    = $paper->id;
                $gradingPaperQuestion->marks   = $request->marks[$k];
                $gradingPaperQuestion->save();
            }
        }
        else if($request->question_type==4)
        {

            for($k=0;$k<count($request->input_1);$k++)
            {
                $gradingPaperQuestion = new GradingPaperQuestion();
                $gradingPaperQuestion->input_1   = $request->input_1[$k];
                $gradingPaperQuestion->answer   = $request->answer[$k];
                $gradingPaperQuestion->grading_paper_question_id    = $paper->id;
                $gradingPaperQuestion->marks   = $request->marks[$k];
                $gradingPaperQuestion->save();
            }
        }
        else if($request->question_type==8)
        {

            for($k=0;$k<count($request->input_1);$k++)
            {
                $gradingPaperQuestion = new GradingPaperQuestion();
                $gradingPaperQuestion->input_1   = $request->input_1[$k];
                $gradingPaperQuestion->input_2   = $request->input_2[$k];
                $gradingPaperQuestion->answer   = $request->answer[$k];
                $gradingPaperQuestion->grading_paper_question_id    = $paper->id;
                $gradingPaperQuestion->marks   = $request->marks[$k];
                $gradingPaperQuestion->save();
            }
        }
        elseif($request->question_type==6)
        {

            for($k=0;$k<count($request->input_1);$k++)
            {
                $gradingPaperQuestion = new GradingPaperQuestion();
                $gradingPaperQuestion->input_1   = $request->input_1[$k];
                $gradingPaperQuestion->input_2   = $request->input_2[$k];
                $gradingPaperQuestion->input_3   = $request->input_3[$k];
                $gradingPaperQuestion->answer   = $request->answer[$k];
                $gradingPaperQuestion->grading_paper_question_id    = $paper->id;
                $gradingPaperQuestion->marks   = $request->marks[$k];
                $gradingPaperQuestion->save();
            }
        }
        elseif($request->question_type==2 || $request->question_type==3)
        {
            $i=0;
                foreach ($request->file('input_1') as $file) {

                    if(isset($request->answer[$i]))
                    {
                    $gradingPaperQuestion = new GradingPaperQuestion();
                    $gradingPaperQuestion->input_1 = uploadPicture($file, 'upload-file');
                    $gradingPaperQuestion->grading_paper_question_id    = $paper->id;
                    $gradingPaperQuestion->answer   = $request->answer[$i];
                    $gradingPaperQuestion->marks   = $request->marks[$i];
                    $gradingPaperQuestion->save();

                    }

                    $i++;


                }
        }
        elseif($request->question_type==1)
        {
            $i=0;
                foreach ($request->file('input_1') as $file) {

                    if(isset($request->answer[$i]))
                    {
                    $gradingPaperQuestion = new GradingPaperQuestion();
                    $gradingPaperQuestion->input_1 = uploadPicture($file, 'upload-file');
                    $gradingPaperQuestion->grading_paper_question_id    = $paper->id;
                    $gradingPaperQuestion->answer   = $request->answer[$i];
                    $gradingPaperQuestion->marks   = $request->marks[$i];
                    $gradingPaperQuestion->input_2   = $request->input_2[$i];
                    $gradingPaperQuestion->save();

                    }

                    $i++;


                }
        }


        //dd($question);



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
        $paper = GradingPaper::find($id);
        $templates = QuestionTemplate::get();
        return view('admin.master.grading-paper.show', compact('title', 'paper','templates'));
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
        $paper = GradingPaper::findorfail($id);
        $templates = QuestionTemplate::get();
        return view('admin.master.grading-paper.edit', compact('title', 'paper','templates'));
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
        $fields=[
            'title'  =>  'required',
            'question_type'  =>  'required',
            'time' => 'required_if:timer,==,Yes',
        ];

        $messages = [];
        $messages['title.required'] = 'The title field is required.';
        $messages['question_type.required'] = 'The question type field is required.';
        $request->validate($fields, $messages);

        $paper = GradingPaper::findorfail($id);
        $paper->title = $request->title;
        $paper->question_type = $request->question_type;
        $paper->timer = $request->timer ?? '';
        $paper->time = $request->time ?? '';
        $paper->updated_at = Carbon::now();
        $paper->save();

         if($request->question_type==5 || $request->question_type==7)
        {

                    for($m=0;$m<count($request->listing_detail_id);$m++)
                    {


                            if(isset($request->listing_detail_id[$m]) && $request->listing_detail_id[$m]!='')
                            {
                                if(isset($request->old_input_1[$m]) && $request->old_input_1[$m]!='')
                                {
                                    $gradingPaperQuestion = GradingPaperQuestion::findorfail($request->listing_detail_id[$m]);
                                    $gradingPaperQuestion->input_1   = $request->old_input_1[$m];
                                    $gradingPaperQuestion->input_2   = $request->old_input_2[$m];
                                    $gradingPaperQuestion->input_3   = $request->old_input_3[$m];
                                    $gradingPaperQuestion->answer   = $request->old_answer[$m];
                                    $gradingPaperQuestion->marks   = $request->old_marks[$m];
                                    $gradingPaperQuestion->save();
                                }
                                else
                                {
                                    GradingPaperQuestion::where('id',$request->listing_detail_id[$m])->delete();
                                }


                            }

                    }

                    if($request->input_1)
                     {
                        for($k=0;$k<count($request->input_1);$k++)
                        {
                            $gradingPaperQuestion = new GradingPaperQuestion();
                            $gradingPaperQuestion->input_1   = $request->input_1[$k];
                            $gradingPaperQuestion->input_2   = $request->input_2[$k];
                            $gradingPaperQuestion->input_3   = $request->input_3[$k];
                            $gradingPaperQuestion->answer   = $request->answer[$k];
                            $gradingPaperQuestion->grading_paper_question_id    = $paper->id;
                            $gradingPaperQuestion->marks   = $request->marks[$k];
                            $gradingPaperQuestion->save();
                        }
                     }
        }
        elseif($request->question_type==4)
        {

                    for($m=0;$m<count($request->listing_detail_id);$m++)
                    {


                            if(isset($request->listing_detail_id[$m]) && $request->listing_detail_id[$m]!='')
                            {
                                if(isset($request->old_input_1[$m]) && $request->old_input_1[$m]!='')
                                {
                                    $gradingPaperQuestion = GradingPaperQuestion::findorfail($request->listing_detail_id[$m]);
                                    $gradingPaperQuestion->input_1   = $request->old_input_1[$m];
                                    $gradingPaperQuestion->answer   = $request->old_answer[$m];
                                    $gradingPaperQuestion->marks   = $request->old_marks[$m];
                                    $gradingPaperQuestion->save();
                                }
                                else
                                {
                                    GradingPaperQuestion::where('id',$request->listing_detail_id[$m])->delete();
                                }


                            }

                    }

                    if($request->input_1)
                     {
                        for($k=0;$k<count($request->input_1);$k++)
                        {
                            $gradingPaperQuestion = new GradingPaperQuestion();
                            $gradingPaperQuestion->input_1   = $request->input_1[$k];
                            $gradingPaperQuestion->answer   = $request->answer[$k];
                            $gradingPaperQuestion->grading_paper_question_id    = $paper->id;
                            $gradingPaperQuestion->marks   = $request->marks[$k];
                            $gradingPaperQuestion->save();
                        }
                     }
        }
        elseif($request->question_type==8)
        {

                    for($m=0;$m<count($request->listing_detail_id);$m++)
                    {


                            if(isset($request->listing_detail_id[$m]) && $request->listing_detail_id[$m]!='')
                            {
                                if(isset($request->old_input_1[$m]) && $request->old_input_1[$m]!='')
                                {
                                    $gradingPaperQuestion = GradingPaperQuestion::findorfail($request->listing_detail_id[$m]);
                                    $gradingPaperQuestion->input_1   = $request->old_input_1[$m];
                                    $gradingPaperQuestion->input_2   = $request->old_input_2[$m];
                                    $gradingPaperQuestion->answer   = $request->old_answer[$m];
                                    $gradingPaperQuestion->marks   = $request->old_marks[$m];
                                    $gradingPaperQuestion->save();
                                }
                                else
                                {
                                    GradingPaperQuestion::where('id',$request->listing_detail_id[$m])->delete();
                                }


                            }

                    }

                    if($request->input_1)
                     {
                        for($k=0;$k<count($request->input_1);$k++)
                        {
                            $gradingPaperQuestion = new GradingPaperQuestion();
                            $gradingPaperQuestion->input_1   = $request->input_1[$k];
                            $gradingPaperQuestion->input_2   = $request->input_2[$k];
                            $gradingPaperQuestion->answer   = $request->answer[$k];
                            $gradingPaperQuestion->grading_paper_question_id    = $paper->id;
                            $gradingPaperQuestion->marks   = $request->marks[$k];
                            $gradingPaperQuestion->save();
                        }
                     }
        }
        elseif($request->question_type==6)
        {

                    for($m=0;$m<count($request->listing_detail_id);$m++)
                    {


                            if(isset($request->listing_detail_id[$m]) && $request->listing_detail_id[$m]!='')
                            {
                                if(isset($request->old_input_1[$m]) && $request->old_input_1[$m]!='')
                                {
                                    $gradingPaperQuestion = GradingPaperQuestion::findorfail($request->listing_detail_id[$m]);
                                    $gradingPaperQuestion->input_1   = $request->old_input_1[$m];
                                    $gradingPaperQuestion->input_2   = $request->old_input_2[$m];
                                    $gradingPaperQuestion->input_3   = $request->old_input_3[$m];
                                    $gradingPaperQuestion->answer   = $request->old_answer[$m];
                                    $gradingPaperQuestion->marks   = $request->old_marks[$m];
                                    $gradingPaperQuestion->save();
                                }
                                else
                                {
                                    GradingPaperQuestion::where('id',$request->listing_detail_id[$m])->delete();
                                }


                            }

                    }

                    if($request->input_1)
                     {
                        for($k=0;$k<count($request->input_1);$k++)
                        {
                            $gradingPaperQuestion = new GradingPaperQuestion();
                            $gradingPaperQuestion->input_1   = $request->input_1[$k];
                            $gradingPaperQuestion->input_2   = $request->input_2[$k];
                            $gradingPaperQuestion->input_3   = $request->input_3[$k];
                            $gradingPaperQuestion->answer   = $request->answer[$k];
                            $gradingPaperQuestion->grading_paper_question_id    = $paper->id;
                            $gradingPaperQuestion->marks   = $request->marks[$k];
                            $gradingPaperQuestion->save();
                        }
                     }
        }
        elseif($request->question_type==2 || $request->question_type==3)
        {
                    for($m=0;$m<count($request->listing_detail_id);$m++)
                    {


                            if(isset($request->listing_detail_id[$m]) && $request->listing_detail_id[$m]!='')
                            {
                                if(isset($request->old_input_1[$m]) && $request->old_input_1[$m]!='')
                                {
                                    $gradingPaperQuestion = GradingPaperQuestion::findorfail($request->listing_detail_id[$m]);
                                    $gradingPaperQuestion->answer   = $request->old_answer[$m];
                                    $gradingPaperQuestion->marks   = $request->old_marks[$m];
                                    $gradingPaperQuestion->save();
                                }
                                else
                                {
                                    GradingPaperQuestion::where('id',$request->listing_detail_id[$m])->delete();
                                }


                            }

                    }

                     $n=0;
                     foreach ($request->file('input_1') as $file) {

                        if(isset($request->answer[$n]))
                        {
                        $gradingPaperQuestion = new GradingPaperQuestion();
                        $gradingPaperQuestion->input_1 = uploadPicture($file, 'upload-file');
                        $gradingPaperQuestion->grading_paper_question_id    = $paper->id;
                        $gradingPaperQuestion->answer   = $request->answer[$n];
                        $gradingPaperQuestion->marks   = $request->marks[$n];
                        $gradingPaperQuestion->save();

                        }

                        $n++;


                    }
        }
        elseif($request->question_type==1)
        {
                    for($m=0;$m<count($request->listing_detail_id);$m++)
                    {


                            if(isset($request->listing_detail_id[$m]) && $request->listing_detail_id[$m]!='')
                            {
                                if(isset($request->old_input_1[$m]) && $request->old_input_1[$m]!='')
                                {
                                    $gradingPaperQuestion = GradingPaperQuestion::findorfail($request->listing_detail_id[$m]);
                                    $gradingPaperQuestion->answer   = $request->old_answer[$m];
                                    $gradingPaperQuestion->marks   = $request->old_marks[$m];
                                    $gradingPaperQuestion->input_2   = $request->old_input_2[$m];
                                    $gradingPaperQuestion->save();
                                }
                                else
                                {
                                    GradingPaperQuestion::where('id',$request->listing_detail_id[$m])->delete();
                                }


                            }

                    }

                     $n=0;
                     foreach ($request->file('input_1') as $file) {

                        if(isset($request->answer[$n]))
                        {
                        $gradingPaperQuestion = new GradingPaperQuestion();
                        $gradingPaperQuestion->input_1 = uploadPicture($file, 'upload-file');
                        $gradingPaperQuestion->grading_paper_question_id    = $paper->id;
                        $gradingPaperQuestion->answer   = $request->answer[$n];
                        $gradingPaperQuestion->marks   = $request->marks[$n];
                        $gradingPaperQuestion->input_2   = $request->input_2[$n];
                        $gradingPaperQuestion->save();

                        }

                        $n++;


                    }
        }


        //dd($question);


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
        $id = explode(',', $request->multiple_delete);
        GradingPaper::destroy($id);

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
}
