<?php

namespace App\Http\Controllers;

use App\Admin;
use App\CompetitionPaper;
use App\Level;
use App\Order;
use App\OrderDetail;
use App\Payment;
use App\TempCart;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Auth;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Mail;

class PayPalController extends Controller
{
    use GetEmailTemplate, SystemSettingTrait;
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
            $order->country_id =  Auth::user()->country_code;
            $order->total_amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $order->payment_status = $response['status'];
            $order->save();

            $tempCart  = TempCart::where('user_id', $userId)->get();
            if($tempCart){
                foreach($tempCart as $cart){
                    if($cart->type == 'level'){
                        $orderDetails = new OrderDetail();
                        $cartt = json_decode($cart->cart);
                        $orderDetails->order_id = $order->id;
                        $orderDetails->user_id = Auth::user()->id;
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
                    }elseif($cart->type == 'physicalcompetition'){
                        $orderDetails = new OrderDetail();
                        $cartt = json_decode($cart->cart);
                        $orderDetails->order_id = $order->id;
                        $orderDetails->user_id = Auth::user()->id;
                        //$paper = CompetitionPaper::where('id', $cartt->id)->first();
                        // $months = $paper->premium_months;
                        // $todayDate = date('Y-m-d');
                        // $expiryDate = date('Y-m-d', strtotime("+$months months", strtotime($todayDate)));
                        $orderDetails->order_type = $cart->type;
                        $orderDetails->comp_paper_id = $cartt->id;
                        $orderDetails->name = $cartt->name;
                        $orderDetails->amount = $cartt->amount;
                        // $orderDetails->expiry_date = $expiryDate;
                        $orderDetails->save();
                    }elseif($cart->type == 'onlinecompetition'){
                        $orderDetails = new OrderDetail();
                        $cartt = json_decode($cart->cart);
                        $orderDetails->order_id = $order->id;
                        $orderDetails->user_id = Auth::user()->id;
                        //$paper = CompetitionPaper::where('id', $cartt->id)->first();
                        // $months = $paper->premium_months;
                        // $todayDate = date('Y-m-d');
                        // $expiryDate = date('Y-m-d', strtotime("+$months months", strtotime($todayDate)));
                        $orderDetails->order_type = $cart->type;
                        $orderDetails->comp_paper_id = $cartt->id;
                        $orderDetails->name = $cartt->name;
                        $orderDetails->amount = $cartt->amount;
                        // $orderDetails->expiry_date = $expiryDate;
                        $orderDetails->save();
                    }
                    
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
            $toEmail = Auth::user()->email;
            $userName = Auth::user()->name;
            $userEmail = Auth::user()->email;
            // Admin email for New Order
			$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_NEW_ORDER'));
            $admins = Admin::get();
            if ($email_template) {
                $data = [];
                foreach($admins as $admin){
                    $data['email_sender_name'] = systemSetting()->email_sender_name;
                    $data['from_email'] = systemSetting()->from_email;
                    $data['to_email'] = [$admin->email];
                    $data['cc_to_email'] = [];
                    $data['subject'] = $email_template->subject;


                    $key = ['{{full_name}}','{{email}}','{{order_id}}','{{order_amount}}','{{order_status}}'];
                    $value = [$request->name, $userEmail, $order->id, $order->total_amount, $order->payment_status];

                    $newContents = str_replace($key, $value, $email_template->content);

                    $data['contents'] = $newContents;
                    try {
                        $mail = Mail::to($admin->email)->send(new EmailNotification($data));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }

            }

            // Admin email for New Order
			$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_USER_NEW_ORDER'));
            //$admins = Admin::get();
            if ($email_template) {
                $data = [];
                foreach($admins as $admin){
                    $data['email_sender_name'] = systemSetting()->email_sender_name;
                    $data['from_email'] = systemSetting()->from_email;
                    $data['to_email'] = [$toEmail];
                    $data['cc_to_email'] = [];
                    $data['subject'] = $email_template->subject;


                    $key = ['{{full_name}}','{{email}}','{{order_id}}','{{order_amount}}','{{order_status}}'];
                    $value = [$request->name, $userEmail, $order->id, $order->total_amount, $order->payment_status];

                    $newContents = str_replace($key, $value, $email_template->content);

                    $data['contents'] = $newContents;
                    try {
                        $mail = Mail::to($admin->email)->send(new EmailNotification($data));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
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
