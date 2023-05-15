<?php

namespace App\Http\Controllers\CMS;

use App\ActivityLog;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
{
    use SystemSettingTrait;
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.ACTIVITYLOG');
        $this->module = 'ACTIVITY_LOG';
        $this->middleware('grant.permission:'.$this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = $this->title;
        $activity_log = ActivityLog::join('admins', 'activity_log.causer_id', '=', 'admins.id')->orderBy('activity_log.created_at', 'desc')->select('activity_log.updated_at as activity_log_updated', 'activity_log.id as acid', 'admins.id as aid', 'activity_log.*', 'admins.*')->paginate($this->pagination);

        return view('admin.activity_log.index', compact('title', 'activity_log'));
    }

    public function show($id)
    {
        $title = $this->title;
        $activity_log = ActivityLog::join('admins', 'activity_log.causer_id', '=', 'admins.id')->where('activity_log.id', $id)->orderBy('activity_log.created_at', 'desc')->select('activity_log.updated_at as activity_log_updated', 'activity_log.id as acid', 'admins.id as aid', 'activity_log.*', 'admins.*')->firstorfail();

        return view('admin.activity_log.show', compact('title', 'activity_log'));
    }

    public function search(Request $request)
    {
        ///DB::enableQueryLog();
		$title = $this->title;
        $activity_log = ActivityLog::join('admins', 'activity_log.causer_id', '=', 'admins.id')->orderBy('activity_log.created_at', 'desc')->select('activity_log.updated_at as activity_log_updated', 'activity_log.id as acid', 'admins.id as aid', 'activity_log.*', 'admins.*')->search($request)->orderBy('activity_log.created_at','desc')->paginate($this->pagination);
//dd(DB::getQueryLog());
        return view('admin.activity_log.index', compact('title', 'activity_log'));
    }
	
	public function destroy(Request $request)
    {
        //
		$id = explode(',', $request->multiple_delete);
		//dd($id);
        try {
            ActivityLog::destroy($id);
        } catch (QueryException $e) {

            if ($e->getCode() == "23000") {

                //!!23000 is sql code for integrity constraint violation
                return redirect()->back()->with('error',  __('constant.FOREIGN', ['module'    =>  $this->title]));
            }
        }
        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }
}
