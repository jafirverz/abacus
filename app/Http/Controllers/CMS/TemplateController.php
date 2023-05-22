<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Template;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.TEMPLATE');
        $this->module = 'TEMPLATE';
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
        $templates = Template::orderBy('view_order', 'asc')->paginate($this->pagination);

        return view('admin.template.index', compact('title', 'templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $templates = Template::orderBy('title', 'asc')->get();

        return view('admin.template.create', compact('title', 'templates'));
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
            'view_order'   =>  'required|numeric',
        ]);

        $template = new Template;
        $template->title = $request->title;
        $template->view_order = $request->view_order;
        $template->save();

        return redirect()->route('template.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $template = Template::findorfail($id);

        return view('admin.template.show', compact('title', 'template'));
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
        $templates = Template::findorfail($id);
        return view('admin.template.edit', compact('title', 'templates'));
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
            'view_order'   =>  'required|numeric',
        ]);

        $template = Template::findorfail($id);
        $template->title = $request->title;
        $template->view_order = $request->view_order;
        $template->updated_at = Carbon::now();
        $template->save();

        return redirect()->route('template.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        Template::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        //DB::enableQueryLog();
		$title = $this->title;
        $templates = Template::search($request->search)->orderBy('view_order', 'asc')->paginate($this->systemSetting()->pagination);
       // dd(DB::getQueryLog());
        return view('admin.template.index', compact('title', 'templates'));
    }
}
