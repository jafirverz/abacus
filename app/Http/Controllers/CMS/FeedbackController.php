<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserFeedback;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    //
    use SystemSettingTrait, GetEmailTemplate;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.FEEDBACK');
        $this->module = 'FEEDBACK';
        $this->middleware('grant.permission:' . $this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    public function index(){
        $title = 'Student Feedback';
        $feedback = UserFeedback::paginate($this->pagination);
        return view('admin.account.customer.studentfeedback', compact('title', 'feedback'));
    }
}
