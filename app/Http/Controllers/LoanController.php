<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Jobs\SendEmail;
use App\Loan;
use App\LoanCalculatorCashDiscount;
use App\Notification;
use App\Page;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PDF;
use Illuminate\Support\Facades\Session;

class LoanController extends Controller
{
    use SystemSettingTrait, GetEmailTemplate;

    public function __construct()
    {
        $this->middleware('auth:web')->except('loanChart');
		$this->system_settings = $this->systemSetting();

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function update(Request $request)
    {
        // dd($request->all());
        
        $messages = [
            // 'nric_company_registration_no.required' => 'The NRIC/Business ID/Company Registration ID field is required.',
            // 'bank_id.required' => 'The Bank field is required.',
            // 'year.required_if' => 'The Year field is required when No. of Years and Months is selected.',
            // 'estimated_monthly_installment.required_if' => 'Estimated monthly installment is required',
            // // 'month.required_if' => 'The Month field is required when No. of Years and Months is selected.',
            // 'vehicle_no.required_if' => 'The Vehicle no field is required.',
            // 'nric.required_if' => 'The NRIC field is required.',
            // 'owner_nric.required' => 'The NRIC field is required.',
            // 'estimated_mileage.required_if' => 'The Estimated mileage field is required.',
            // 'owner_id_typee.required_if' => 'Owner ID Type is required.',
            
            'nric_company_registration_no.required' => 'This field is required',
            'bank_id.required' => 'This field is required',
            'year.required_if' => 'This field is required',
            'estimated_monthly_installment.required_if' => 'This field is required',
            'month.required_if' => 'This field is required',
            'vehicle_no.required_if' => 'This field is required',
            'nric.required_if' => 'This field is required',
            'owner_nric.required' => 'This field is required',
            'estimated_mileage.required_if' => 'This field is required',
            'owner_id_typee.required_if' => 'This field is required',

            'vehicle_registration_no.required' => 'This field is required',
            'owner_id_type.required' => 'This field is required',
            'applicant_name.required' => 'This field is required',
            'passport.required_if' => 'This field is required',
            'country_code.required' => 'This field is required',
            'applicant_contact.required' => 'This field is required',
            'applicant_email.required' => 'This field is required',
            'nationality.required' => 'This field is required',
            'address.required' => 'This field is required',
            'gender.required' => 'This field is required',
            'marital_status.required' => 'This field is required',
            'dob.required' => 'This field is required',
            'company_name.required' => 'This field is required',
            'company_address.required' => 'This field is required',
            'company_postal_code.required' => 'This field is required',
            'occupation.required' => 'This field is required',
            'service_period_year.required' => 'This field is required',
            'monthly_salary.required' => 'This field is required',
            'loan_purchase_price.required' => 'This field is required',
            'loan_amount.required' => 'This field is required',
            'tenor.required' => 'This field is required',
        ];
        
        $request->validate([
                'vehicle_registration_no' => 'required',
                'owner_id_type' => 'required',
                'nric_company_registration_no' => 'required|min:4|max:4',
                'applicant_name' => 'required',
                'passport' => 'required_if:owner_id_type,Foreign Passport',
                'owner_nric' => 'required',
                'country_code' => 'required',
                'applicant_contact' => 'required|numeric',
                'applicant_email' => 'required|email',
                'nationality' => 'required',
                'address' => 'required',
                'gender' => 'required',
                'marital_status' => 'required',
                'dob' => 'required',
                'company_name' => 'required',
                'company_address' => 'required',
                'company_postal_code' => 'required',
                'occupation' => 'required',
                'service_period_year' => 'required',
                // 'service_period_month' => 'required',
                'monthly_salary' =>'required',
                'loan_purchase_price' => 'required',
                'loan_amount' => 'required',
                'bank_id' => 'required',
                'tenor' => 'required',
                'year' => 'required_if:tenor,2',
                // 'estimated_monthly_installment' => 'required_if:tenor,2',
                'quote_trade' => 'required',
                'vehicle_no' => 'required_if:quote_trade,1',
                'nric' => 'required_if:quote_trade,1',
                'owner_id_typee' => 'required_if:quote_trade,1', /////
                'estimated_mileage' => 'required_if:quote_trade,1',
                'data_protection' => 'required',
                // 'cpfcontributionhistory' => 'required',
            ], $messages);

        // if (!Session::get('myinfoloan')) {
        //         $request->validate([
        //         'vehicle_registration_no' => 'required',
        //         'owner_id_type' => 'required',
        //         'nric_company_registration_no' => 'required|min:4|max:4',
        //         'applicant_name' => 'required',
        //         'passport' => 'required_if:owner_id_type,Foreign Passport',
        //         'owner_nric' => 'required',
        //         'country_code' => 'required',
        //         'applicant_contact' => 'required|numeric',
        //         'applicant_email' => 'required|email',
        //         'nationality' => 'required',
        //         'address' => 'required',
        //         'gender' => 'required',
        //         'marital_status' => 'required',
        //         'dob' => 'required',
        //         'company_name' => 'required',
        //         'company_address' => 'required',
        //         'company_postal_code' => 'required',
        //         'occupation' => 'required',
        //         'service_period_year' => 'required',
        //         'service_period_month' => 'required',
        //         'monthly_salary' =>'required',
        //         'loan_purchase_price' => 'required',
        //         'loan_amount' => 'required',
        //         'bank_id' => 'required',
        //         'tenor' => 'required',
        //         'year' => 'required_if:tenor,2',
        //         'estimated_monthly_installment' => 'required_if:tenor,2',
        //         'quote_trade' => 'required',
        //         'vehicle_no' => 'required_if:quote_trade,1',
        //         'nric' => 'required_if:quote_trade,1',
        //         'owner_id_typee' => 'required_if:quote_trade,1', /////
        //         'estimated_mileage' => 'required_if:quote_trade,1',
        //         'data_protection' => 'required',
        //         'cpfcontributionhistory' => 'required',
        //     ], $messages);
        // }else{
        //     $request->validate([
        //         'vehicle_registration_no' => 'required',
        //         'nric_company_registration_no' => 'required|min:4|max:4',
        //         'applicant_name' => 'required',
        //         'owner_nric' => 'required',
        //         'country_code' => 'required',
        //         'applicant_contact' => 'required|numeric',
        //         'applicant_email' => 'required|email',
        //         'loan_purchase_price' => 'required',
        //         'loan_amount' => 'required',
        //         'tenor' => 'required',
        //         'year' => 'required_if:tenor,2',
        //         'estimated_monthly_installment' => 'required_if:tenor,2',
        //         'quote_trade' => 'required',
        //         'vehicle_no' => 'required_if:quote_trade,1',
        //         'nric' => 'required_if:quote_trade,1',
        //         'owner_id_typee' => 'required_if:quote_trade,1', /////
        //         'estimated_mileage' => 'required_if:quote_trade,1',
                
        //     ], $messages);
        // }

        if(!empty($request->dob)){
            $dob = date('Y-m-d', strtotime($request->dob));
        }else{
            $dob = null;
        }

        $loan = new Loan();
        $loan->user_id = $this->user->id;
        $loan->vehicle_registration_no = $request->vehicle_registration_no;
        $loan->owner_id_type = $request->owner_id_type; // new field
        $loan->nric_company_registration_no = $request->nric_company_registration_no;
        $loan->salutation = $request->salutation; // new field
        $loan->owner_nric = $request->owner_nric; // new field
        $loan->applicant_name = $request->applicant_name; // new field New field
        $loan->uen = $request->uen; // new field
        $loan->passport = $request->passport; // new field
        $loan->country_code = $request->country_code; // new field
        $loan->applicant_contact = $request->applicant_contact; // new field
        $loan->applicant_email = $request->applicant_email; // new field
        $loan->nationality = $request->nationality; // new field
        $loan->address = $request->address; // new field
        $loan->postal_code = $request->postal_code; // new field
        $loan->gender = $request->gender; // new field
        $loan->marital_status = $request->marital_status; // new field
        $loan->dob = $dob; // new field
        $loan->company_name = $request->company_name; // new field
        $loan->company_address = $request->company_address; // new field
        $loan->company_postal_code = $request->company_postal_code; // new field
        $loan->occupation = $request->occupation; // new field
        $loan->service_period_year = $request->service_period_year; // new field
        $loan->service_period_month = $request->service_period_month; // new field
        $loan->monthly_salary = str_replace(',','',$request->monthly_salary); // new field
        $loan->down_payment = str_replace(',','', $request->down_payment); // new field
        $loan->estimated_monthly_installment = str_replace(',','',$request->estimated_monthly_installment); // new field
        $loan->bank_id = $request->bank_id;
        $loan->loan_purchase_price = str_replace(',','',$request->loan_purchase_price);
        $loan->loan_amount = str_replace(',','',$request->loan_amount);
        $loan->tenor = $request->tenor;
        $loan->cpfhistory = $request->cpfhistory1;  //////////////////////////////////////
        $loan->noahistory = $request->noahistory1; //////////////////////////////////////
        if($loan->tenor==2)
        {
            $loan->year = $request->year;
            $loan->month = $request->month;
        }
        else
        {
            $loan->year = null;
            $loan->month = null;
        }
        $loan->quote_trade = $request->quote_trade;
        if($loan->quote_trade==1)
        {
            $loan->trade_details = json_encode([
                'vehicle_no' => $request->vehicle_no,
                'nric' => $request->nric,
                'owner_id_typee'=>$request->owner_id_typee,
                'estimated_mileage' => str_replace(',','',$request->estimated_mileage),
            ]);
        }
        else
        {
            $loan->trade_details = null;
        }

        if ($request->hasFile('cpfcontributionhistory')) {
            foreach($request->file('cpfcontributionhistory') as $file)
                {
                     $name = uniqid() . '_' . time(). '.' . $file->getClientOriginalExtension();
                     $path = public_path() . '/documents/';
                     $file->move($path, $name);
                     $Imgdata[] = $name;
                }
            // $cpf = $request->file('cpfcontributionhistory');
            // $cpfname = rand().'.'.$cpf->getClientOriginalExtension();
            // $destinationPath = public_path('/documents');
            // $cpf->move($destinationPath, $cpfname);
            $loan->cpfcontributionhistory = json_encode($Imgdata); // new field
        }

        if ($request->hasFile('noticeofassessment')) {
            foreach($request->file('noticeofassessment') as $file)
                {
                     $name = uniqid() . '_' . time(). '.' . $file->getClientOriginalExtension();
                     $path = public_path() . '/documents/';
                     $file->move($path, $name);
                     $Imgdata12[] = $name;
                }
            // $noticeass = $request->file('noticeofassessment');
            // $noticeassname = rand().'.'.$noticeass->getClientOriginalExtension();
            // $destinationPath = public_path('/documents');
            // $noticeass->move($destinationPath, $noticeassname);
            $loan->noticeofassessment = json_encode($Imgdata12); // new field
        }

        $loan->data_protection = $request->data_protection;
        $loan->status = __('constant.PROCESSING');
        $pdf = PDF::loadView('loanpdf', compact('loan'))->setPaper('a4', 'potrait');
        $path = public_path('loanpdf');
        $fileName =  rand().'-pdfview' . '.' . 'pdf' ;
        $pdf->save($path . '/' . $fileName);
        $loan->pdf_name = $fileName; // new field New field
        
        // CPF contribution history from Myinfo
        if(isset($request->cpfhistory1) && sizeof(json_decode($request->cpfhistory1)) > 0){
            $cpfhistory = json_decode($request->cpfhistory1);
            $pdf = PDF::loadView('loan-cpf', compact('cpfhistory'))->setPaper('a4', 'potrait');
            $path = public_path('loanpdf');
            $fileName =  'cpf-'.rand().'-pdfview' . '.' . 'pdf' ;
            $pdf->save($path . '/' . $fileName);
            $loan->myinfo_cpf = $fileName; // new field New field 
        }

        // NOA from Myinfo
        if(isset($request->noahistory1) && sizeof(json_decode($request->noahistory1)) > 0){
            $noahistory = json_decode($request->noahistory1);
            $pdf = PDF::loadView('loan-noa', compact('noahistory'))->setPaper('a4', 'potrait');
            $path = public_path('loanpdf');
            $fileName =  'noa-'.rand().'-pdfview' . '.' . 'pdf' ;
            $pdf->save($path . '/' . $fileName);
            $loan->myinfo_noa = $fileName; // new field New field
        }
        
        $loan->save();

        $message = $request->applicant_name . ' filled new Loan form.';
        $notification = new Notification();
		$notification->insurance_id = NULL;
		$notification->quotaton_id = NULL;
		$notification->partner_id = Auth::user()->id;
		$notification->message = $message;
		$notification->link = 'https://www.diycars.com/admin/loan-application/'.$loan->id.'/edit';
		$notification->status = 1;
		$notification->save();

        // EMAIL
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_LOAN_APPLICATION_TO_ADMIN'));
        if ($email_template) {
            $data = [];

            $users = getUsers(__('constant.USER_SUPER_ADMIN'));
            $url = url('admin/loan-application/'.$loan->id.'/edit');
            $url = '<a href="'.$url.'">'.$url.'</a>';

            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['cc_to_email'] = [];

            $data['subject'] = $email_template->subject;

            /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

            $key = ['{{url}}'];
            $value = [$url];
            $newContent = str_replace($key, $value, $email_template->content);
            $data['contents'] = $newContent;

            if($users)
            {
                foreach($users as $item)
                {
                    try {
                        $data['email'] = $item->email;

                        SendEmail::dispatch($data);
                    } catch (Exception $exception) {
                        //dd($exception);
                    }
                }
            }
        }

        $page = Page::find(__('constant.THANK_YOU_LOAN_FORM'));
        if($page)
        {
            return redirect($page->slug);
        }

        return redirect('loan')->with('success', 'Loan Application has been submitted.');
    }

    public function loanChart(Request $request)
    {
        $loan_tenor = $request->loan_tenor;
        $purchase_price = str_replace(',','',$request->purchase_price);
        $selDownPayment = $request->selDownPayment;
        if($loan_tenor && $purchase_price && $selDownPayment)
        {

            $min_bank_interest = Bank::min('interest');
            $loan_calculator_settings = LoanCalculatorCashDiscount::first();
            // $downpayment_percent = $loan_calculator_settings->downpayment_percent;
            $downpayment_percent = $selDownPayment;
            // $loanamount_percent = $loan_calculator_settings->loanamount_percent;
            $loanamount_percent = 100 - $selDownPayment;
            // NOTE BEFORE CASH DISCOUNT CALCULATION
            $downpayment = round($purchase_price /100 * $downpayment_percent, 2);
            $loanamount = round($purchase_price /100 * $loanamount_percent, 2);
            $monthly_installment = round(((($loanamount*($min_bank_interest/100))/12*$loan_tenor)+$loanamount)/$loan_tenor, 2);
            $total_cash_layout = round($downpayment+$monthly_installment, 2);

            // NOTE AFTER CASH DISCOUNT CALCULATION
            $after_cash_discount = json_decode($loan_calculator_settings->after_cash_rebate, true);
            if($loan_tenor<1 || $loan_tenor>84)
            {
                $cash_rebate = $purchase_price_after_rebate = $downpayment_after_discount = $loanamount_after_discount = $monthly_installment_after_discount = $total_cash_layout_after_discount = $lower_downpayment = $saving_installment = $total_saving = 'N/A';
            }
            else
            {
                $get_rebate = (ceil($loan_tenor/12) - 1);
                $after_cash_discount = array_values($after_cash_discount);
                $cash_rebate = round($loanamount*($after_cash_discount[$get_rebate]/100), 2);
                $purchase_price_after_rebate = round($purchase_price - $cash_rebate, 2);
                $downpayment_after_discount = round($purchase_price_after_rebate /100 * $downpayment_percent, 2);
                $loanamount_after_discount = round($purchase_price_after_rebate /100 * $loanamount_percent, 2);
                $monthly_installment_after_discount = round(((($loanamount_after_discount*($min_bank_interest/100))/12*$loan_tenor)+$loanamount_after_discount)/$loan_tenor, 2);
                $total_cash_layout_after_discount = round($downpayment_after_discount+$monthly_installment_after_discount, 2);

                // NOTE SAVING CASH DISCOUNT CALCULATION
                $lower_downpayment = round($downpayment - $downpayment_after_discount, 2);
                $saving_installment = round(($monthly_installment - $monthly_installment_after_discount) * $loan_tenor, 2);
                $total_saving = round($lower_downpayment + $saving_installment, 2);
            }

            ?>
			<div class="row grid-3">
				<div class="col-lg-4 col-sm-6 item">
					<h4>Purchase Price</h4>
					<strong>$ <?= number_format($purchase_price) ?></strong>
				</div>
				<div class="col-lg-4 col-sm-6 item">
					<h4>Interest Rate</h4>
					<strong><?= $min_bank_interest ?? 0 ?>%</strong>
				</div>
				<div class="col-lg-4 col-sm-6 item">
					<h4>Downpayment (<?= $downpayment_percent ?>%)</h4>
					<strong>$ <?= number_format($downpayment); ?></strong>
				</div>
				<div class="col-lg-4 col-sm-6 item">
					<h4>Loan Amount (<?= $loanamount_percent ?>%)</h4>
					<strong>$ <?= number_format($loanamount); ?></strong>
				</div>
				<div class="col-lg-4 col-sm-6 item">
					<h4>Monthly Installment</h4>
					<strong>$ <?= number_format($monthly_installment); ?></strong>
				</div>
				<div class="col-lg-4 col-sm-6 item">
					<h4>Total Cash Outlay</h4>
					<strong>$ <?= number_format($total_cash_layout); ?></strong>
				</div>
			</div>
            <?php
        }
    }
}
