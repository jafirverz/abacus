<?php

namespace App\Http\Controllers;

use App\Level;
use App\LevelTopic;
use App\Order;
use App\OrderDetail;
use App\QuestionTemplate;
use App\TempCart;
use App\Worksheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware(function ($request, $next) {
            $this->student_id = Auth::user()->id;
            $this->previous = url()->previous();
            return $next($request);

        });
    }

    public function index($slug = null){
        $checkSlug = Level::where('slug', $slug)->first();
        if($checkSlug){
            $levelId = $checkSlug->id;
            $levelTitle = $checkSlug->title;
            $levelDescription = $checkSlug->description;
            $levelTopics = LevelTopic::where('level_id', $levelId)->pluck('worksheet_id')->toArray();
            //$worksheetsQuestionTemplate = Worksheet::whereIn('id', $levelTopics)->pluck('question_template_id')->toArray();
            $worksheetsQuestionTemplate = Worksheet::whereHas('questions')->whereIn('id', $levelTopics)->where('status', 1)->pluck('question_template_id')->toArray();
            $worksheets = Worksheet::whereHas('questions')->whereIn('id', $levelTopics)->where('status', 1)->orderBy('title', 'asc')->get();
            $qestionTemplate = QuestionTemplate::whereIn('id', $worksheetsQuestionTemplate)->orderBy('order_by', 'asc')->get();
            $todayDate = date('Y-m-d');
            $checkUserPurchase = Order::where('user_id', Auth::user()->id)->where('payment_status', 'COMPLETED')->pluck('id')->toArray();
            $orderDetails = OrderDetail::whereIn('order_id', $checkUserPurchase)->where('expiry_date', '>=', $todayDate)->where('order_type', 'level')->pluck('level_id')->toArray();
            if(in_array($levelId, $orderDetails)){
                $premium = 1;
            }else{
                $premium = 0;
            }
            $checkTempCart = TempCart::where('user_id', Auth::user()->id)->where('type', 'level')->where('level_id', $levelId)->first();
            if($checkTempCart){
                $addedToCart = 1;
            }else{
                $addedToCart = 0;
            }
            // $view_name = 'account.level_details';
            // $view_data = compact("qestionTemplate", 'checkSlug', 'worksheets', 'premium', 'addedToCart');
            // $content = view($view_name, $view_data);

            // return response($content)->header('Cache-Control', 'no-cache, must-revalidate');

            return view('account.level_details', compact("qestionTemplate", 'checkSlug', 'worksheets', 'premium', 'addedToCart', 'levelTopics'));
        }else{
            return abort(404);
        }
    }
}
