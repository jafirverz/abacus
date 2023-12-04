<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\QuestionTemplate;
use App\User;
use App\WorksheetQuestionSubmitted;
use App\WorksheetSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionAttempt extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.QUESTIONS_ATTEMPT');
        // $this->module = 'QUESTIONS ATTEMPT';
        $this->module = 'QUESTIONS_ATTEMPT';
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
        $title = 'Question Attempted';
        $quesTemp = QuestionTemplate::whereIn('id', [1, 2, 3, 4, 5, 6, 7])->get();
        return view('admin.questionattempt', compact('title', 'quesTemp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        //dd($request->all());
        $quesTemp = $request->quesTemp ?? '';

        //$q = WorksheetSubmitted::query();
        $allWorksheetSubmitted = array();
        if ($request->quesTemp && empty($request->searchname)) {

            // simple where here or another scope, whatever you like
            $allWorksheetSubmitted = DB::table('worksheet_submitteds')
                ->where('question_template_id', $quesTemp)
                ->select('user_id', 'level_id', DB::raw('count(*) as total'))
                ->groupBy('level_id')
                ->groupBy('user_id')
                ->get();
        } elseif ($request->quesTemp && !empty($request->searchname)) {
            if ($request->searchname) {
                $user = User::where('name', 'like', '%' . $request->searchname . '%')->pluck('id')->toArray();
            } else {
                $user = array();
            }
            $allWorksheetSubmitted = DB::table('worksheet_submitteds')
                ->where('question_template_id', $quesTemp)
                ->whereIn('user_id', $user)
                ->select('user_id', 'level_id', DB::raw('count(*) as total'))
                ->groupBy('level_id')
                ->groupBy('user_id')
                ->get();
        }
        // dd($allWorksheetSubmitted);
        $title = 'Question Attempted';
        $quesTemp = QuestionTemplate::whereIn('id', [1, 2, 3, 4, 5, 6, 7])->get();
        //dd($allWorksheetSubmitted);
        return view('admin.questionattempt', compact('title', 'allWorksheetSubmitted', 'quesTemp'));

        // ob_end_clean();
        // ob_start();
        //return Excel::download(new SalesExport($allOrders), 'SalesReport.xlsx');
        //dd($allUsers);
    }

    public function challenge()
    {
        $title = 'Challenge Board';
        return view('admin.challengeboard', compact('title'));
    }

    public function challengedelete(Request $request)
    {
        $title = 'Challenge Board';
        $start_date = $request->start_date;
        $end_date = date('Y-m-d H:i:s', strtotime($request->end_date . ' +1 day'));
        // $end_date = $request->end_date;

        if ($request->show == 1) {
            //dd($request->all());
           $worksheetSub = WorksheetSubmitted::where('question_template_id', 6)->groupBy('level_id')->orderBy('level_id', 'asc')->get();
           return view('admin.challengeboard', compact('title', 'worksheetSub'));
           //dd($worksheetSub);
        } else {
            $worksheetSub = WorksheetSubmitted::where('created_at', '>=', $start_date)->where('updated_at', '<=', $end_date)->where('question_template_id', 6)->get();
            // dd($worksheetSub);
            foreach ($worksheetSub as $val) {
                $worksheetQuesSub = WorksheetQuestionSubmitted::where('worksheet_submitted_id', $val->id)->get();
                foreach ($worksheetQuesSub as $vall) {
                    $vall->delete();
                }
                $val->delete();
            }
            return redirect()->back()->with('success',  "Deleted successfully");
        }
        //dd($worksheetSub);
    }

    // public function challengeShow(Request $request){
    //     dd($request->all());
    //     $title = 'Challenge Board';
    //     $allOrders = array();
    //     $start_date = $request->start_date;
    //     $end_date = date('Y-m-d H:i:s', strtotime($request->end_date . ' +1 day'));
    //     $worksheetSub = WorksheetSubmitted::where('created_at','>=', $start_date)->where('updated_at','<=', $end_date)->where('question_template_id', 6)->get();
    //     return view('admin.challengeboard', compact('title'));
    // }
}
