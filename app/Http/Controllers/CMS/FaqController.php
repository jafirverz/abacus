<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Faq;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.FAQ');
        $this->module = 'FAQ';
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
        $faqs = Faq::orderBy('view_order', 'asc')->paginate($this->pagination);

        return view('admin.faq.index', compact('title', 'faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $faq = Faq::orderBy('title', 'asc')->get();

        return view('admin.faq.create', compact('title', 'faq'));
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
			'content'  =>  'required',
            'view_order'   =>  'required|numeric',
			'status'  =>  'required',
        ]);

        $faq = new Faq;
        $faq->title = $request->title;
		$faq->content = $request->content;
        $faq->view_order = $request->view_order;
		$faq->status = $request->status;
        $faq->save();

        return redirect()->route('faqs.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $faq = Faq::findorfail($id);

        return view('admin.faq.show', compact('title', 'faq'));
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
        $faq = Faq::findorfail($id);
        return view('admin.faq.edit', compact('title', 'faq'));
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
			'content'  =>  'required',
            'view_order'   =>  'required|numeric',
			'status'  =>  'required',
        ]);

        $faq = Faq::findorfail($id);
        $faq->title = $request->title;
		$faq->content = $request->content;
        $faq->view_order = $request->view_order;
		$faq->status = $request->status;
        $faq->updated_at = Carbon::now();
        $faq->save();

        return redirect()->route('faqs.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = explode(',', $request->multiple_delete);
        Faq::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        //DB::enableQueryLog();
		$title = $this->title;
        $faqs = Faq::search($request->search)->orderBy('view_order', 'asc')->paginate($this->pagination);
       // dd(DB::getQueryLog());  
        return view('admin.faq.index', compact('title', 'faqs'));
    }
}
