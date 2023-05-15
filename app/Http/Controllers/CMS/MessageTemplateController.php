<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\MessageTemplate;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageTemplateController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.MESSAGE_TEMPLATE');
        $this->module = 'MESSAGE_TEMPLATE';
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
        $message_template = MessageTemplate::orderBy('id', 'asc')->paginate($this->pagination);

        return view('admin.cms.message_template.index', compact('title', 'message_template'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;

        return view('admin.cms.message_template.create', compact('title'));
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
            'status'   =>  'required',
        ]);

        $message_template = new MessageTemplate;
        $message_template->title = $request->title;
        $message_template->content = $request->content;
        $message_template->status = $request->status;
		$message_template->created_at = Carbon::now();
        $message_template->save();

        return redirect()->route('message-template.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $message_template = MessageTemplate::findorfail($id);

        return view('admin.cms.message_template.show', compact('title', 'message_template'));
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
        $message_template = MessageTemplate::findorfail($id);

        return view('admin.cms.message_template.edit', compact('title', 'message_template'));
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
            'status'   =>  'required',
        ]);

        $message_template = MessageTemplate::findorfail($id);
        $message_template->title = $request->title;
        $message_template->content = $request->content;
        $message_template->status = $request->status;
        $message_template->updated_at = Carbon::now();
        $message_template->save();

        return redirect()->route('message-template.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        MessageTemplate::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $title = $this->title;
        $search = $request->search;
        $message_template = MessageTemplate::search($search)->orderBy('view_order', 'asc')->paginate($this->systemSetting()->pagination);

        return view('admin.cms.message_template.index', compact('title', 'message_template'));
    }
}
