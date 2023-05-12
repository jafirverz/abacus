<?php

namespace App\Http\Controllers\CMS;

use App\BuyerLoanDetail;
use App\BuyerParticular;
use App\BuyerPaymentTermCondition;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\SellerParticular;
use App\SpContractTerm;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use App\User;
use App\VehicleParticular;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SPAgreementArchiveController extends Controller
{
    use SystemSettingTrait, GetEmailTemplate;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.SP_AGREEMENT');
        $this->module = 'SP_AGREEMENT';
        $this->middleware('grant.permission:'.$this->module);
        $this->system_settings = $this->systemSetting();
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = $this->title;
        $seller_particular = SellerParticular::archived()->paginate($this->pagination);

        return view('admin.sp_agreement.archive.index', compact('title', 'seller_particular'));
    }

    public function show($id)
    {
        $title = $this->title;
        $seller_particular = SellerParticular::findorfail($id);
        $buyer_particular = BuyerParticular::where('seller_particular_id', $seller_particular->id)->first();
        $system_settings = $this->system_settings;
        return view('admin.sp_agreement.archive.show', compact('title', 'seller_particular', 'buyer_particular', 'system_settings'));
    }

    public function search(Request $request)
    {
        $title = $this->title;
        $query = SellerParticular::archived();
        if($request->search1)
        {
            $user = User::where('name', 'like', '%'.$request->search1.'%')->orWhere('email', 'like', '%'.$request->search1.'%')->orWhere('mobile', 'like', '%'.$request->search1.'%')->get();
            $query->whereIn('user_id', $user->pluck('id'));
        }

        if($request->search2)
        {
            $vehicle_particular = VehicleParticular::where(function($inner_query) use($request) {
                return $inner_query->where('make', 'like', '%'.$request->search2.'%')->orwhere('model', 'like', '%'.$request->search2.'%')->orwhere('registration_no', 'like', '%'.$request->search2.'%');
            });
            $query->whereIn('id', $vehicle_particular->pluck('id'));
        }

        if($request->search3)
        {
            $query->where('nric', 'like', '%'.$request->search3.'%');
        }

        if($request->status)
        {
            $query->where('status', $request->status);
        }

        $seller_particular = $query->paginate($this->pagination);
        if($request->search1)
        {
            $seller_particular->appends('search1', $request->search1);
        }
        if($request->search2)
        {
            $seller_particular->appends('search2', $request->search2);
        }
        if($request->search3)
        {
            $seller_particular->appends('search3', $request->search3);
        }
        if($request->status)
        {
            $seller_particular->appends('status', $request->status);
        }
        return view('admin.sp_agreement.archive.index', compact('title', 'seller_particular'));
    }

    public function destroy(Request $request, $id)
    {
        $id = explode(',', $request->multiple_delete);
        SellerParticular::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function active(Request $request, $id)
    {
        $seller_particular = SellerParticular::findorfail($id);
        $seller_particular->seller_archive = 0;
        $seller_particular->buyer_archive = 0;
        $seller_particular->save();

        return redirect()->back()->with('success', $this->title.' has been set active.');
    }
}
