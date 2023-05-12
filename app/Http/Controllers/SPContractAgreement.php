<?php

namespace App\Http\Controllers;

use App\BuyerLoanDetail;
use App\BuyerParticular;
use App\BuyerPaymentTermCondition;
use App\Jobs\SendEmail;
use App\SellerParticular;
use App\SpContractTerm;
use App\Traits\GetEmailTemplate;
use App\Traits\GetMessageTemplate;
use App\Traits\GetSmartBlock;
use App\Traits\SystemSettingTrait;
use App\User;
use App\VehicleMain;
use App\VehicleParticular;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Support\Facades\Session;

class SPContractAgreement extends Controller
{
    use SystemSettingTrait,  GetEmailTemplate, GetMessageTemplate, GetSmartBlock;

    public function __construct()
    {
        $this->middleware('auth:web');
		$this->system_settings = $this->systemSetting();
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = 'Forms';
        $seller_particular = SellerParticular::whereHas('vehicleparticular')->where(function($query) {
            $query->where('user_id', $this->user->id)->orWhere('buyer_email', $this->user->email);
        })->where(function($query) {
            $query->whereNotIn('seller_archive', [$this->user->id])->whereNotIn('buyer_archive', [$this->user->id]);
        })->paginate($this->pagination);

        return view('sp_agreement.index', compact('title', 'seller_particular'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $messages = [
            // 'seller_name.required' => 'The Name field is required.',
            // 'nric.required' => 'The NRIC field is required.',
            // // 'hp_no.required' => 'The H/P No. field is required.',
            // 'country_code.required' => 'The Buyers country code field is required.',
            // 'country_code.regex' => 'The Buyers country code entered is invalid.',
            // 'buyer_mobile.required' => 'The Buyers mobile no. field is required.',
            // 'buyer_mobile.numeric' => 'The Buyers mobile no. field should be numeric.',
            // 'make.required' => 'The Vehicle make field is required.',
            // 'registration_no.required' => 'The Original registration no field is required.',
            // 'model.required' => 'The Vehicle model field is required.',
            // 'registration_date' => 'The Original registration date field is required.',

            'seller_name.required' => 'This field is required',
            'nric.required' => 'This field is required',
            // 'hp_no.required' => 'The H/P No. field is required.',
            'country_code.required' => 'This field is required',
            'country_code.regex' => 'This field is required',
            'buyer_mobile.required' => 'This field is required',
            'buyer_mobile.numeric' => 'This field is required',
            'make.required' => 'This field is required',
            'registration_no.required' => 'This field is required',
            'model.required' => 'This field is required',
            'registration_date' => 'This field is required',

            'gender.required' => 'This field is required',
            'seller_mobile.required' => 'This field is required',
            'seller_email.required' => 'This field is required',
            'address.required' => 'This field is required',
            'registration_no.required' => 'This field is required',
            'make.required' => 'This field is required',
            'model.required' => 'This field is required',
            'registration_date.required' => 'This field is required',
            'first_registration_Date.required' => 'This field is required',
            'year_of_manufacturer.required' => 'This field is required',
            'engine_no.required' => 'This field is required',
            'chassis_no.required' => 'This field is required',
            'no_of_transfer.required' => 'This field is required',
            'color.required' => 'This field is required',
            'coe_expiry_date.required' => 'This field is required',
            'road_tax_expiry_date.required' => 'This field is required',
            'engine_output.required' => 'This field is required',
            'open_market_value.required' => 'This field is required',
            'arf_paid.required' => 'This field is required',
            'vehicle_type.required' => 'This field is required',
            'vehicle_scheme.required' => 'This field is required',
            'iu_label_number.required' => 'This field is required',
            'selling_price.required' => 'This field is required',
            'deposit.required' => 'This field is required',
            'balance_payment.required' => 'This field is required',
            'buyer_email.required' => 'This field is required',
            'buyer_mobile.required' => 'This field is required',
            'terms.required' => 'This field is required',
        ];

        // if($request->savebutton == 'submitSaved'){
        // }else{
            // if (!Session::get('myinfospagreement')) {
                $request->validate([
                // 'company_name' => 'required|max:191',
                'seller_name' => 'required|max:191',
                'nric' => 'required|max:191',
                // 'uen' => 'required|max:191|min:4|max:4',
                // 'passport' => 'required|max:191|min:4|max:4',
                'seller_country_code' => 'required',
                // 'postal_code' => 'required|max:191|min:4|max:6',
                'engine_no' => 'required',
                'chassis_no' => 'required',
                'engine_output' => 'required',
                'vehicle_type' => 'required',
                'registration_no' => 'required',
                'address' => 'required', ////////////////////
                'coe_expiry_date' => 'required',
                'road_tax_expiry_date' => 'required',
                'open_market_value' => 'required',
                'vehicle_scheme' => 'required',
                'iu_label_number' => 'required',
    
                'make' => 'required',
                'model' => 'required',
                'color' => 'required',
                'year_of_manufacturer' => 'required',
                'no_of_transfer' => 'required',
                'first_registration_Date' => 'required',
                // 'hp_no' => 'required|max:191',
                'seller_email' => 'required|email',
                'gender' => 'required',
                'seller_mobile' => 'required|numeric',
                'buyer_email' => 'required|email|max:191',
                'country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',
                'buyer_mobile' => 'required|numeric',
                'registration_date' => 'required',
                'arf_paid' => 'required',
                'terms' => "required|array|min:1",
                'selling_price' => 'required',
                'deposit' => 'required',
                'balance_payment' => 'required',
                ], $messages);
            // }else{
            //     $request->validate([
            //         'seller_email' => 'required|email',
            //         'seller_mobile' => 'required|numeric',
            //         'buyer_email' => 'required|email|max:191',
            //         'country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',
            //         'buyer_mobile' => 'required|numeric',
            //         'terms' => "required|array|min:1",
            //         'selling_price' => 'required',
            //         'deposit' => 'required',
            //         'balance_payment' => 'required',
            //         ], $messages);
            // }
        // }
        
        try
        {
            if(!empty($request->carId)){
                $carId = $request->carId;
            }else{
                $carId = 0;
            }

            // if($request->sendEmailandW == 1){
            if($request->savebutton == 'submitSaved'){
                $seller_particular_id = $request->seller_particular;
                $seller_particular = SellerParticular::where('id', $seller_particular_id)->where('issaved', 1)->first();
                $seller_particular->issaved = 0;
                $seller_particular->save();
            }else{

                if($request->savebutton == 'saveUpdate'){
                    $seller_particular_id = $request->seller_particular;
                    $seller_particular = SellerParticular::where('id', $seller_particular_id)->where('issaved', 1)->first();
                }else{
                    $seller_particular = new SellerParticular;
                }
                $usecar = $request->use; 
                $first_registration_Date = date('Y-m-d', strtotime($request->first_registration_Date));
                
                $seller_particular->user_id = $this->user->id;
                $seller_particular->vehicle_main_id = $carId;
                // $seller_particular->company_name = $request->company_name;
                $seller_particular->seller_name = $request->seller_name;
                $seller_particular->seller_gender = $request->gender; // New
                $seller_particular->address = $request->address;
                $seller_particular->nric = $request->nric;
                $seller_particular->uen = $request->uen; // // new field
                $seller_particular->passport = $request->passport; // new field
                $seller_particular->seller_country_code = $request->seller_country_code; // new field
                $seller_particular->seller_mobile = $request->seller_mobile; // new field
                $seller_particular->seller_email = $request->seller_email; // new field
                $seller_particular->postal_code = $request->postal_code; // new field
                $seller_particular->usecar = $usecar ?? ''; // new field
                $seller_particular->first_registration_Date = $first_registration_Date ?? ''; // new field
                // $seller_particular->hp_no = $request->hp_no;
                $seller_particular->buyer_email = $request->buyer_email;
                $seller_particular->country_code = $request->country_code; // new field
                $seller_particular->buyer_mobile = $request->country_code.$request->buyer_mobile;
                $seller_particular->country_of_residence = $request->country_of_residence;
                $seller_particular->status = 1;
                if($request->savebutton == 'save' || $request->savebutton == 'saveUpdate'){
                    $seller_particular->issaved = 1;
                }
                $seller_particular->save();
                
                if($request->savebutton == 'saveUpdate'){
                    $vehicle_particular = VehicleParticular::where('seller_particular_id', $seller_particular_id)->first();
                }else{
                    $vehicle_particular = new VehicleParticular();
                }
                // $vehicle_particular = new VehicleParticular();
                $vehicle_particular->seller_particular_id = $seller_particular->id;
                $vehicle_particular->registration_no = $request->registration_no;
                $vehicle_particular->make = $request->make;
                $vehicle_particular->model = $request->model;
                $vehicle_particular->registration_date = date('Y-m-d', strtotime($request->registration_date));
                $vehicle_particular->year_of_manufacturer = $request->year_of_manufacturer;
                $vehicle_particular->chassis_no = $request->chassis_no;
                $vehicle_particular->engine_no = $request->engine_no;
                $vehicle_particular->open_market_value = str_replace(',','',$request->open_market_value);
                $vehicle_particular->color = $request->color;
                $vehicle_particular->no_of_transfer = $request->no_of_transfer;
                $vehicle_particular->coe_expiry_date = date('Y-m-d', strtotime($request->coe_expiry_date));
                $vehicle_particular->arf_paid = str_replace(',','',$request->arf_paid);
                $vehicle_particular->vehicle_type = $request->vehicle_type;
                $vehicle_particular->vehicle_scheme = $request->vehicle_scheme; // new
                $vehicle_particular->iu_label_number = $request->iu_label_number; // new
                $vehicle_particular->engine_output = str_replace(',','',$request->engine_output);
                $vehicle_particular->road_tax_expiry_date = date('Y-m-d', strtotime($request->road_tax_expiry_date));
                $vehicle_particular->save();

                if($request->savebutton == 'saveUpdate'){
                    $sp_contract_terms = SpContractTerm::where('seller_particular_id', $seller_particular_id)->first();
                }else{
                    $sp_contract_terms = new SpContractTerm();
                }
                // $sp_contract_terms = new SpContractTerm();
                $sp_contract_terms->seller_particular_id = $seller_particular->id;
                $sp_contract_terms->terms_and_condition = json_encode($request->terms);
                $sp_contract_terms->other_terms = $request->otherconditions; // new field
                $sp_contract_terms->termsdate = $request->termsdate; // new field
                $sp_contract_terms->selling_price = str_replace(',','',$request->selling_price);
                $sp_contract_terms->deposit = str_replace(',','',$request->deposit);
                $balance_payment = round($sp_contract_terms->selling_price - $sp_contract_terms->deposit, 2);
                $sp_contract_terms->balance_payment = str_replace(',','',$request->balance_payment);
                $sp_contract_terms->save();

                if(!empty($carId)){
                    $chageCarStatusToReserve = VehicleMain::where('id', $carId)->first();
                    $chageCarStatusToReserve->status = 2;
                    $chageCarStatusToReserve->save();
                }
            }
            

            if($request->savebutton == 'submit' || $request->savebutton == 'submitSaved'){
                $url = url('forms/form-details/view/'.strtotime($seller_particular->created_at).'/'.$seller_particular->id);
                $url_html = '<a href="'.$url.'">'.$url.'</a>';

                $buyer_name = get_user_detail_by_email($seller_particular->buyer_email) ? get_user_detail_by_email($seller_particular->buyer_email)->name : 'Buyer';

                $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_S_AND_P_AGREEMENT_TO_BUYER'));
                if ($email_template) {
                    $data = [];
                    $buyer_name = get_user_detail_by_email($seller_particular->buyer_email) ? get_user_detail_by_email($seller_particular->buyer_email)->name : 'Buyer';
                    $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                    $data['from_email'] = $this->systemSetting()->from_email;
                    $data['email'] = [$seller_particular->buyer_email];
                    $data['cc_to_email'] = [];

                    $data['subject'] = $email_template->subject;

                    /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

                    $key = ['{{buyer_name}}', '{{seller_name}}', '{{url}}'];
                    $value = [$buyer_name, $seller_particular->seller_name, $url_html];
                    $newContent = str_replace($key, $value, $email_template->content);
                    $data['contents'] = $newContent;

                    try {
                        SendEmail::dispatchNow($data);

                    } catch (Exception $exception) {
                        Log::info($exception);
                        //dd($exception);
                    }
                }
                // send whatsapp message
                $message_template = $this->messageTemplate(__('constant.MESSAGE_TEMPLATE_S_AND_P_AGREEMENT_TO_BUYER'));
                if ($message_template) {

                    $key1 = ['{{buyer_name}}', '{{seller_name}}', '{{url}}'];
                    $value1 = [$buyer_name, $seller_particular->seller_name, $url];
                    $newContent = str_replace($key1, $value1, $message_template->content);

                    try {
                        sendWhatsappMessage($seller_particular->buyer_mobile, $newContent);

                    } catch (Exception $exception) {
                        Log::info($exception);
                        //dd($exception);
                    }
                }
            }
            



        }
        catch(Exception $e)
        {
            return redirect()->back()->with('error', 'Error something went wrong.');
        }
        // return redirect()->back()->with('success', 'Your form details have been submitted successfully.');
        if($seller_particular->issaved == 1){	
            return redirect('/')->with('success', 'Your form details have been submitted successfully.');	
        }else{	 
            return redirect('thank-you')->with('success', 'Your form details have been submitted successfully.');	
        }
    }

    public function buyer_store(Request $request, $slug, $reference, $id)
    {
        // dd($request->all());
        $messages = [
            // 'loan_amount.required_if' => 'Loan amount field is required',
            // // 'month.required_if' => 'The Month field is required when No. of Years and Months is selected.',
            // 'bank_id.required_if' => 'Please select bank and interest rate',
            // 'nric.required' => 'The NRIC field is required.',
            // 'loan_period.required_if' => 'Loan year field is required.',
            // 'loan_months.required_if' => 'Loan month field is required.',

            'loan_amount.required_if' => 'This field is required',
            // 'month.required_if' => 'The Month field is required when No. of Years and Months is selected.',
            'bank_id.required_if' => 'This field is required',
            'nric.required' => 'This field is required',
            'loan_period.required_if' => 'This field is required',
            'loan_months.required_if' => 'This field is required',

            'buyer_name.required' => 'This field is required',
            'nric.required' => 'This field is required',
            'buyer_gender.required' => 'This field is required',
            'country_code.required' => 'This field is required',
            'phone.required' => 'This field is required',
            'email.required' => 'This field is required',
            'address.required' => 'This field is required',
            'terms.required' => 'This field is required',
            'balance.required' => 'This field is required',
        ];
        
        // if($request->saveexit == 'submittr'){
        //     $seller_particular = SellerParticular::where('id', $id)->where('created_at', date('Y-m-d H:i:s', $reference))->where('buyer_email', Auth::user()->email)->firstorfail();
        // }else{
            $request->validate([
                'buyer_name' => 'required',
                'nric' => 'required|max:191',
                'buyer_gender' => 'required',
                'country_code' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'address' => 'required',
                'terms' => "required|array|min:1",
                'loan' => 'required',
                'loan_period' => 'required_if:tenor,2',
                'loan_months' => 'required_if:tenor,2',
                'loan_amount' => 'required_if:loan,1',
                'bank_id' => 'required_if:loan,1',
                'agreed_price' => 'required',
                'balance' => 'required',
                
            ],$messages);

            $seller_particular = SellerParticular::where('id', $id)->where('created_at', date('Y-m-d H:i:s', $reference))->where('buyer_email', Auth::user()->email)->firstorfail();

            if(!empty($request->carId)){
                $carId = $request->carId;
                $buyer_particular = BuyerParticular::where('seller_particular_id', $id)->where('vehicle_main_id', $carId)->first();
            }else{
                $carId = 0;
                $buyer_particular = BuyerParticular::where('seller_particular_id', $id)->first();
            }

            
            if($buyer_particular){
                if($buyer_particular->issaved == 0)
                {
                    return redirect()->back()->with('error', 'Form has already been submitted.');
                }
            }
        // }
        

        try
        {
            // DB::beginTransaction();
            if($request->saveexit == 'submittr'){
                $buyer_particular = BuyerParticular::where('id', $request->idd)->where('issaved', 1)->first();
                if($buyer_particular){
                    $buyer_particular->issaved = 0;
                    $buyer_particular->save();
                }
            }else{
                if($request->saveexit == 'saveeUpdate'){
                    $buyer_particular = BuyerParticular::where('id', $request->idd)->where('issaved', 1)->first();
                }else{
                    $buyer_particular = new BuyerParticular();
                }
                
                // $buyer_particular = new BuyerParticular();
                $buyer_particular->seller_particular_id = $id;
                $buyer_particular->vehicle_main_id = $carId;
                $buyer_particular->user_id = $this->user->id;
                // $buyer_particular->company_name = $request->company_name;
                $buyer_particular->buyer_name = $request->buyer_name;
                $buyer_particular->buyer_nationality = $request->nationality ?? '';
                $buyer_particular->address = $request->address;
                $buyer_particular->nric = $request->nric;
                $buyer_particular->buyer_gender = $request->buyer_gender; // New
                $buyer_particular->agreed_price = str_replace(',','',$request->agreed_price); ///////////// new field
                $buyer_particular->phone = $request->phone; // new field
                // $buyer_particular->uen = $request->uen; // new field
                $buyer_particular->passport = $request->passport; // new field
                $buyer_particular->country_code = $request->country_code; // new field
                $buyer_particular->postal_code = $request->postal_code; // new field
                if($request->loan == 1){
                    $buyer_particular->loan = $request->loan; // new field
                    $buyer_particular->tenor = $request->tenor; // new field
                    $buyer_particular->loan_period = $request->loan_period; // new field
                    $buyer_particular->loan_months = $request->loan_months; // new field
                }else{
                    $buyer_particular->loan = 2; // new field
                    $buyer_particular->tenor = null; // new field
                    $buyer_particular->loan_period = null; // new field
                    $buyer_particular->loan_months = null; // new field
                }
                
                $buyer_particular->deposit_amount = str_replace(',','',$request->deposit_amount); ////////////// new field
                $buyer_particular->balance_payment = str_replace(',','',$request->balance_payment); /////////// new field

                // $buyer_particular->hp_no = $request->hp_no;
                $buyer_particular->country_of_residence = $request->country_of_residence;
                if($request->saveexit == 'savee'){
                    $buyer_particular->issaved = 1;
                }
                
                $buyer_particular->save();

                if($request->loan == 1){
                    $bankAndInterest = explode('/',$request->bank_id);
                    $bankName = $bankAndInterest[0];
                    $interest = $bankAndInterest[1];
                    if($request->saveexit == 'saveeUpdate'){
                        $buyer_loan_detail = BuyerLoanDetail::where('buyer_particular_id', $request->idd)->first();
                        if(empty($buyer_loan_detail)){
                            $buyer_loan_detail = new BuyerLoanDetail();
                        }
                    }else{
                        $buyer_loan_detail = new BuyerLoanDetail();
                    }
                    // $buyer_loan_detail = new BuyerLoanDetail();
                    $buyer_loan_detail->buyer_particular_id = $buyer_particular->id;
                    $buyer_loan_detail->loan_amount = str_replace(',','',$request->loan_amount); /////////////////////
                    $buyer_loan_detail->bank = $bankName;
                    $buyer_loan_detail->interest = $interest;
                    // $balance = round($buyer_particular->sellerparticular->spcontract->balance_payment - $buyer_loan_detail->loan_amount, 2);
                    $buyer_loan_detail->balance = str_replace(',','',$request->balance);
                    $buyer_loan_detail->save();
                }else{
                    $buyer_loan_detail = BuyerLoanDetail::where('buyer_particular_id', $request->idd)->first();
                    if($buyer_loan_detail){
                        $buyer_loan_detail->delete();
                    }
                }
                
                if($request->saveexit == 'saveeUpdate'){
                    $buyer_payment_terms_condition = BuyerPaymentTermCondition::where('buyer_particular_id', $request->idd)->first();
                }else{
                    $buyer_payment_terms_condition = new BuyerPaymentTermCondition();
                }
                // $buyer_payment_terms_condition = new BuyerPaymentTermCondition();
                $buyer_payment_terms_condition->buyer_particular_id = $buyer_particular->id;
                $buyer_payment_terms_condition->terms_and_condition = json_encode($request->terms);
                $buyer_payment_terms_condition->otherterms = $request->otherterms; // new field
                $buyer_payment_terms_condition->save();

                $buyerId = $buyer_particular->id ?? '';
                $buyerDetail = BuyerParticular::where('id', $buyerId)->first();
                $pdf = PDF::loadView('spagreement', compact('seller_particular', 'buyer_particular'))->setPaper('a4', 'potrait');
                $path = public_path('pdf');
                $fileName =  $id.'-'.$reference.'-pdfview' . '.' . 'pdf' ;
                $pdf->save($path . '/' . $fileName);
                $buyerDetail->pdf_name = $fileName;
                $buyerDetail->save();
            }
            


            // DB::commit();
            // Storage::put('public/pdf/invoice.pdf', $pdf->output());
            // return $pdf->download('pdfview.pdf');

            if($request->saveexit == 'savee'  || $request->saveexit == 'saveeUpdate'){
            }else{


                	// EMAIL TO Admin
                $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_SP_FORM_BUYER_FILLED_ADMIN'));
                //dd($email_template);
                if ($email_template) {
                    $data = [];

                    $data['email_sender_name'] =  $this->systemSetting()->email_sender_name;
                    // $data['from_email'] = $this->systemSetting()->from_email;
                    $data['from_email'] = $this->systemSetting()->from_email;
                    $data['cc_to_email'] = [];
                    $data['subject'] = $email_template->subject;
                    //dd($partners);

                        $url = url('admin/sp-agreement/' );
                        $link = '<a href="' . $url . '">' . $url . '</a>';
                        
                        $data['email'] = [$this->systemSetting()->to_email];

                        $key = ['{{link}}'];
                        $value = [$link];
                        $newContent = str_replace($key, $value, $email_template->content);
                        $data['contents'] = $newContent;
                        //dd($data);

                        try {
                            SendEmail::dispatchNow($data);
                        } catch (Exception $exception) {
                            //dd($exception);
                        }
                }


                $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_S_AND_P_AGREEMENT_TO_SELLER'));
                if ($email_template) {
                    $data = [];

                    $url = url('forms/form-details/view/'.$reference.'/'.$id);
                    $url = '<a href="'.$url.'">'.$url.'</a>';
                    $username = $buyer_particular->sellerparticular->user->name;

                    $buyer_name = 'Buyer';
                    $buyer = User::find($buyer_particular->user_id);
                    if($buyer)
                    {
                        $buyer_name = $buyer->name;
                    }
                    $registration_no = $seller_particular->vehicleparticular->registration_no;
                    $vehicle_model = $seller_particular->vehicleparticular->model;
                    $vehicle_make = $seller_particular->vehicleparticular->make;

                    $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                    $data['from_email'] = $this->systemSetting()->from_email;
                    $data['email'] = [$buyer_particular->sellerparticular->user->email];
                    $data['cc_to_email'] = [];

                    $data['subject'] = $email_template->subject;

                    /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

                    $key = ['{{username}}', '{{buyer_name}}', '{{registration_no}}', '{{vehicle_make}}', '{{vehicle_model}}', '{{url}}'];
                    $value = [$username, $buyer_name, $registration_no, $vehicle_make, $vehicle_model, $url];
                    $newContent = str_replace($key, $value, $email_template->content);
                    $data['contents'] = $newContent;

                    try {
                        SendEmail::dispatchNow($data);
                    } catch (Exception $exception) {
                        //dd($exception);
                    }
                }
            }
            

        }
        catch(Exception $e)
        {
            Log::info($e);
            return redirect()->back()->with('error', 'Error something went wrong.');
        }
        if($request->saveexit == 'savee'){
            return redirect('/')->with('success', 'Your form details have been submitted successfully.');
        }else{
            return redirect('thank-you')->with('success', 'Your form details have been submitted successfully.');
        }
        
    }

    public function seller_store(Request $request, $slug, $reference, $id)
    {
        $request->validate([
            'signature' => 'required',
        ]);

        $encoded_image = explode(",", $request->signature)[1];
        $decoded_image = base64_decode($encoded_image);

        $seller_particular = SellerParticular::where('id', $id)->where('created_at', date('Y-m-d H:i:s', $reference))->where('user_id', Auth::user()->id)->firstorfail();
        if($seller_particular->spcontract->signature)
        {
            return redirect()->back()->with('warning', 'Your form details have been already submitted.');
        }

        try
        {
            $sp_contract_terms = SpContractTerm::where('seller_particular_id', $seller_particular->id)->whereNull('signature')->firstorfail();
            if ($request->signature) {
                $signature = $decoded_image;
                $filename = Carbon::now()->format('Y-m-d H-i-s') . '__' . guid() . '__signature.jpg';
                $filepath = 'storage/seller_signature/';

                $path_signature = $filepath . $filename;
                file_put_contents($path_signature, $signature);
                $sp_contract_terms->signature = $path_signature;
            }
            $sp_contract_terms->save();

            // NOTE BUYER EMAIL
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_S_AND_P_AGREEMENT_SIGNED_TO_BUYER'));
            if ($email_template) {
                $data = [];
                $username = $seller_particular->user->name;
                $buyer_name = 'Buyer';
                $buyer = BuyerParticular::where('seller_particular_id', $seller_particular->id)->first();
                if($buyer)
                {
                    $buyer_name = $buyer->user->name;
                }
                $registration_no = $seller_particular->vehicleparticular->registration_no;
                $vehicle_model = $seller_particular->vehicleparticular->model;

                $url = url('forms/form-details/view/'.$reference.'/'.$id);
                $url = '<a href="'.$url.'">'.$url.'</a>';

                $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                $data['from_email'] = $this->systemSetting()->from_email;
                $data['email'] = [$seller_particular->buyer_email];
                $data['cc_to_email'] = [];

                $data['subject'] = $email_template->subject;

                /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

                $key = ['{{buyer_name}}', '{{seller_name}}', '{{registration_no}}', '{{vehicle_model}}', '{{url}}'];
                $value = [$buyer_name, $username, $registration_no, $vehicle_model, $url];
                $newContent = str_replace($key, $value, $email_template->content);
                $data['contents'] = $newContent;

                try {
                    SendEmail::dispatchNow($data);
                } catch (Exception $exception) {
                    //dd($exception);
                }
            }

            // NOTE SELLER EMAIL
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_S_AND_P_AGREEMENT_SIGNED_TO_SELLER'));
            if ($email_template) {
                $data = [];

                $url = url('forms/form-details/view/'.$reference.'/'.$id);
                $url = '<a href="'.$url.'">'.$url.'</a>';
                $username = $seller_particular->user->name;
                $buyer_name = 'Buyer';
                $buyer = BuyerParticular::where('seller_particular_id', $seller_particular->id)->first();
                if($buyer)
                {
                    $buyer_name = $buyer->user->name;
                }
                $registration_no = $seller_particular->vehicleparticular->registration_no;
                $vehicle_model = $seller_particular->vehicleparticular->model;

                $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                $data['from_email'] = $this->systemSetting()->from_email;
                $data['email'] = [$seller_particular->user->email];
                $data['cc_to_email'] = [];

                $data['subject'] = $email_template->subject;

                /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

                $key = ['{{username}}', '{{buyer_name}}', '{{registration_no}}', '{{vehicle_model}}', '{{url}}'];
                $value = [$username, $buyer_name, $registration_no, $vehicle_model, $url];
                $newContent = str_replace($key, $value, $email_template->content);
                $data['contents'] = $newContent;

                try {
                    SendEmail::dispatchNow($data);
                } catch (Exception $exception) {
                    //dd($exception);
                }
            }

            // NOTE ADMIN EMAIL
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_S_AND_P_AGREEMENT_SIGNED_TO_ADMIN'));
            if ($email_template) {
                $data = [];
                $admins = getAdminByRole(__('constant.USER_SUPER_ADMIN'));
                if($admins)
                {
                    $url = route('sp-agreement.edit', $id);
                    $url = '<a href="'.$url.'">'.$url.'</a>';

                    $registration_no = $seller_particular->vehicleparticular->registration_no;
                    $vehicle_model = $seller_particular->vehicleparticular->model;

                    $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                    $data['from_email'] = $this->systemSetting()->from_email;
                    $data['cc_to_email'] = [];

                    $data['subject'] = $email_template->subject;

                    /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

                    foreach($admins as $admin)
                    {
                        $username = $admin->fullname;

                        $key = ['{{username}}', '{{registration_no}}', '{{vehicle_model}}', '{{url}}'];
                        $value = [$username, $registration_no, $vehicle_model, $url];
                        $newContent = str_replace($key, $value, $email_template->content);
                        $data['contents'] = $newContent;

                        try {
                            $data['email'] = $admin->email;
                            SendEmail::dispatchNow($data);
                        } catch (Exception $exception) {
                            // dd($exception);
                        }
                    }
                }
            }
        }
        catch(Exception $e)
        {
            return redirect()->back()->with('error', 'Error something went wrong.');
        }
        return redirect('my-forms')->with('success', 'Your form details have been submitted successfully.');
    }

    public function revised_store(Request $request, $slug, $reference, $id)
    {
        $seller_particular = SellerParticular::where('id', $id)->where('created_at', date('Y-m-d H:i:s', $reference))->firstorfail();
        try
        {
            $sp_contract_terms = SpContractTerm::where('seller_particular_id', $seller_particular->id)->firstorfail();
            if($seller_particular->user->email==$this->user->email)
            {
                $sp_contract_terms->seller_approval_at = Carbon::now();
            }
            if($seller_particular->buyer_email==$this->user->email)
            {
                $sp_contract_terms->buyer_approval_at = Carbon::now();
            }
            $sp_contract_terms->save();

            if($sp_contract_terms->seller_approval_at && $sp_contract_terms->buyer_approval_at)
            {
                // NOTE BUYER EMAIL
                $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_S_AND_P_AGREEMENT_ACCEPTED_TO_BUYER'));
                if ($email_template) {
                    $data = [];

                    $buyer_name = 'Buyer';
                    $buyer = BuyerParticular::where('seller_particular_id', $seller_particular->id)->first();
                    if($buyer)
                    {
                        $buyer_name = $buyer->user->name;
                    }

                    $url = url('forms/form-details/view/'.$reference.'/'.$id);
                    $url = '<a href="'.$url.'">'.$url.'</a>';

                    $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                    $data['from_email'] = $this->systemSetting()->from_email;
                    $data['email'] = [$seller_particular->buyer_email];
                    $data['cc_to_email'] = [];

                    $data['subject'] = $email_template->subject;

                    /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

                    $key = ['{{username}}', '{{url}}'];
                    $value = [$buyer_name, $url];
                    $newContent = str_replace($key, $value, $email_template->content);
                    $data['contents'] = $newContent;

                    try {
                        SendEmail::dispatchNow($data);
                    } catch (Exception $exception) {
                        //dd($exception);
                    }
                }

                // NOTE SELLER EMAIL
                $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_S_AND_P_AGREEMENT_ACCEPTED_TO_SELLER'));
                if ($email_template) {
                    $data = [];

                    $url = url('forms/form-details/view/'.$reference.'/'.$id);
                    $url = '<a href="'.$url.'">'.$url.'</a>';
                    $username = $seller_particular->user->name;

                    $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                    $data['from_email'] = $this->systemSetting()->from_email;
                    $data['email'] = [$seller_particular->user->email];
                    $data['cc_to_email'] = [];

                    $data['subject'] = $email_template->subject;

                    /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

                    $key = ['{{username}}', '{{url}}'];
                    $value = [$username, $url];
                    $newContent = str_replace($key, $value, $email_template->content);
                    $data['contents'] = $newContent;

                    try {
                        SendEmail::dispatchNow($data);
                    } catch (Exception $exception) {
                        //dd($exception);
                    }
                }

                // NOTE ADMIN EMAIL
                $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_S_AND_P_AGREEMENT_ACCEPTED_TO_ADMIN'));
                if ($email_template) {
                    $data = [];
                    $admins = getAdminByRole(__('constant.USER_SUPER_ADMIN'));
                    if($admins)
                    {
                        $url = route('sp-agreement.show', $id);
                        $url = '<a href="'.$url.'">'.$url.'</a>';

                        $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                        $data['from_email'] = $this->systemSetting()->from_email;
                        $data['cc_to_email'] = [];

                        $data['subject'] = $email_template->subject;

                        /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

                        foreach($admins as $admin)
                        {
                            $username = $admin->fullname;

                            $key = ['{{username}}', '{{url}}'];
                            $value = [$username, $url];
                            $newContent = str_replace($key, $value, $email_template->content);
                            $data['contents'] = $newContent;

                            try {
                                $data['email'] = $admin->email;
                                SendEmail::dispatchNow($data);
                            } catch (Exception $exception) {
                                // dd($exception);
                            }
                        }
                    }
                }
            }
        }
        catch(Exception $e)
        {
            Log::info($e);
            return redirect()->back()->with('error', 'Error something went wrong.');
        }
        return redirect('my-forms')->with('success', 'Revised agreement has been accepted successfully.');
    }

    public function getCountryCode(Request $request)
    {
        $country_of_residence = $request->country_of_residence;
        if($country_of_residence)
        {
            $country = DB::table('country')->where('nicename', $country_of_residence)->first();
            if($country)
            {
                return response()->json(['success' => '+'.$country->phonecode], 200);
            }
        }
        return response()->json(['error' => 'Something went wrong.'], 422);;
    }

    public function destroy(Request $request)
    {
        if(!$request->multiple_archive)
        {
            return redirect()->back()->with('error',  'Please select checkbox to delete.');
        }
        $id = explode(',', $request->multiple_archive);
        foreach($id as $item)
        {
            $buyer_ids = SellerParticular::where('id', $item)->where('buyer_email', $this->user->email)->first();
            if($buyer_ids)
            {
                $buyer_ids->buyer_archive = $this->user->id;
                $buyer_ids->save();
            }
            $seller_ids = SellerParticular::where('id', $item)->where('user_id', $this->user->id)->first();
            if($seller_ids)
            {
                $seller_ids->seller_archive = $this->user->id;
                $seller_ids->save();
            }
        }

        return redirect()->back()->with('success',  __('constant.ARCHIVED', ['module'    =>  'S&P Contract Form']));
    }
}
