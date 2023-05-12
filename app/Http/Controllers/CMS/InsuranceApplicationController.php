<?php

namespace App\Http\Controllers\CMS;

use App\Insurance;
use App\Page;
use App\User;
use App\Admin;
use App\InsuranceInformation;
use App\InsuranceQuotation;
use App\InsuranceVehicle;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmail;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Traits\GetEmailTemplate;
use App\Mail\EmailNotification;
use App\Traits\GetMessageTemplate;
use Illuminate\Support\Facades\View;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
// use Mpdf\Mpdf as PDF;
use PDF;
class InsuranceApplicationController extends Controller
{
    use SystemSettingTrait, GetEmailTemplate, GetMessageTemplate;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.INSURANCE_APPLICATION');
        $this->module = 'INSURANCE_APPLICATION';
        $this->middleware('grant.permission:'.$this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $insurance = Insurance::orderBy('created_at','desc')->paginate($this->pagination);

        return view('admin.insurance.index', compact('title', 'insurance'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
		$page_id=__('constant.INSURANCE_PAGE_ID');
		$page=Page::find($page_id);
		$users=User::where('status',1)->get();
        return view('admin.insurance.create', compact('title','page','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $messages = [];
        $messages['main_driver_full_name.required'] = 'The name field is required.';
		$messages['main_driver_nric.required'] = 'The NRIC field is required.';
		$messages['main_driver_date_of_birth.required'] = 'The date of birth field is required.';
		$messages['main_driver_license_pass_date.required'] = 'The license pass date field is required.';
		$messages['main_driver_gender.required'] = 'The gender field is required.';
		$messages['main_driver_marital_status.required'] = 'The marital status field is required.';
		$messages['main_driver_country_code.required'] = 'The country code field is required.';
		$messages['main_driver_contact_number.required'] = 'The contact number field is required.';
		$messages['main_driver_email.required'] = 'The email field is required.';
		$messages['main_driver_occupation.required'] = 'The occupation field is required.';
		$messages['driver_full_name.required_if'] = 'The name field is required.';
		$messages['driver_occupation.required_if'] = 'The occupation field is required.';
		$messages['driver_license_pass_date.required_if'] = 'The license passed date field is required.';
		$messages['relationship_main_driver.required_if'] = 'The relationship to main driver field is required.';
        $messages['driver_nric.required_if'] = 'The NRIC field is required.';
        $messages['driver_date_of_birth.required_if'] = 'The date of bith field is required.';
        $messages['license_pass_date.required_if'] = 'License pass date field is required.';
        $messages['driver_gender.required_if'] = ' Gender field is required.';
        $messages['driver_marital_status.required_if'] = ' Marital status field is required.';
        $messages['year_of_manufacture.before_or_equal'] = 'Year of manufacture cannot be greater than date of registration.';
		    if(isset($request->date_of_registration))
			{
			$request->validate([
				'main_driver_full_name' => 'required',
				'main_driver_nric' => 'required|string|min:4|max:4',
				'main_driver_date_of_birth' => 'required|date',
				'main_driver_license_pass_date' => 'required|date',
				'main_driver_gender' => 'required',
				'main_driver_marital_status' => 'required',
				'main_driver_occupation' => 'required',
				'main_driver_country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',
				'main_driver_contact_number' => 'required|numeric',
				'main_driver_email' => 'required|email',
				'named_driver' => 'required',
				'driver_full_name' => 'required_if:named_driver,1',
				'driver_nric' => 'required_if:named_driver,1',
				'driver_date_of_birth' => 'required_if:named_driver,1',
				'driver_license_pass_date' => 'required_if:named_driver,1',
				'driver_marital_status' => 'required_if:named_driver,1',
				'driver_occupation' => 'required_if:named_driver,1',
				'relationship_main_driver' => 'required_if:named_driver,1',
				'car_plate_no' => 'required',
				'make_model' => 'required',
				'engine_capacity' => 'required',
				'date_of_registration' => 'required',
				'year_of_manufacture' => 'required|integer|before_or_equal:'.date("Y",strtotime($request->date_of_registration)).'|min:1900|max:'.date("Y"),
				'nric_uen_business_passport' => 'nullable|string|min:4|max:4',
				'terms_condition' => 'required',
			], $messages);
			}
			else
			{
			$request->validate([
				'main_driver_full_name' => 'required',
				'main_driver_nric' => 'required|string|min:4|max:4',
				'main_driver_date_of_birth' => 'required|date',
				'main_driver_license_pass_date' => 'required|date',
				'main_driver_gender' => 'required',
				'main_driver_marital_status' => 'required',
				'main_driver_occupation' => 'required',
				'main_driver_country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',
				'main_driver_contact_number' => 'required|numeric',
				'main_driver_email' => 'required|email',
				'named_driver' => 'required',
				'driver_full_name' => 'required_if:named_driver,1',
				'driver_nric' => 'required_if:named_driver,1',
				'driver_date_of_birth' => 'required_if:named_driver,1',
				'driver_license_pass_date' => 'required_if:named_driver,1',
				'driver_marital_status' => 'required_if:named_driver,1',
				'driver_occupation' => 'required_if:named_driver,1',
				'relationship_main_driver' => 'required_if:named_driver,1',
				'car_plate_no' => 'required',
				'make_model' => 'required',
				'engine_capacity' => 'required',
				'date_of_registration' => 'required',
				'year_of_manufacture' => 'required|integer|min:1900|max:'.date("Y"),
				'nric_uen_business_passport' => 'nullable|string|min:4|max:4',
				'terms_condition' => 'required',
			], $messages);
			}


		$insurance = new Insurance();
		$insurance->user_id = isset($request->user_id)?$request->user_id:NULL;
        $insurance->main_driver_full_name = isset($request->main_driver_full_name)?$request->main_driver_full_name:NULL;
        $insurance->main_driver_nric = isset($request->main_driver_nric)?$request->main_driver_nric:NULL;
        $insurance->main_driver_date_of_birth = isset($request->main_driver_date_of_birth)?$request->main_driver_date_of_birth:NULL;
        $insurance->main_driver_license_pass_date = isset($request->main_driver_license_pass_date)?$request->main_driver_license_pass_date:NULL;
        $insurance->main_driver_gender = isset($request->main_driver_gender)?$request->main_driver_gender:NULL;
        $insurance->main_driver_marital_status = isset($request->main_driver_marital_status)?$request->main_driver_marital_status:NULL;
        $insurance->main_driver_occupation = isset($request->main_driver_occupation)?$request->main_driver_occupation:NULL;
		$insurance->main_driver_country_code = isset($request->main_driver_country_code)?$request->main_driver_country_code:NULL;
		$insurance->main_driver_contact_number = isset($request->main_driver_contact_number)?$request->main_driver_contact_number:NULL;
		$insurance->main_driver_email = isset($request->main_driver_email)?$request->main_driver_email:NULL;
		$insurance->named_driver = isset($request->named_driver)?$request->named_driver:NULL;
		$insurance->driver_full_name = isset($request->driver_full_name)?$request->driver_full_name:NULL;
		$insurance->driver_nric = isset($request->driver_nric)?$request->driver_nric:NULL;
		$insurance->driver_date_of_birth = isset($request->driver_date_of_birth)?$request->driver_date_of_birth:NULL;
		$insurance->driver_license_pass_date = isset($request->driver_license_pass_date)?$request->driver_license_pass_date:NULL;
		$insurance->driver_gender = isset($request->driver_gender)?$request->driver_gender:NULL;
		$insurance->driver_marital_status = isset($request->driver_marital_status)?$request->driver_marital_status:NULL;
		$insurance->driver_occupation = isset($request->driver_occupation)?$request->driver_occupation:NULL;
		$insurance->relationship_main_driver = isset($request->relationship_main_driver)?$request->relationship_main_driver:NULL;
		$insurance->terms_condition = isset($request->terms_condition)?$request->terms_condition:NULL;
        $insurance->save();
		if($insurance->id)
		{

        $insuranceInformation = new InsuranceInformation();
        $insuranceInformation->insurance_id = $insurance->id;
        $insuranceInformation->car_plate_no = isset($request->car_plate_no)?$request->car_plate_no:NULL;
        $insuranceInformation->nric_uen_business_passport = isset($request->nric_uen_business_passport)?$request->nric_uen_business_passport:NULL;
        $insuranceInformation->ncd = isset($request->ncd)?$request->ncd:NULL;
        $insuranceInformation->previous_vehicle_number = isset($request->previous_vehicle_number)?$request->previous_vehicle_number:NULL;
		$insuranceInformation->terms_condition = isset($request->terms_condition)?$request->terms_condition:NULL;
        $insuranceInformation->save();

		$insuranceVehicle = new InsuranceVehicle();
        $insuranceVehicle->insurance_id = $insurance->id;
        //$insuranceVehicle->vehicle_details = isset($request->vehicle_details)?$request->vehicle_details:NULL;
        $insuranceVehicle->vehicles_car_plate_no = isset($request->vehicles_car_plate_no)?$request->vehicles_car_plate_no:NULL;
        $insuranceVehicle->make_model = isset($request->make_model)?$request->make_model:NULL;
        $insuranceVehicle->engine_capacity = isset($request->engine_capacity)?$request->engine_capacity:NULL;
		$insuranceVehicle->date_of_registration = isset($request->date_of_registration)?$request->date_of_registration:NULL;
		$insuranceVehicle->year_of_manufacture = isset($request->year_of_manufacture)?$request->year_of_manufacture:NULL;
		$insuranceVehicle->is_opc_car = isset($request->is_opc_car)?$request->is_opc_car:NULL;
        $insuranceVehicle->save();

		}

        // EMAIL TO USER
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_INSURANCE_TO_USER'));
        //dd($email_template);
        if ($email_template) {
            $data = [];

            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['cc_to_email'] = [];

            $data['subject'] = $email_template->subject;


            $key = ['{{name}}'];
            $value = [$request->main_driver_full_name];
            $newContent = str_replace($key, $value, $email_template->content);
            $data['contents'] = $newContent;
			//dd($data);
            try {
                $mail = Mail::to($request->main_driver_email)->send(new EmailNotification($data));
            } catch (Exception $exception) {
                //dd($exception);
            }

        }


		// EMAIL TO PARTNER
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_INSURANCE_TO_PARTNER'));
        //dd($email_template);
        if ($email_template) {
            $data = [];

            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['cc_to_email'] = [];

            $key1 = ['{{customer}}'];
			$value1 = [$request->main_driver_full_name];
			$data['subject'] = str_replace($key1, $value1, $email_template->subject);

            // $data['subject'] = $email_template->subject;


            $partners =  Admin::partner()->get();
			//dd($partners);
			foreach($partners as $partner)
			{
			$url=url('admin/insurance/'.$insurance->id.'/edit');
			$link='<a href="'.$url.'">'.$url.'</a>';
			$key = ['{{name}}','{{url}}', '{{customer}}'];
            $value = [$partner->firstname,$link, $request->main_driver_full_name ?? ''];
            $newContent = str_replace($key, $value, $email_template->content);
            $data['contents'] = $newContent;
			$data['email'] = [$partner->email];
				try {
					SendEmail::dispatch($data);
				} catch (Exception $exception) {
					//dd($exception);
				}
			}

        }

        return redirect()->route('insurance.index')->with('success', __('constant.INSURANCE_APPLICATION_SUBMITTED'));
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = $this->title;
        $insurance = Insurance::join('insurance_information','insurance_information.insurance_id','insurances.id')->join('insurance_vehicles','insurance_vehicles.insurance_id','insurances.id')->where('insurances.id',$id)->first();

		if($this->user->admin_role==__('constant.USER_PARTNER'))
		{
		$quotations =  InsuranceQuotation::where('insurance_id',$id)->where('partner_id',$this->user->id)->get();
		}
		else
		{
		$quotations =  InsuranceQuotation::where('insurance_id',$id)->get();
		}

		$page_id=__('constant.INSURANCE_PAGE_ID');
		$page=Page::find($page_id);
		if($insurance->quotation_id==null)
		{
		$partners =  InsuranceQuotation::join('admins','admins.id','=','insurance_quotations.partner_id')->where('insurance_quotations.insurance_id', $id)->select('insurance_quotations.*')->groupBy('insurance_quotations.partner_id')->get();
		}
		else
		{
		$partners =  InsuranceQuotation::join('admins','admins.id','=','insurance_quotations.partner_id')->where('insurance_quotations.insurance_id', $id)->where('insurance_quotations.id', $insurance->quotation_id)->select('insurance_quotations.*')->groupBy('insurance_quotations.partner_id')->get();
		}
        return view('admin.insurance.show', compact('title', 'insurance','quotations','page','partners'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->title;
        $insurance = Insurance::join('insurance_information','insurance_information.insurance_id','insurances.id')->join('insurance_vehicles','insurance_vehicles.insurance_id','insurances.id')->where('insurances.id',$id)->first();
		if($insurance)
        {
            if(($insurance->partner_id!=$this->user->id) && !is_null($insurance->partner_id) || $this->user->admin_role==__('constant.USER_SUPER_ADMIN'))
            {
            abort(404);
            }
        }

        if($this->user->admin_role==__('constant.USER_PARTNER'))
		{
		$quotations =  InsuranceQuotation::where('insurance_id',$id)->where('partner_id',$this->user->id)->get();
		}
		else
		{
		$quotations =  InsuranceQuotation::where('insurance_id',$id)->get();
		}
        $page_id=__('constant.INSURANCE_PAGE_ID');
		$page=Page::find($page_id);
		//dd($quotations);
		return view('admin.insurance.edit', compact('title', 'insurance','quotations','page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
		$validation=[];
		$insQua = InsuranceQuotation::where('insurance_id', $id)->first();
		if(isset($request->final_pdf_submission) && $request->final_pdf_submission=='Y')
		{
			//IF Final PDF created
			$insurance = Insurance::find($id);
			$insurance->status = isset($request->status)?$request->status:NULL;
            $insurance->save();
		}
		else
		{
		$messages = [];
        $messages['main_driver_full_name.required'] = 'The name field is required.';
		$messages['main_driver_full_name.string'] = 'The name field accept string.';
		$messages['main_driver_nric.required'] = 'The NRIC field is required.';
		$messages['main_driver_date_of_birth.required'] = 'The date of birth field is required.';
		$messages['main_driver_license_pass_date.required'] = 'The license passed date field is required.';
		$messages['main_driver_gender.required'] = 'The gender field is required.';
		$messages['main_driver_marital_status.required'] = 'The marital status field is required.';
		$messages['main_driver_country_code.regex'] = 'The country code value is wrong.';
		$messages['main_driver_country_code.required'] = 'The country code field is required.';
		$messages['main_driver_contact_number.required'] = 'The contact number field is required.';
		$messages['main_driver_contact_number.numeric'] = 'The contact number field accept only numeric value.';
		$messages['main_driver_email.required'] = 'The email field is required.';
		$messages['main_driver_email.email'] = 'Please enter valid email id.';
		$messages['main_driver_occupation.required'] = 'The occupation field is required.';
		$messages['driver_full_name.required_if'] = 'The name field is required.';
		$messages['driver_occupation.required_if'] = 'The occupation field is required.';
		$messages['driver_license_pass_date.required_if'] = 'The license pass date field is required.';
		$messages['relationship_main_driver.required_if'] = 'The relationship to main driver field is required.';
        $messages['driver_nric.required_if'] = 'The NRIC field is required.';
        $messages['driver_date_of_birth.required_if'] = 'The date of bith field is required.';
        $messages['license_pass_date.required_if'] = 'License pass date field is required.';
        $messages['driver_gender.required_if'] = ' Gender field is required.';
        $messages['driver_marital_status.required_if'] = ' Marital status field is required.';
		$messages['year_of_manufacture.integer'] = 'Year of manufacture accept integer value.';
		$messages['year_of_manufacture.before_or_equal'] = 'Year of manufacture cannot be greater than date of registration.';
		    if(isset($request->date_of_registration))
			{
			$request->validate([
				'main_driver_full_name' => 'required',
				'main_driver_nric' => 'required',
				'main_driver_date_of_birth' => 'required|date',
				// 'main_driver_license_pass_date' => 'required|date',
				// 'main_driver_gender' => 'required',
				'main_driver_marital_status' => 'required',
				'main_driver_occupation' => 'required',
				'main_driver_country_code' => 'required',
				'main_driver_contact_number' => 'required',
				'main_driver_email' => 'required',
				// 'named_driver' => 'required',
				// 'driver_full_name' => 'required_if:named_driver,1',
				// 'driver_nric' => 'required_if:named_driver,1',
				// 'driver_date_of_birth' => 'required_if:named_driver,1',
				// 'driver_license_pass_date' => 'required_if:named_driver,1',
				// 'driver_marital_status' => 'required_if:named_driver,1',
				// 'driver_occupation' => 'required_if:named_driver,1',
				// 'relationship_main_driver' => 'required_if:named_driver,1',
				// 'car_plate_no' => 'required',
				// 'make_model' => 'required',
				// 'engine_capacity' => 'required',
				// 'date_of_registration' => 'required',
				// 'year_of_manufacture' => 'required|integer|before_or_equal:'.date("Y",strtotime($request->date_of_registration)).'|min:1900|max:'.date("Y"),
				// 'year_of_manufacture' => 'required',
				// 'nric_uen_business_passport' => 'nullable',
				// 'terms_condition' => 'required',
			], $messages);
			}
			else
			{
			$request->validate([
				'main_driver_full_name' => 'required',
				'main_driver_nric' => 'required',
				'main_driver_date_of_birth' => 'required',
				// 'main_driver_license_pass_date' => 'required|date',
				// 'main_driver_gender' => 'required',
				'main_driver_marital_status' => 'required',
				'main_driver_occupation' => 'required',
				'main_driver_country_code' => 'required',
				'main_driver_contact_number' => 'required',
				'main_driver_email' => 'required',
				// 'named_driver' => 'required',  //////
				// 'driver_full_name' => 'required_if:named_driver,1',
				// 'driver_nric' => 'required_if:named_driver,1',
				// 'driver_date_of_birth' => 'required_if:named_driver,1',
				// 'driver_license_pass_date' => 'required_if:named_driver,1',
				// 'driver_marital_status' => 'required_if:named_driver,1',
				// 'driver_occupation' => 'required_if:named_driver,1',
				// 'relationship_main_driver' => 'required_if:named_driver,1',
				// 'car_plate_no' => 'required',
				// 'make_model' => 'required',
				// 'engine_capacity' => 'required',
				// 'date_of_registration' => 'required',
				// 'year_of_manufacture' => 'required|integer|min:1900|max:'.date("Y"),
				// 'year_of_manufacture' => 'required',
				// 'nric_uen_business_passport' => 'nullable',
				// 'terms_condition' => 'required',
			], $messages);
			}
			
		if(isset($request->quotation_id))
		{
			$quote=getQuotation($request->quotation_id);
			if(isset($quote->insurance_proposal_form) && $quote->insurance_proposal_form!=NULL)
			{
				$validation=array_merge($validation,[
					'address' => 'required|string',
					'engine_number' => 'required',
					'chassis_number' => 'required',
					'finance_company' => 'required',
					'start_date_of_proposal' => 'required|date',
					'end_date' => 'required|date',
					'seating_capacity' => 'required|string',
					'previous_insurer' => 'required',
				]);
			}
			else
			{
				$validation=array_merge($validation,[
					'address' => 'required|string',
					'engine_number' => 'required',
					'chassis_number' => 'required',
					'finance_company' => 'required',
					'start_date_of_proposal' => 'required|date',
					'end_date' => 'required|date',
					'seating_capacity' => 'required|string',
					'previous_insurer' => 'required',
				// 	'insurance_proposal_form' => 'required|file|mimes:jpg,png,gif,jpeg,pdf|max:2500',
				// 	'partner_sign' => 'required',
				]);
			}

		}
        $request->validate($validation, $messages);

		$insurance = Insurance::find($id);
// 		dd($insurance);
		if($insurance->quotation_id==null)
		{
        $insurance->main_driver_full_name = isset($request->main_driver_full_name)?$request->main_driver_full_name:NULL;
        $insurance->main_driver_nric = isset($request->main_driver_nric)?$request->main_driver_nric:NULL;
        $insurance->main_driver_date_of_birth = isset($request->main_driver_date_of_birth) ? date('Y-m-d', strtotime($request->main_driver_date_of_birth)) : NULL;
		$insurance->main_driver_license_pass_date = isset($request->main_driver_license_pass_date) ? date('Y-m-d', strtotime($request->main_driver_license_pass_date)) : NULL;
        $insurance->main_driver_gender = isset($request->main_driver_gender)?$request->main_driver_gender:NULL;
        $insurance->main_driver_marital_status = isset($request->main_driver_marital_status)?$request->main_driver_marital_status:NULL;
        $insurance->main_driver_occupation = isset($request->main_driver_occupation)?$request->main_driver_occupation:NULL;
		$insurance->main_driver_country_code = isset($request->main_driver_country_code)?$request->main_driver_country_code:NULL;
		$insurance->main_driver_contact_number = isset($request->main_driver_contact_number)?$request->main_driver_contact_number:NULL;
		$insurance->main_driver_email = isset($request->main_driver_email)?$request->main_driver_email:NULL;
		$insurance->named_driver = isset($request->named_driver)?$request->named_driver:NULL;
		$insurance->driver_full_name = isset($request->driver_full_name)?$request->driver_full_name:NULL;
		$insurance->driver_nric = isset($request->driver_nric)?$request->driver_nric:NULL;
		$insurance->driver_date_of_birth = isset($request->driver_date_of_birth) ? date('Y-m-d', strtotime($request->driver_date_of_birth)) : NULL;
		$insurance->driver_license_pass_date = isset($request->driver_license_pass_date)?$request->driver_license_pass_date:NULL;
		$insurance->driver_gender = isset($request->driver_gender)?$request->driver_gender:NULL;
		$insurance->driver_marital_status = isset($request->driver_marital_status)?$request->driver_marital_status:NULL;
		$insurance->driver_occupation = isset($request->driver_occupation)?$request->driver_occupation:NULL;
		$insurance->relationship_main_driver = isset($request->relationship_main_driver)?$request->relationship_main_driver:NULL;
		$insurance->terms_condition = isset($request->terms_condition)?$request->terms_condition:NULL;
		$insurance->quotation_id = isset($request->quotation_id)?$request->quotation_id:NULL;
		$insurance->main_driver_employer = isset($request->main_driver_employer) ? $request->main_driver_employer : NULL;
		$insurance->main_driver_licence_class = isset($request->main_driver_licence_class) ? $request->main_driver_licence_class : NULL;
		$insurance->main_driver_licence_validity = isset($request->main_driver_licence_validity) ? $request->main_driver_licence_validity : NULL;
		$insurance->main_driver_merit_status = isset($request->main_driver_merit_status) ? $request->main_driver_merit_status : NULL;
		$insurance->driver_passport = isset($request->driver_passport) ? $request->driver_passport : NULL;
		$insurance->driver_nationality = isset($request->driver_nationality) ? $request->driver_nationality : NULL;
		$insurance->driver_license_class = isset($request->driver_license_class) ? $request->driver_license_class : NULL;
		$insurance->driver_license_validity = isset($request->driver_license_validity) ? $request->driver_license_validity : NULL;
		$insurance->driver_merit_status = isset($request->driver_merit_status) ? $request->driver_merit_status : NULL;
		}
		if(isset($request->status))
		{
		$insurance->status = $request->status;
		}
        $insurance->save();


        if($insurance->quotation_id==null)
		{
		$insuranceInformation =InsuranceInformation::find($id);
        $insuranceInformation->insurance_id = $insurance->id;
        // $insuranceInformation->car_plate_no = isset($request->car_plate_no)?$request->car_plate_no:NULL;
        // $insuranceInformation->nric_uen_business_passport = isset($request->nric_uen_business_passport)?$request->nric_uen_business_passport:NULL;
        $insuranceInformation->type_of_quote = isset($request->type_of_quote) ? $request->type_of_quote : NULL;
        $insuranceInformation->ncd = isset($request->ncd)?$request->ncd:NULL;
        $insuranceInformation->previous_vehicle_number = isset($request->previous_vehicle_number)?$request->previous_vehicle_number:NULL;
		$insuranceInformation->terms_condition = isset($request->terms_condition)?$request->terms_condition:NULL;
        $insuranceInformation->save();

		$insuranceVehicle = InsuranceVehicle::find($id);
        $insuranceVehicle->insurance_id = $insurance->id;
        //$insuranceVehicle->vehicle_details = isset($request->vehicle_details)?$request->vehicle_details:NULL;
        $insuranceVehicle->vehicles_car_plate_no = isset($request->vehicles_car_plate_no)?$request->vehicles_car_plate_no:NULL;
        $insuranceVehicle->make_model = isset($request->make_model)?$request->make_model:NULL;
        $insuranceVehicle->engine_capacity = isset($request->engine_capacity)?str_replace(',','',$request->engine_capacity):NULL;
		$insuranceVehicle->date_of_registration = isset($request->date_of_registration) ? date('Y-m-d', strtotime($request->date_of_registration)) : NULL;
		$insuranceVehicle->year_of_manufacture = isset($request->year_of_manufacture)?$request->year_of_manufacture:NULL;
		$insuranceVehicle->is_opc_car = isset($request->is_opc_car)?$request->is_opc_car:NULL;
		$insuranceVehicle->vehicle_schme = isset($request->vehicle_schme) ? $request->vehicle_schme : NULL;
		$insuranceVehicle->vehicle_type = isset($request->vehicle_type) ? $request->vehicle_type : NULL;
		$insuranceVehicle->vehicle_primary_color = isset($request->vehicle_primary_color) ? $request->vehicle_primary_color : NULL;
		$insuranceVehicle->vehicle_engine_number = isset($request->vehicle_engine_number) ? $request->vehicle_engine_number : NULL;
		$insuranceVehicle->vechile_chasis_number = isset($request->vechile_chasis_number) ? $request->vechile_chasis_number : NULL;
        $insuranceVehicle->save();
		}
		//ADDITIONAL INFORMATION
        if(isset($request->quotation_id) )
		{
		        //When quotation accepted



                $insuranceQuotation =InsuranceQuotation::find($request->quotation_id);
				$insuranceQuotation->insurance_id = $insurance->id;
				$insuranceQuotation->partner_id = $this->user->id;
				$insuranceQuotation->address = isset($request->address)?$request->address:NULL;
				$insuranceQuotation->engine_number = isset($request->engine_number)?$request->engine_number:NULL;
				$insuranceQuotation->chassis_number = isset($request->chassis_number)?$request->chassis_number:NULL;
				$insuranceQuotation->finance_company = isset($request->finance_company)?$request->finance_company:NULL;
				$insuranceQuotation->start_date_of_proposal = isset($request->start_date_of_proposal) ? date('Y-m-d', strtotime($request->start_date_of_proposal)) : NULL;
				$insuranceQuotation->end_date = isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : NULL;
				$insuranceQuotation->seating_capacity = isset($request->seating_capacity)?$request->seating_capacity:NULL;
				$insuranceQuotation->previous_insurer = isset($request->previous_insurer)?$request->previous_insurer:NULL;
				
				// Bhupesh Generate PDF
				$insurance = Insurance::join('insurance_information', 'insurance_information.insurance_id', 'insurances.id')->join('insurance_vehicles', 'insurance_vehicles.insurance_id', 'insurances.id')->where('insurances.id', $insuranceQuotation->insurance_id)->first();
				$quote = getQuotation($insurance->quotation_id);
				$info = pathinfo($quote->insurance_proposal_form);

				$quotations =  InsuranceQuotation::where('insurance_id', $insuranceQuotation->insurance_id)->where('partner_id', $insurance->partner_id)->get();
				$content = [];
				$termandcondition = null;
				$pdf = PDF::loadView('pdf.insurance', compact("insurance", "quotations", "termandcondition"))->setPaper('a4', 'potrait');
                $path = public_path('insurance_form');
                $fileName =  rand().'-pdfview' . '.' . 'pdf' ;
                $pdf->save($path . '/' . $fileName);
                // $content = View::make('pdf.insurance', compact("insurance", "quotations", "termandcondition"));
				// $insurancePDF = $this->generatePDF($content, "insurance.pdf");
				// $pdfFile1Path = public_path() . '/' . $insurancePDF;
				$insuranceIdd = $insurance->id;
				$insuranceee = Insurance::where('id', $insuranceIdd)->first();
				$insuranceee->insurance_pdf = $fileName;
				$insuranceee->save();
				
				
					if ($request->hasFile('insurance_proposal_form')) {
					$proposal_form = $request->file('insurance_proposal_form');
					$filename = Carbon::now()->format('Y-m-d H-i-s') . '__' . guid() . '__' . $proposal_form->getClientOriginalName();
					$filepath = 'storage/insurance_proposal_form/';
					Storage::putFileAs(
					'public/insurance_proposal_form', $proposal_form, $filename
					);
					$path_proposal_form = $filepath . $filename;
					$insuranceQuotation->insurance_proposal_form = $path_proposal_form;
					}



				if ($request->partner_sign) {
			    $encoded_image = explode(",", $request->partner_sign)[1];
				$decoded_image = base64_decode($encoded_image);
					    $partner_sign = $decoded_image;
						$filename = Carbon::now()->format('Y-m-d H-i-s') . '__' . guid() . '__signature.jpg';
						$filepath = 'storage/signature/';

						$path_signature = $filepath . $filename;
						file_put_contents($path_signature, $partner_sign);
						$insuranceQuotation->partner_sign = $path_signature;

                    $insurance_partner= Auth::user()->firstname.' '.Auth::user()->lastname;
					 // EMAIL TO USER
					$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_CUSTOMER_SIGN_SUBMIT'));
					//dd($email_template);
					if ($email_template) {
						$data = [];

						$data['email_sender_name'] = $this->systemSetting()->email_sender_name;
						$data['from_email'] = $this->systemSetting()->from_email;
						$data['cc_to_email'] = [];
						$data['email'] = [$request->main_driver_email];

						$data['subject'] = $email_template->subject;
						$url=url('insurance-applications/'.$id);
						$link='<a href="'.$url.'">'.$url.'</a>';
						$key = ['{{name}}','{{link}}','{{insurance_partner}}'];
						$value = [$request->main_driver_full_name,$link,$insurance_partner];
						$newContent = str_replace($key, $value, $email_template->content);
						$data['contents'] = $newContent;
						//dd($data);

							try {
								SendEmail::dispatch($data);
							} catch (Exception $exception) {
								//dd($exception);
							}
					}

					//Whatapp message integration
					$message_template = $this->messageTemplate(__('constant.MESSAGE_TEMPLATE_TO_USER_PARTNER_SIGNED'));
					if ($message_template) {
						$link=url('insurance-applications/'.$insurance->id);

						$key = ['{{link}}','{{insurance_partner}}'];
						$value = [$link,$insurance_partner];
						$newContent = str_replace($key, $value, $message_template->content);

						// send whatsapp message
						//dd($newContent);
						$contact_number=$request->main_driver_country_code.$request->main_driver_contact_number;
						//echo $contact_number.'--'.$newContent;die;
                        try {
                            sendWhatsappMessage($contact_number, $newContent);

                        } catch (Exception $exception) {
                            Log::info($exception);
                            //dd($exception);
                        }
					}


					}

				$insuranceQuotation->save();
				if ($request->partner_sign)
				{
				return redirect()->route('insurance.index')->with('success', __('constant.QUOTATION_ADDITIONAL_SUBMITTED'));
				}
		}

		//QUOTATION SUBMITTED
		if(isset($request->quotation_number))
		{


            $insurance = Insurance::find($insurance->id);
            $insurance->discount = systemSetting()->insurance_discount;
            $insurance->save();

            for($i=0;$i<count($request->quotation_number);$i++)
			{
				if(isset($request->q_id[$i]))
				{

				//Update quotation
				$insuranceQuotation =InsuranceQuotation::find($request->q_id[$i]);
				$insuranceQuotation->partner_id = $this->user->id;
				$insuranceQuotation->insurance_id = $insurance->id;
				$insuranceQuotation->quotation_number = isset($request->quotation_number[$i])?$request->quotation_number[$i]:NULL;
				$insuranceQuotation->insurer_name = isset($request->insurer_name[$i])?$request->insurer_name[$i]:NULL;
				$insuranceQuotation->premium = isset($request->premium[$i])?$request->premium[$i]:NULL;
				$insuranceQuotation->excess_own_damage = isset($request->excess_own_damage[$i])?$request->excess_own_damage[$i]:NULL;
				$insuranceQuotation->excess_party = isset($request->excess_party[$i])?$request->excess_party[$i]:NULL;
				$insuranceQuotation->remark = isset($request->remark[$i])?$request->remark[$i]:NULL;
				$insuranceQuotation->save();
				//dd($insuranceQuotation);
				}
				else
				{
				//New insertion quotation
				$insuranceQuotation = new InsuranceQuotation();
				$insuranceQuotation->partner_id = $this->user->id;
				$insuranceQuotation->insurance_id = $insurance->id;
				$insuranceQuotation->quotation_number = isset($request->quotation_number[$i])?$request->quotation_number[$i]:NULL;
				$insuranceQuotation->insurer_name = isset($request->insurer_name[$i])?$request->insurer_name[$i]:NULL;
				$insuranceQuotation->premium = isset($request->premium[$i])?$request->premium[$i]:NULL;
				$insuranceQuotation->excess_own_damage = isset($request->excess_own_damage[$i])?$request->excess_own_damage[$i]:NULL;
				$insuranceQuotation->excess_party = isset($request->excess_party[$i])?$request->excess_party[$i]:NULL;
				$insuranceQuotation->remark = isset($request->remark[$i])?$request->remark[$i]:NULL;
				$insuranceQuotation->save();



				}
			}

			        $insurance_partner= Auth::user()->firstname.' '.Auth::user()->lastname;
					 // EMAIL TO USER
					$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_QUOTATION_SUBMISSION_TO_USER'));
					//dd($email_template);
					if ($email_template) {
						$data = [];

						$data['email_sender_name'] = $this->systemSetting()->email_sender_name;
						$data['from_email'] = $this->systemSetting()->from_email;
						$data['cc_to_email'] = [];
						$data['email'] = [$request->main_driver_email];

						$data['subject'] = $email_template->subject;

			            $url=url('insurance-applications/'.$insurance->id);
						$link='<a href="'.$url.'">'.$url.'</a>';

						$key = ['{{name}}','{{link}}','{{insurance_partner}}'];
						$value = [$request->main_driver_full_name,$link,$insurance_partner];
						$newContent = str_replace($key, $value, $email_template->content);
						$data['contents'] = $newContent;
						//dd($data);

							try {
								SendEmail::dispatchNow($data);
							} catch (Exception $exception) {
								//dd($exception);
							}
					}
					//Whatapp message integration
					$message_template = $this->messageTemplate(__('constant.MESSAGE_TEMPLATE_QUOTATION_SUBMISSION_TO_USER'));
					if ($message_template) {
						$link=url('insurance-applications/'.$insurance->id);

						$key = ['{{link}}','{{insurance_partner}}'];
						$value = [$link,$insurance_partner];
						$newContent = str_replace($key, $value, $message_template->content);
						$contact_number=$request->main_driver_country_code.$request->main_driver_contact_number;
						//echo $contact_number.'--'.$newContent;die;
						// send whatsapp message
						//dd($newContent);
                        try {
                            sendWhatsappMessage($contact_number, $newContent);

                        } catch (Exception $exception) {
                            Log::info($exception);
                            dd($exception);
                        }
					}

		  return redirect()->route('insurance.index')->with('success', __('constant.QUOTATION_DETAIL_SUBMITTED', ['module' => $this->title]));
		}

		}

        return redirect()->route('insurance.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	 
    public function delete_quotation(Request $request)
	{
		$id =$request->id;
		InsuranceQuotation::destroy($id);
	}
	
	
    public function destroy(Request $request, $id)
    {
        $id = explode(',', $request->multiple_delete);
        try {
            // Insurance::destroy($id);
            foreach($id as $id){
							$insuranceVehicle = InsuranceVehicle::where('insurance_id', $id)->pluck('id')->toArray();
							if($insuranceVehicle){
								InsuranceVehicle::destroy($insuranceVehicle);
								// $insuranceVehicle->delete();
							}
							
							$insuranceInformation = InsuranceInformation::where('insurance_id', $id)->pluck('id')->toArray();
							if($insuranceInformation){
								InsuranceInformation::destroy($insuranceInformation);
								// $insuranceInformation->delete();
							}
							$insuranceQuotation = InsuranceQuotation::where('insurance_id', $id)->pluck('id')->toArray();
							if($insuranceQuotation){
								InsuranceQuotation::destroy($insuranceQuotation);
								// $insuranceQuotation->delete();
							}
							Insurance::destroy($id);
						}
        } catch (QueryException $e) {

            if ($e->getCode() == "23000") {

                //!!23000 is sql code for integrity constraint violation
                return redirect()->back()->with('error',  __('constant.FOREIGN', ['module'    =>  $this->title]));
            }
        }

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

	 public function search(Request $request)
    {
        $title = $this->title;
        $secondary_title = "Search";
        $insurance =  Insurance::select('insurances.*')->search($request)->orderBy('created_at','desc')->paginate($this->pagination);
		//dd($search);
        return view('admin.insurance.index', compact('title', 'secondary_title', 'insurance'));
    }
}
