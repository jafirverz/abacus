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
    public function index($slug = null){
        $checkSlug = Level::where('slug', $slug)->first();
        if($checkSlug){
            $levelId = $checkSlug->id;
            $levelTitle = $checkSlug->title;
            $levelDescription = $checkSlug->description;
            $levelTopics = LevelTopic::where('level_id', $levelId)->pluck('worksheet_id')->toArray();
            $worksheetsQuestionTemplate = Worksheet::whereIn('id', $levelTopics)->pluck('question_template_id')->toArray();
            $worksheets = Worksheet::whereHas('questions')->whereIn('id', $levelTopics)->get();
            $qestionTemplate = QuestionTemplate::whereIn('id', $worksheetsQuestionTemplate)->get();
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
            return view('account.level_details', compact("qestionTemplate", 'checkSlug', 'worksheets', 'premium', 'addedToCart'));
        }else{
            return abort(404);
        }
    }
}
