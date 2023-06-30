<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\GradingExam;
use App\GradingExamList;
use App\GradingListingDetail;
use App\User;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class GradingExamListController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.GRADING_EXAM_LIST');
        $this->module = 'GRADING_EXAM';
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
    public function index($exam_id)
    {
        $title = $this->title;
        $list = GradingExamList::where('grading_exams_id',$exam_id)->paginate($this->pagination);

        return view('admin.grading-exam.listing.index', compact('title', 'list','exam_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($exam_id)
    {
        $title = $this->title;
        return view('admin.grading-exam.listing.create', compact('title','exam_id'));
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
            'heading'  =>  'required',

        ]);

        $gradingExamList = new GradingExamList();
        $gradingExamList->heading = $request->heading ?? NULL;
        $gradingExamList->grading_exams_id  = $request->exam_id;
        $gradingExamList->save();
        if($request->type==1)
        {
            if ($request->hasfile('input_3'))
            {
                $i=0;
                foreach ($request->file('input_3') as $file) {

                    //$name = $file->getClientOriginalName();
                    //$file->move(public_path() . '/upload-file/', $name);
                    //Physical

                    if(isset($request->input_1[$i]))
                    {
                    $gradingListingDetail = new GradingListingDetail();
                    $gradingListingDetail->uploaded_file = uploadPicture($file, 'upload-file');
                    $gradingListingDetail->grading_listing_id   = $gradingExamList->id;
                    $gradingListingDetail->title   = $request->input_1[$i];
                    $gradingListingDetail->price   = $request->input_2[$i];
                    $gradingListingDetail->save();

                    }

                    $i++;


                }

            }
        }
        else
        {

            for($k=0;count($request->input_1);$k++)
            {
                //Online
                $gradingListingDetail = new GradingListingDetail();
                $gradingListingDetail->grading_listing_id   = $gradingExamList->id;
                $gradingListingDetail->title   = $request->input_1[$i];
                $gradingListingDetail->price   = $request->input_2[$i];
                $gradingListingDetail->paper_id   = $request->input_3[$i];
                $gradingExamList->save();
            }


        }



        return redirect()->route('grading-exam-list.index',$request->exam_id)->with('success', __('constant.CREATED', ['module' => $this->title]));
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
    public function edit($exam_id,$id)
    {
        $title = $this->title;
        $list = GradingExamList::findorfail($id);
        return view('admin.grading-exam.listing.edit', compact('title', 'list','exam_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$exam_id, $id)
    {
        $request->validate([
            'heading'  =>  'required',
        ]);

        $gradingExamList = GradingExamList::findorfail($id);
        if($request->type==1)
        {


                    for($m=0;$m<count($request->listing_detail_id);$m++)
                    {


                            if(isset($request->listing_detail_id[$m]) && $request->listing_detail_id[$m]!='')
                            {
                                if(isset($request->old_input_1[$m]) && $request->old_input_1[$m]!='')
                                {
                                    $gradingListingDetail = GradingListingDetail::findorfail($request->listing_detail_id[$m]);
                                    $gradingListingDetail->title   = $request->old_input_1[$m];
                                    $gradingListingDetail->price   = $request->old_input_2[$m];
                                    $gradingListingDetail->save();
                                }
                                else
                                {
                                    GradingListingDetail::where('id',$request->listing_detail_id[$m])->delete();
                                }


                            }

                    }
                     $n=0;
                     if($request->hasFile('input_3'))
                     {

                     foreach ($request->file('input_3') as $file) {
                            $gradingListingDetail = new GradingListingDetail();
                            $gradingListingDetail->grading_listing_id   = $id;
                            $gradingListingDetail->uploaded_file = uploadPicture($file, 'upload-file');
                            $gradingListingDetail->title   = $request->input_1[$n];
                            $gradingListingDetail->price   = $request->input_2[$n];
                            $gradingListingDetail->save();
                            $n++;
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
                                $gradingListingDetail = GradingListingDetail::findorfail($request->listing_detail_id[$m]);
                                $gradingListingDetail->title   = $request->old_input_1[$m];
                                $gradingListingDetail->price   = $request->old_input_2[$m];
                                $gradingListingDetail->paper_id   = $request->old_input_3[$m];
                                $gradingListingDetail->save();
                            }
                            else
                            {
                                GradingListingDetail::where('id',$request->listing_detail_id[$m])->delete();
                            }


                        }
                    }



                     if($request->input_1)
                     {

                        for($z=0;$z<count($request->input_1);$z++)
                        {
                            if(isset($request->input_1[$z]))
                            {
                                $gradingListingDetail = new GradingListingDetail();
                                $gradingListingDetail->grading_listing_id   = $id;
                                $gradingListingDetail->paper_id = $request->input_3[$z];
                                $gradingListingDetail->title   = $request->input_1[$z];
                                $gradingListingDetail->price   = $request->input_2[$z];
                                $gradingListingDetail->save();
                            }

                        }

                     }

        }
        $gradingExamList->save();

        return redirect()->route('grading-exam-list.index',$exam_id)->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
        GradingExamList::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request,$exam_id)
    {
        $search_term = $request->search;
        $title = $this->title;
        $list = GradingExamList::where('grading_exams_id',$exam_id)->search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $list->appends('search', $search_term);
        }

        return view('admin.grading-exam.listing.index', compact('title', 'list','exam_id'));
    }
}
