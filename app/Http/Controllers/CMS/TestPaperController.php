<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\TestPaper;
use App\TestPaperDetail;
use App\QuestionTemplate;
use App\User;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


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
        $title = $this->title;
        $paper = TestPaper::paginate($this->pagination);

        return view('admin.test-paper.index', compact('title', 'paper'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $questions = QuestionTemplate::whereIn('id',[3,4,5,6,7,8,9])->orderBy('id','desc')->get();
        return view('admin.test-paper.create', compact('title','questions'));
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
            'title'  =>  'required',
            'question_template_id'  =>  'required',
        ]);

        $testPaper = new TestPaper();
        $testPaper->title = $request->title ?? NULL;
        $testPaper->question_template_id = $request->question_template_id ?? NULL;
        $testPaper->save();

        return redirect()->route('test-paper.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $paper = TestPaper::find($id);
        return view('admin.test-paper.show', compact('title', 'paper'));
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
        $paper = TestPaper::findorfail($id);
        $questions = QuestionTemplate::whereIn('id',[3,4,5,6,7,8,9])->orderBy('id','desc')->get();
        return view('admin.test-paper.edit', compact('title', 'paper','questions'));
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
        $request->validate([
            'title'  =>  'required',
            'question_template_id'  =>  'required',
        ]);

        $testPaper = TestPaper::findorfail($id);
        $testPaper->title = $request->title ?? NULL;
        $testPaper->question_template_id = $request->question_template_id ?? NULL;
        $testPaper->save();

        return redirect()->route('test-paper.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
        TestPaper::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        $paper = TestPaper::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $paper->appends('search', $search_term);
        }

        return view('admin.test-paper.index', compact('title', 'paper'));
    }
}
