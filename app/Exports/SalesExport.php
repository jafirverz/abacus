<?php

namespace App\Exports;

use App\Order;
use App\User;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesExport implements FromView
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
        $allUsers = User::whereIn('id', $this->allOrders)->get();
        return view('admin.excel.sales', compact('allUsers'));
    }
}
