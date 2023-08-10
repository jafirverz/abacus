<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.ORDERS');
        $this->module = 'ORDERS';
        $this->middleware('grant.permission:'.$this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(){
        $title = $this->title;
        $orders = Order::paginate($this->pagination);
        return view('admin.cms.orders.index', compact('title', 'orders'));
    }

    public function show($id)
    {
        $title = $this->title;
        $orderDetails = OrderDetail::where('order_id', $id)->get();
        return view('admin.cms.orders.show', compact('title', 'orderDetails'));
    }
}
