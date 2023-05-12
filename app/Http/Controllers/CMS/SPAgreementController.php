<?php

namespace App\Http\Controllers\CMS;

use App\BuyerLoanDetail;
use App\BuyerParticular;
use App\BuyerPaymentTermCondition;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\SellerParticular;
use App\SpContractTerm;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use App\User;
use App\VehicleParticular;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

class SPAgreementController extends Controller
{
    use SystemSettingTrait, GetEmailTemplate;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.SP_AGREEMENT');
        $this->module = 'SP_AGREEMENT';
        $this->middleware('grant.permission:'.$this->module);
        $this->system_settings = $this->systemSetting();
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = $this->title;
        $seller_particular = SellerParticular::notarchived()->paginate($this->pagination);

        return view('admin.sp_agreement.index', compact('title', 'seller_particular'));
    }

    public function edit($id)
    {
        $title = $this->title;
        $seller_particular = SellerParticular::findorfail($id);
        $buyer_particular = BuyerParticular::where('seller_particular_id', $seller_particular->id)->first();
        $system_settings = $this->system_settings;
        return view('admin.sp_agreement.edit', compact('title', 'seller_particular', 'buyer_particular', 'system_settings'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'nric.required' => 'The NRIC/UEN/Passport No. field is required.',
            'hp_no.required' => 'The H/P No. field is required.',
            'buyer_mobile.required' => 'The Buyers mobile no. field is required.',
            'buyer_mobile.numeric' => 'The Buyers mobile no. field should be numeric.',
            'make.required' => 'The Vehicle make field is required.',
            'registration_no.required' => 'The Original registration no field is required.',
            'model.required' => 'The Vehicle model field is required.',
            'registration_date' => 'The Original registration date field is required.',
        ];

        $request->validate([
            // 'seller_company_name' => 'required',
            'seller_name' => 'required',
            'seller_nric' => 'required|max:191', //
            'seller_address' => 'required',
            // 'seller_hp_no' => 'required|max:191',
            'seller_email' => 'required',
            'seller_gender' => 'required',  //
            'buyer_email' => 'required|email|max:191',
            'buyer_mobile' => 'required|numeric',
            'registration_no' => 'required|max:191',
            'make' => 'required|max:191',
            'model' => 'required|max:191',
            'registration_date' => 'required',
            'arf_paid' => 'nullable',      //777777777777777
            // 'seller_terms_and_condition' => 'required',
            'selling_price' => 'required', ////
            'deposit' => 'required',  ////
            'balance_payment' => 'required', //
            // 'buyer_company_name' => 'required', //
            'buyer_name' => 'required',
            'buyer_nric' => 'required|max:191',   ////
            'buyer_address' => 'required',
            // 'buyer_hp_no' => 'required|max:191', //
            'buyer_email' => 'required',
            // 'loan_amount' => 'required', //
            // 'bank' => 'required',
            // 'interest' => 'required',
            // 'balance' => 'required',
            // 'buyer_terms_and_condition' => 'required',
        ], $messages);

        try
        {
            $seller_particular = SellerParticular::findorfail($id);
            $seller_particular->nric = $request->seller_nric;
            $seller_particular->company_name = $request->seller_company_name;
            $seller_particular->seller_name = $request->seller_name;
            $seller_particular->seller_country_code = $request->seller_country_code;
            $seller_particular->seller_mobile = $request->seller_mobile;
            $seller_particular->address = $request->seller_address;
            $seller_particular->hp_no = $request->seller_hp_no;
            $seller_particular->buyer_email = $request->buyer_email;
            $seller_particular->buyer_mobile = $request->buyer_mobile;
            $seller_particular->country_of_residence = $request->seller_country_of_residence;
            $seller_particular->first_registration_Date = date('Y-m-d', strtotime($request->first_registration_Date)); //
            $seller_particular->seller_gender = $request->seller_gender; //
            if(checkSellerSigned($seller_particular->id))
            {
                $seller_particular->revised = 1;
            }
            $seller_particular->save();

            $vehicle_particular = VehicleParticular::where('seller_particular_id', $id)->firstorfail();
            $vehicle_particular->registration_no = $request->registration_no;
            $vehicle_particular->make = $request->make;
            $vehicle_particular->model = $request->model;
            $vehicle_particular->registration_date = date('Y-m-d', strtotime($request->registration_date)); //
            $vehicle_particular->year_of_manufacturer = $request->year_of_manufacturer;
            $vehicle_particular->chassis_no = $request->chassis_no;
            $vehicle_particular->engine_no = $request->engine_no;
            $vehicle_particular->open_market_value = str_replace(',','',$request->open_market_value); //
            $vehicle_particular->color = $request->color;
            $vehicle_particular->no_of_transfer = $request->no_of_transfer;
            $vehicle_particular->coe_expiry_date = date('Y-m-d', strtotime($request->coe_expiry_date)); //
            $vehicle_particular->arf_paid = str_replace(',','',$request->arf_paid);
            $vehicle_particular->vehicle_type = $request->vehicle_type;

            $vehicle_particular->road_tax_expiry_date = date('Y-m-d', strtotime($request->road_tax_expiry_date)); //
            $vehicle_particular->vehicle_scheme = $request->vehicle_scheme; //
            $vehicle_particular->iu_label_number = $request->iu_label_number; //


            $vehicle_particular->engine_output = str_replace(',','', $request->engine_output);
            $vehicle_particular->save();

            $sp_contract_terms = SpContractTerm::where('seller_particular_id', $id)->firstorfail();
            $sp_contract_terms->terms_and_condition = json_encode($request->seller_terms_and_condition);
            $sp_contract_terms->other_terms = $request->diy_terms_condition;
            $sp_contract_terms->selling_price = str_replace(',','', $request->selling_price); // 
            $deposit = round($sp_contract_terms->selling_price/100*$this->system_settings->deposit_percent, 2);
            $balance_payment = round($sp_contract_terms->selling_price - $deposit, 2);
            $sp_contract_terms->deposit =  str_replace(',','', $request->deposit); //
            $sp_contract_terms->balance_payment = str_replace(',','', $request->balance_payment); //
            $sp_contract_terms->seller_approval_at = null;
            $sp_contract_terms->buyer_approval_at = null;
            $sp_contract_terms->save();


            // NOTE BUYER
            $buyer_particular = BuyerParticular::where('seller_particular_id', $id)->firstorfail();
            $buyer_particular->nric = $request->buyer_nric;
            $buyer_particular->passport = $request->passport;
            $buyer_particular->buyer_nationality = $request->buyer_nationality;
            $buyer_particular->buyer_name = $request->buyer_name;
            $buyer_particular->address = $request->buyer_address;
            $buyer_particular->buyer_gender = $request->buyer_gender;
            $buyer_particular->country_code = $request->country_code;
            $buyer_particular->phone = $request->phone;
            // $buyer_particular->country_of_residence = $request->buyer_country_of_residence;
            $buyer_particular->save();

            // $buyer_loan_detail = BuyerLoanDetail::where('buyer_particular_id', $buyer_particular->id)->firstorfail();
            // $buyer_loan_detail->loan_amount = str_replace(',','',$request->loan_amount);  //
            // $buyer_loan_detail->bank = $request->bank;
            // $buyer_loan_detail->interest = $request->interest;
            // $balance = round($buyer_particular->sellerparticular->spcontract->balance_payment - $buyer_loan_detail->loan_amount, 2);
            // $buyer_loan_detail->balance = $balance;
            // $buyer_loan_detail->save();

            $buyer_loan_detail = BuyerLoanDetail::where('buyer_particular_id', $buyer_particular->id)->first();
            if($buyer_loan_detail){
                $buyer_loan_detail->loan_amount = str_replace(',','',$request->loan_amount);  //
                $buyer_loan_detail->bank = $request->bank;
                $buyer_loan_detail->interest = $request->interest;
                $balance = round($buyer_particular->sellerparticular->spcontract->balance_payment - $buyer_loan_detail->loan_amount, 2);
                $buyer_loan_detail->balance = $balance;
                $buyer_loan_detail->save();
            }
            

            $buyer_payment_terms_condition = BuyerPaymentTermCondition::where('buyer_particular_id', $buyer_particular->id)->firstorfail();
            $buyer_payment_terms_condition->payment_details = $request->payment_details ? json_encode($request->payment_details) : null;
            $buyer_payment_terms_condition->terms_and_condition = json_encode($request->buyer_terms_and_condition);
            $buyer_payment_terms_condition->save();


            $buyer_particular = BuyerParticular::where('seller_particular_id', $id)->firstorfail();
            $reference = rand();
            $pdf = PDF::loadView('spagreement', compact('seller_particular', 'buyer_particular'))->setPaper('a4', 'potrait');
            $path = public_path('pdf');
            $fileName =  $id.'-'.$reference.'-pdfview' . '.' . 'pdf' ;
            $pdf->save($path . '/' . $fileName);
            $buyer_particular->pdf_name = $fileName;
            $buyer_particular->save();

            $reference = strtotime($seller_particular->created_at);
            if(checkSellerSigned($seller_particular->id))
            {
                // NOTE BUYER EMAIL
                $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_S_AND_P_AGREEMENT_REVISED_TO_BUYER'));
                if ($email_template) {
                    $data = [];

                    $url = url('forms/form-details/view/'.$reference.'/'.$id);
                    $url = '<a href="'.$url.'">'.$url.'</a>';

                    $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                    $data['from_email'] = $this->systemSetting()->from_email;
                    $data['email'] = [$seller_particular->buyer_email];
                    $data['cc_to_email'] = [];

                    $data['subject'] = $email_template->subject;

                    /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

                    $key = ['{{buyer_name}}', '{{url}}'];
                    $value = [$buyer_particular->buyer_name, $url];
                    $newContent = str_replace($key, $value, $email_template->content);
                    $data['contents'] = $newContent;

                    try {
                        SendEmail::dispatch($data);
                    } catch (Exception $exception) {
                        //dd($exception);
                    }
                }

                // NOTE SELLER EMAIL
                $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_S_AND_P_AGREEMENT_REVISED_TO_SELLER'));
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
                        SendEmail::dispatch($data);
                    } catch (Exception $exception) {
                        //dd($exception);
                    }
                }
                return redirect('admin/sp-agreement')->with('success', 'Revised S&P Contract Agreement has been sent successfully.');
            }
        }
        catch(Exception $e)
        {
            Log::info($e);
            return redirect()->back()->with('error', 'Error something went wrong.');
        }
        if(!empty($request->previousUrll)){
            return redirect($request->previousUrll)->with('success',  __('constant.UPDATED', ['module' => $this->title]));
        }else{
            return redirect('admin/sp-agreement')->with('success', 'Form details have been updated successfully.');
        }
        // return redirect('admin/sp-agreement')->with('success', 'Form details have been updated successfully.');
    }

    public function show($id)
    {
        $title = $this->title;
        $seller_particular = SellerParticular::findorfail($id);
        $buyer_particular = BuyerParticular::where('seller_particular_id', $seller_particular->id)->first();
        $system_settings = $this->system_settings;
        return view('admin.sp_agreement.show', compact('title', 'seller_particular', 'buyer_particular', 'system_settings'));
    }

    public function destroy(Request $request, $id)
    {
        // $id = explode(',', $request->multiple_delete);
        // SellerParticular::destroy($id);
        $id = explode(',', $request->multiple_delete);
        foreach($id as $id){
            $sp_contract_terms = SpContractTerm::where('seller_particular_id', $id)->pluck('id')->toArray();
            if($sp_contract_terms){
                SpContractTerm::destroy($sp_contract_terms);
                // $insuranceVehicle->delete();
            }
            
            $vehicle_particular = VehicleParticular::where('seller_particular_id', $id)->pluck('id')->toArray();
            if($vehicle_particular){
                VehicleParticular::destroy($vehicle_particular);
                // $insuranceInformation->delete();
            }
            $buyer_particular = BuyerParticular::where('seller_particular_id', $id)->pluck('id')->toArray();
            if($buyer_particular){
                $buyer_loan_detail = BuyerLoanDetail::whereIn('buyer_particular_id', $buyer_particular)->pluck('id')->toArray();
                if($buyer_loan_detail){
                    BuyerLoanDetail::destroy($buyer_loan_detail);
                }
                $buyer_payment_terms_condition = BuyerPaymentTermCondition::whereIn('buyer_particular_id', $buyer_particular)->pluck('id')->toArray();
                if($buyer_payment_terms_condition){
                    BuyerPaymentTermCondition::destroy($buyer_payment_terms_condition);
                }

                BuyerParticular::destroy($buyer_particular);
            }
            SellerParticular::destroy($id);
        }

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $title = $this->title;
        $query = SellerParticular::notarchived();
        if($request->search1)
        {
            $user = User::where('name', 'like', '%'.$request->search1.'%')->orWhere('email', 'like', '%'.$request->search1.'%')->orWhere('mobile', 'like', '%'.$request->search1.'%')->get();
            $query->whereIn('user_id', $user->pluck('id'));
        }

        if($request->search2)
        {
            $vehicle_particular = VehicleParticular::where(function($inner_query) use($request) {
                return $inner_query->where('make', 'like', '%'.$request->search2.'%')->orwhere('model', 'like', '%'.$request->search2.'%')->orwhere('registration_no', 'like', '%'.$request->search2.'%');
            });
            $query->whereIn('id', $vehicle_particular->pluck('id'));
        }

        if($request->search3)
        {
            $query->where('nric', 'like', '%'.$request->search3.'%');
        }

        if($request->status)
        {
            $query->where('status', $request->status);
        }

        $seller_particular = $query->paginate($this->pagination);
        if($request->search1)
        {
            $seller_particular->appends('search1', $request->search1);
        }
        if($request->search2)
        {
            $seller_particular->appends('search2', $request->search2);
        }
        if($request->search3)
        {
            $seller_particular->appends('search3', $request->search3);
        }
        if($request->status)
        {
            $seller_particular->appends('status', $request->status);
        }
        return view('admin.sp_agreement.index', compact('title', 'seller_particular'));
    }
}
