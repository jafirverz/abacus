<?php

namespace App\Http\Controllers;

use App\Loan;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanApplicationController extends Controller
{
    use SystemSettingTrait, GetEmailTemplate;

    public function __construct()
    {
        $this->middleware('auth:web')->except('show');
		$this->system_settings = $this->systemSetting();
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = 'Loan Applications';
        $loan_application = Loan::where('user_id', $this->user->id)->paginate($this->pagination);

        return view('loan_application.index', compact('title', 'loan_application'));
    }

    public function show(Request $request, $reference_id, $id)
    {
        $request->session()->put('previous_url', url()->current());

        if(Auth::check())
        {
            $title = 'Loan Applications';
            $loan_application = Loan::where('user_id', $this->user->id)->where('id', $id)->where('created_at', date('Y-m-d H:i:s', $reference_id))->first();
            if(!$loan_application)
            {
                return abort(403, "Unauthorized access.");
            }

            return view('loan_application.show', compact('title', 'loan_application'));
        }
        else
        {
            return $this->loginRedirect();
        }
    }

    public function otherDocs($reference_id, $id)
    {
        $title = 'Other Documents';
        $loan_application = Loan::where('user_id', $this->user->id)->where('id', $id)->where('created_at', date('Y-m-d H:i:s', $reference_id))->firstorfail();

        return view('loan_application.other_docs', compact('title', 'loan_application'));
    }
    
    public function archive(Request $request){
        $id = $request->multiple_archive;
        $expId = explode(',', $id);
        foreach($expId as $id){
            $chkId = Loan::where('id', $id)->first();
            if($chkId){
                $chkId->form_archived = 1;
                $chkId->save();
            }
        }
        return redirect()->back()->with('success', 'Application archived.');
    }

    public function showarchived()
    {
        $title = 'Loan Archived';
        $loan_application = Loan::where('user_id', $this->user->id)->where('form_archived', 1)->paginate($this->pagination);

        return view('loan_application.archived', compact('title', 'loan_application'));
    }
}
