<?php

namespace App\Exports;

//use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorksheetExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $allOrders;

    public function __construct($allOrders)
    {
        $this->allOrders = $allOrders;
    }
    public function view(): View
    {
        //dd($this->allOrders);
        // $training_request = AppTrainingRequest::join('users', 'users.id', '=', 'training_requests.staff_id')->whereIn('training_requests.id', $this->allUsers)->orderBy('training_requests.updated_at', 'desc')->select('training_requests.created_at as training_requests_created_at', 'training_requests.id as training_request_id', 'training_requests.*', 'users.*')->get();
        $allOrders = $this->allOrders;

        return view('admin.excel.worksheet', compact('allOrders'));
    }
}
