<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\LoanCalculatorCashDiscount;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanCalculatorSettingController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.LOAN_CALCULATOR_SETTINGS');
        $this->module = 'LOAN_CALCULATOR_SETTINGS';
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

        $loan_calculator_settings = LoanCalculatorCashDiscount::first();

        return view('admin.account.loan_settings.index', compact('title', 'loan_calculator_settings'));
    }

    public function store(Request $request)
    {
        $messages = [
            'before_cash_discount.*.required' => 'The Before cash discount fields are required.',
            'after_cash_discount.*.required' => 'The After cash discount fields are required.',
        ];

        $request->validate([
            'before_cash_discount.*' => 'required',
            'after_cash_discount.*' => 'required',
            'downpayment_percent' => 'required',
            'loanamount_percent' => 'required',
        ], $messages);

        $loan_calculator_settings = LoanCalculatorCashDiscount::first();
        if(!$loan_calculator_settings)
        {
            $loan_calculator_settings = new LoanCalculatorCashDiscount;
        }
        $loan_calculator_settings->before_cash_rebate = $request->before_cash_discount ? json_encode($request->before_cash_discount) : null;
        $loan_calculator_settings->after_cash_rebate = $request->after_cash_discount ? json_encode($request->after_cash_discount) : null;
        $loan_calculator_settings->downpayment_percent = $request->downpayment_percent;
        $loan_calculator_settings->loanamount_percent = $request->loanamount_percent;
        $loan_calculator_settings->save();

        return redirect()->back()->with('success', 'Loan settings has been updated.');
    }
}
