<?php

namespace App\Exports;
use App\CarEnquiry;
use App\CarNotification;
use App\ProformaInvoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use auth;
class TransactionExport implements FromView
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
	    $transactions=ProformaInvoice::join('car_enquiries','proforma_invoices.id','=','car_enquiries.id')->join('car_list','car_list.id','=','car_enquiries.new_stock_id')->select('car_list.*','car_enquiries.created_at as notified_date','car_enquiries.id as car_enquiry_id','car_enquiries.status as car_enquiry_status','proforma_invoices.transaction_no')->searchExport($this->get)->where('car_enquiries.user_id',auth::user()->id)->get();	

		//dd(DB::getQueryLog());
	    return view('excel.transactions-history', compact('transactions'));
    }
}
