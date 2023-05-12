<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\MessageTemplate;
use App\Notification;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->module = 'INSURANCE_APPLICATION';
        $this->middleware('grant.permission:'.$this->module);

        $this->title = __('constant.NOTIFICATION');
        $this->module = 'NOTIFICATION';

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
        if(Auth::user()->admin_role==1)
	    {
	     $message_template = Notification::where('insurance_id', null)->where('quotaton_id', null)->latest()->paginate($this->pagination);   
	    }
	    else
	    {
        $message_template = Notification::where('partner_id', $this->user->id)->latest()->paginate($this->pagination);
	    }

        return view('admin.notification.index', compact('title', 'message_template'));
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
        $message_template = Notification::findorfail($id);
        $message_template->status = 2;
        $message_template->save();

        return view('admin.notification.show', compact('title', 'message_template'));
    }

    public function showRedirect($id)
    {
        $title = $this->title;
        $message_template = Notification::where('partner_id', $this->user->id)->findorfail($id);
        $message_template->status = 2;
        $message_template->save();

        return redirect($message_template->link);
    }

    public function search(Request $request)
    {

        $title = $this->title;
        $query = Notification::where('partner_id', $this->user->id);
        if($request->search1)
        {
            $query->where('message', 'like', '%'.$request->search1.'%');
        }

        if($request->status)
        {
            $query->where('status', $request->status);
        }

        $message_template = $query->latest()->paginate($this->pagination);
        if($request->search1)
        {
            $message_template->appends('search3', $request->search1);
        }
        if($request->status)
        {
            $message_template->appends('status', $request->status);
        }
        return view('admin.notification.index', compact('title', 'message_template'));
    }
}
