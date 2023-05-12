<?php

namespace App\Exports;
use App\CarEnquiry;
use App\CarNotification;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use auth;
class EnquiryExport implements FromView
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
		$enquiries=CarEnquiry::join('car_list','car_list.id','=','car_enquiries.new_stock_id')->select('car_list.*','car_enquiries.created_at as notified_date')->searchExport($this->get)->where('car_enquiries.user_id',auth::user()->id)->get();
	    //dd(DB::getQueryLog());
	    return view('excel.enquiry-history', compact('enquiries'));
    }
}
