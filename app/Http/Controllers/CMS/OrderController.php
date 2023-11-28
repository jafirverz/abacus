<?php

namespace App\Http\Controllers\CMS;

use App\Country;
use App\Http\Controllers\Controller;
use App\Level;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;
use App\Traits\SystemSettingTrait;
use App\User;
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

    public function create()
    {
        $title = $this->title;
        $students = User::whereIn('user_type_id', [1,2])->orderBy('id', 'desc')->get();
        $levels = Level::get();
        return view('admin.cms.orders.create', compact('title', 'students', 'levels'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'amount'  =>  'required',
            'studen'    =>  'required',
            'expirydate'   =>  'required',
            'level'   =>  'required',
        ]);
        $user = User::where('id', $request->studen)->first();
        $order = new Order();
        $order->user_id = $request->studen;
        $order->country_id = $user->country_code;
        $order->total_amount = $request->amount;
        $order->payment_status = 'COMPLETED';
        $order->save();

        foreach($request->level as $levee){
            $level = Level::where('id', $levee)->first();
            $orderDetails = new OrderDetail();
            $orderDetails->user_id = $request->studen;
            $orderDetails->order_id = $order->id;
            $orderDetails->level_id = $levee;
            $orderDetails->order_type = 'level';
            $orderDetails->name = $level->title;
            $orderDetails->amount = $request->amount;
            $orderDetails->expiry_date = $request->expirydate;
            $orderDetails->save();
        }
        return redirect()->route('orders.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
        //return view('admin.cms.orders.create', compact('title', 'students', 'levels'));
    }
}
