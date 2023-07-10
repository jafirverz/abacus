<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\TestPaper;
use App\QuestionTemplate;
use App\TestPaperDetail;
use App\TestPaperQuestionDetail;
use App\User;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class TestPaperQuestionController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.TEST_PAPER_QUIESTION');
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
    public function index($paper_id)
    {
        $title = $this->title;
        $list = TestPaperDetail::where('paper_id',$paper_id)->paginate($this->pagination);

        return view('admin.test-paper.question.index', compact('title', 'list','paper_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($paper_id)
    {
        $title = $this->title;
        $questions = QuestionTemplate::whereIn('id',[3,4,5,6,7,8,9])->orderBy('id','desc')->get();
        return view('admin.test-paper.question.create', compact('title','paper_id','questions'));
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
            'question'  =>  'required',

        ]);

        $testPaperDetail = new TestPaperDetail();
        $testPaperDetail->question = $request->question ?? NULL;
        $testPaperDetail->paper_id  = $request->paper_id;
        $testPaperDetail->save();
        if($request->type==5)
        {
            for($k=0;$k<count($request->input_1);$k++)
            {
                $testPaperQuestionDetail = new TestPaperQuestionDetail();
                $testPaperQuestionDetail->input_1   = $request->input_1[$k];
                $testPaperQuestionDetail->input_2   = $request->input_2[$k];
                $testPaperQuestionDetail->input_3   = $request->input_3[$k];
                $testPaperQuestionDetail->answer   = $request->answer[$k];
                $testPaperQuestionDetail->test_paper_question_id    = $testPaperDetail->id;
                $testPaperQuestionDetail->save();
            }
        }
        elseif($request->type==4)
        {
            for($k=0;$k<count($request->input_1);$k++)
            {
                $testPaperQuestionDetail = new TestPaperQuestionDetail();
                $testPaperQuestionDetail->input_1   = $request->input_1[$k];
                $testPaperQuestionDetail->answer   = $request->answer[$k];
                $testPaperQuestionDetail->test_paper_question_id    = $testPaperDetail->id;
                $testPaperQuestionDetail->save();
            }


        }
        elseif($request->type==6)
        {


            if ($request->hasfile('input_1'))
            {
                $i=0;
                foreach ($request->file('input_1') as $file) {

                    if(isset($request->answer[$i]))
                    {
                    $testPaperQuestionDetail = new TestPaperQuestionDetail();
                    $testPaperQuestionDetail->input_1 = uploadPicture($file, 'upload-file');
                    $testPaperQuestionDetail->test_paper_question_id   = $testPaperDetail->id;
                    $testPaperQuestionDetail->answer   = $request->answer[$i];
                    $testPaperQuestionDetail->save();

                    }

                    $i++;


                }

            }


        }
        else
        {

            for($k=0;$k<count($request->input_1);$k++)
            {
                $testPaperQuestionDetail = new TestPaperQuestionDetail();
                $testPaperQuestionDetail->input_1   = $request->input_1[$k];
                $testPaperQuestionDetail->input_2   = $request->input_2[$k];
                $testPaperQuestionDetail->answer   = $request->answer[$k];
                $testPaperQuestionDetail->test_paper_question_id    = $testPaperDetail->id;
                $testPaperQuestionDetail->save();
            }


        }



        return redirect()->route('test-paper-question.index',$request->paper_id)->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $exam = GradingExam::find($id);
        $students = User::orderBy('id','desc')->where('user_type_id','!=',5)->where('approve_status','!=',0)->get();
        return view('admin.grading-exam.listing.show', compact('title', 'exam','students'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($paper_id,$id)
    {
        $title = $this->title;
        $list = TestPaperDetail::findorfail($id);
        $questions = QuestionTemplate::whereIn('id',[3,4,5,6,7,8,9])->orderBy('id','desc')->get();
        return view('admin.test-paper.question.edit', compact('title', 'list','paper_id','questions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$paper_id, $id)
    {
        $request->validate([
            'question'  =>  'required',

        ]);

        $testPaperDetail = TestPaperDetail::findorfail($id);
        $testPaperDetail->question = $request->question ?? NULL;
        $testPaperDetail->save();

        if($request->type==5)
        {

                    for($m=0;$m<count($request->listing_detail_id);$m++)
                    {


                            if(isset($request->listing_detail_id[$m]) && $request->listing_detail_id[$m]!='')
                            {
                                if(isset($request->old_input_1[$m]) && $request->old_input_1[$m]!='')
                                {
                                    $testPaperQuestionDetail = TestPaperQuestionDetail::findorfail($request->listing_detail_id[$m]);
                                    $testPaperQuestionDetail->input_1   = $request->old_input_1[$m];
                                    $testPaperQuestionDetail->input_2   = $request->old_input_2[$m];
                                    $testPaperQuestionDetail->input_3   = $request->old_input_3[$m];
                                    $testPaperQuestionDetail->answer   = $request->old_answer[$m];
                                    $testPaperQuestionDetail->save();
                                }
                                else
                                {
                                    TestPaperQuestionDetail::where('id',$request->listing_detail_id[$m])->delete();
                                }


                            }

                    }
                    if($request->input_1)
                     {

                        for($z=0;$z<count($request->input_1);$z++)
                        {
                            if(isset($request->input_1[$z]))
                            {
                                $testPaperQuestionDetail = new TestPaperQuestionDetail();
                                $testPaperQuestionDetail->input_1   = $request->input_1[$z];
                                $testPaperQuestionDetail->input_2   = $request->input_2[$z];
                                $testPaperQuestionDetail->input_3   = $request->input_3[$z];
                                $testPaperQuestionDetail->answer   = $request->answer[$z];
                                $testPaperQuestionDetail->test_paper_question_id    = $id;
                                $testPaperQuestionDetail->save();
                            }

                        }

                     }





        }
        elseif($request->type==6)
        {


                    for($m=0;$m<count($request->listing_detail_id);$m++)
                    {


                            if(isset($request->listing_detail_id[$m]) && $request->listing_detail_id[$m]!='')
                            {
                                if(isset($request->old_input_1[$m]) && $request->old_input_1[$m]!='')
                                {
                                    $testPaperQuestionDetail = TestPaperQuestionDetail::findorfail($request->listing_detail_id[$m]);
                                    $testPaperQuestionDetail->answer   = $request->old_answer[$m];
                                    $testPaperQuestionDetail->save();
                                }
                                else
                                {
                                    TestPaperQuestionDetail::where('id',$request->listing_detail_id[$m])->delete();
                                }


                            }

                    }
                     $n=0;
                     if($request->hasFile('input_1'))
                     {

                     foreach ($request->file('input_1') as $file) {

                            $testPaperQuestionDetail = new TestPaperQuestionDetail();
                            $testPaperQuestionDetail->input_1 = uploadPicture($file, 'upload-file');
                            $testPaperQuestionDetail->test_paper_question_id   = $testPaperDetail->id;
                            $testPaperQuestionDetail->answer   = $request->answer[$n];
                            $testPaperQuestionDetail->save();

                            $n++;
                        }



                     }




        }
        elseif($request->type==4)
        {

                    for($m=0;$m<count($request->listing_detail_id);$m++)
                    {


                            if(isset($request->listing_detail_id[$m]) && $request->listing_detail_id[$m]!='')
                            {
                                if(isset($request->old_input_1[$m]) && $request->old_input_1[$m]!='')
                                {
                                    $testPaperQuestionDetail = TestPaperQuestionDetail::findorfail($request->listing_detail_id[$m]);
                                    $testPaperQuestionDetail->input_1   = $request->old_input_1[$m];
                                    $testPaperQuestionDetail->answer   = $request->old_answer[$m];
                                    $testPaperQuestionDetail->save();
                                }
                                else
                                {
                                    TestPaperQuestionDetail::where('id',$request->listing_detail_id[$m])->delete();
                                }


                            }

                    }
                    if($request->input_1)
                     {

                        for($z=0;$z<count($request->input_1);$z++)
                        {
                            if(isset($request->input_1[$z]))
                            {
                                $testPaperQuestionDetail = new TestPaperQuestionDetail();
                                $testPaperQuestionDetail->input_1   = $request->input_1[$z];
                                $testPaperQuestionDetail->answer   = $request->answer[$z];
                                $testPaperQuestionDetail->test_paper_question_id    = $id;
                                $testPaperQuestionDetail->save();
                            }

                        }

                     }





        }
        else
        {


                    for($m=0;$m<count($request->listing_detail_id);$m++)
                    {
                        if(isset($request->listing_detail_id[$m]) && $request->listing_detail_id[$m]!='')
                        {
                            if(isset($request->old_input_1[$m]) && $request->old_input_1[$m]!='')
                            {
                                $testPaperQuestionDetail = TestPaperQuestionDetail::findorfail($request->listing_detail_id[$m]);
                                $testPaperQuestionDetail->title   = $request->old_input_1[$m];
                                $testPaperQuestionDetail->price   = $request->old_input_2[$m];
                                $testPaperQuestionDetail->paper_id   = $request->old_input_3[$m];
                                $testPaperQuestionDetail->save();
                            }
                            else
                            {
                                TestPaperQuestionDetail::where('id',$request->listing_detail_id[$m])->delete();
                            }


                        }
                    }



                     if($request->input_1)
                     {

                        for($z=0;$z<count($request->input_1);$z++)
                        {
                            if(isset($request->input_1[$z]))
                            {
                                $testPaperQuestionDetail = new TestPaperQuestionDetail();
                                $testPaperQuestionDetail->grading_listing_id   = $id;
                                $testPaperQuestionDetail->paper_id = $request->input_3[$z];
                                $testPaperQuestionDetail->title   = $request->input_1[$z];
                                $testPaperQuestionDetail->price   = $request->input_2[$z];
                                $testPaperQuestionDetail->save();
                            }

                        }

                     }

        }
        $testPaperDetail->save();

        return redirect()->route('test-paper-question.index',$paper_id)->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
        TestPaperDetail::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request,$exam_id)
    {
        $search_term = $request->search;
        $title = $this->title;
        $list = TestPaperDetail::where('grading_exams_id',$exam_id)->search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $list->appends('search', $search_term);
        }

        return view('admin.grading-exam.listing.index', compact('title', 'list','exam_id'));
    }
}
