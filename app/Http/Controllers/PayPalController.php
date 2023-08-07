<?php

namespace App\Http\Controllers;

use App\Level;
use App\Order;
use App\OrderDetail;
use App\Payment;
use App\TempCart;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Auth;

class PayPalController extends Controller
{
    //
    //public function payment()
    // {
    //     $provider = new PayPalClient;
    //     $provider->setApiCredentials(config('paypal'));
    //     $paypalToken = $provider->getAccessToken();
    //     //dd($paypalToken);
    //     $response = $provider->createOrder([
    //         "intent" => "CAPTURE",
    //         "application_context" => [
    //             "return_url" => route('successTransaction'),
    //             "cancel_url" => route('cancelTransaction'),
    //         ],
    //         "purchase_units" => [
    //             0 => [
    //                 "amount" => [
    //                     "currency_code" => "USD",
    //                     "value" => "1.00"
    //                 ]
    //             ]
    //         ]
    //     ]);
    //     if (isset($response['id']) && $response['id'] != null) {
    //         // redirect to approve href
    //         foreach ($response['links'] as $links) {
    //             if ($links['rel'] == 'approve') {
    //                 return redirect()->away($links['href']);
    //             }
    //         }
    //         return redirect()
    //             ->route('createTransaction')
    //             ->with('error', 'Something went wrong.');
    //     } else {
    //         return redirect()
    //             ->route('createTransaction')
    //             ->with('error', $response['message'] ?? 'Something went wrong.');
    //     }
    //}
   
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    // public function cancel()
    // {
    //     dd('Your payment is canceled. You can create cancel page here.');
    // }
  
    // /**
    //  * Responds with a welcome message with instructions
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function success(Request $request)
    // {
    //     $response = $provider->getExpressCheckoutDetails($request->token);
  
    //     if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
    //         dd('Your payment was successfully. You can create success page here.');
    //     }
  
    //     dd('Something is wrong.');
    // }


    public function processTransaction(Request $request)
    {
        $totalAmount = $request->totalAmount;
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $totalAmount
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('createTransaction')
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('createTransaction')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        //dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $userId = Auth::user()->id;
            $order = new Order();
            $order->user_id = $userId;
            $order->total_amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $order->payment_status = $response['status'];
            $order->save();

            $tempCart  = TempCart::where('user_id', $userId)->get();
            if($tempCart){
                foreach($tempCart as $cart){
                    $orderDetails = new OrderDetail();
                    $cartt = json_decode($cart->cart);
                    $orderDetails->order_id = $order->id;
                    if($cart->type == 'level'){
                        $orderDetails->level_id = $cartt->id;
                    }
                    $levels = Level::where('id', $cartt->id)->first();
                    $months = $levels->premium_months;
                    $todayDate = date('Y-m-d');
                    $expiryDate = date('Y-m-d', strtotime("+$months months", strtotime($todayDate)));
                    $orderDetails->order_type = $cart->type;
                    $orderDetails->name = $cartt->name;
                    $orderDetails->amount = $cartt->amount;
                    $orderDetails->expiry_date = $expiryDate;
                    $orderDetails->save();
                }
            }
            

            $payment = new Payment();
            $payment->user_id = $userId;
            $payment->order_id = $order->id;
            $payment->transaction_id = $response['id'];
            $payment->currency_code = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
            $payment->payment_status = $response['status'];
            $payment->save();

            if($tempCart){
                foreach($tempCart as $cart){
                    $cart->delete();
                }
            }

            // return view('account.success', compact("cartDetails"));
            // return redirect()
            //     ->route('createTransaction')
            //     ->with('success', 'Transaction complete.');
            return redirect()
                ->route('successTransactionn')
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('errorTransaction')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        //dd("cancel transaction");
        return redirect()
            ->route('errorTransaction')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    public function successPayment(){
        return view('account.success');
    }

    public function errorPayment(){
        return view('account.error');
    }
}
