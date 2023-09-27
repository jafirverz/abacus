<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\QuestionTemplate;
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
        $this->module = 'QUESTIONS ATTEMPT';
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
        $quesTemp = QuestionTemplate::whereIn('id', [1,2,3,4,5,6,7])->get();
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

        if ($request->quesTemp) {
            // simple where here or another scope, whatever you like
            $allWorksheetSubmitted = DB::table('worksheet_submitteds')
                ->where('question_template_id', $quesTemp)
                 ->select('user_id', DB::raw('count(*) as total'))
                 ->groupBy('user_id')
                 ->get();
        }

        $title = 'Question Attempted';
        $quesTemp = QuestionTemplate::whereIn('id', [1,2,3,4,5,6,7])->get();
        //dd($allWorksheetSubmitted);
        return view('admin.questionattempt', compact('title', 'allWorksheetSubmitted', 'quesTemp'));

        // ob_end_clean();
        // ob_start();
        //return Excel::download(new SalesExport($allOrders), 'SalesReport.xlsx');
        //dd($allUsers);
    }

    public function challenge(){
        $title = 'Challenge Board';
        return view('admin.challengeboard', compact('title'));
    }

    public function challengedelete(Request $request){
        //dd($request->all());
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $worksheetSub = WorksheetSubmitted::where('created_at','>=', $start_date)->where('created_at','<=', $end_date)->where('question_template_id', 6)->get();
        foreach($worksheetSub as $val){
            $worksheetQuesSub = WorksheetQuestionSubmitted::where('worksheet_submitted_id', $val->id)->get();
            foreach($worksheetQuesSub as $vall) {
                $vall->delete();
            }
            $val->delete();
        }
        return redirect()->back()->with('success',  "Deleted successfully");
        //dd($worksheetSub);
    }
}
