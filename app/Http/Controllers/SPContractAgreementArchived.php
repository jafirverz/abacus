<?php

namespace App\Http\Controllers;

use App\SellerParticular;
use App\Traits\GetEmailTemplate;
use App\Traits\GetMessageTemplate;
use App\Traits\GetSmartBlock;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SPContractAgreementArchived extends Controller
{
    use SystemSettingTrait,  GetEmailTemplate, GetMessageTemplate, GetSmartBlock;

    public function __construct()
    {
        $this->middleware('auth:web');
		$this->system_settings = $this->systemSetting();
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = 'Forms';
        $seller_particular = SellerParticular::whereHas('vehicleparticular')->where(function($query) {
            $query->where('user_id', $this->user->id)->orWhere('buyer_email', $this->user->email);
        })->where(function($query) {
            $query->whereIn('seller_archive', [$this->user->id])->orwhereIn('buyer_archive', [$this->user->id]);
        })->paginate($this->pagination);

        return view('sp_agreement.archive.index', compact('title', 'seller_particular'));
    }

    public function active($id)
    {
        $buyer_ids = SellerParticular::where('id', $id)->where('buyer_email', $this->user->email)->first();
        if($buyer_ids)
        {
            $buyer_ids->buyer_archive = 0;
            $buyer_ids->save();
        }
        $seller_ids = SellerParticular::where('id', $id)->where('user_id', $this->user->id)->first();
        if($seller_ids)
        {
            $seller_ids->seller_archive = 0;
            $seller_ids->save();
        }

        return redirect()->back()->with('success',  'S&P Contract Form has been set active');
    }
}
