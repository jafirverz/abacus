<?php

namespace App\Http\Controllers\CMS;

use App\EmailTemplate;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailTemplateController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.EMAIL_TEMPLATE');
        $this->module = 'EMAIL_TEMPLATE';
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
        $email_template = EmailTemplate::orderBy('id', 'asc')->paginate($this->pagination);

        return view('admin.cms.email_template.index', compact('title', 'email_template'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;

        return view('admin.cms.email_template.create', compact('title'));
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
            'subject'   =>  'required',
            'content'  =>  'required',
            'status'   =>  'required',
        ]);

        $email_template = new EmailTemplate;
        $email_template->title = $request->title;
        $email_template->subject = $request->subject;
        $email_template->content = $request->content;
        $email_template->status = $request->status;
		$email_template->created_at = Carbon::now();
        $email_template->save();

        return redirect()->route('email-template.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $email_template = EmailTemplate::findorfail($id);

        return view('admin.cms.email_template.show', compact('title', 'email_template'));
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
        $email_template = EmailTemplate::findorfail($id);

        return view('admin.cms.email_template.edit', compact('title', 'email_template'));
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
            'subject'   =>  'required',
            'content'  =>  'required',
            'status'   =>  'required',
        ]);

        $email_template = EmailTemplate::findorfail($id);
        $email_template->title = $request->title;
        $email_template->subject = $request->subject;
        $email_template->content = $request->content;
        $email_template->status = $request->status;
        $email_template->updated_at = Carbon::now();
        $email_template->save();

        return redirect()->route('email-template.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        EmailTemplate::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $title = $this->title;
        $search = $request->search;
        $email_template = EmailTemplate::search($search)->orderBy('view_order', 'asc')->paginate($this->systemSetting()->pagination);

        return view('admin.cms.email_template.index', compact('title', 'email_template'));
    }
}
