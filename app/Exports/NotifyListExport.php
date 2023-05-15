<?php

namespace App\Exports;
use App\NotifyParty;
use App\CarNotification;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use auth;
class NotifyListExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
	public function __construct($get)
    {
        $this->get = $get;
    }
	
    public function view(): View
    {
	    //DB::enableQueryLog();
		$notifyParty=CarNotification::join('car_list','car_list.id','=','car_notifications.new_stock_id')->select('car_list.*','car_notifications.created_at as notified_date')->searchExport($this->get)->where('car_notifications.user_id',Auth::user()->id)->get();
	    //dd(DB::getQueryLog());
	   return view('excel.notify-party', compact('notifyParty'));
    }
}
