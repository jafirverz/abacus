<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Notification;
use App\Insurance;
use App\InsuranceInformation;
use App\InsuranceVehicle;
use App\Mail\AdminSideMail;
use Illuminate\Http\Request;
use App\Page;
use App\Menu;
use App\Slider;
use App\SystemSetting;
use App\User;
use App\Partner;
use App\Traits\SystemSettingTrait;
use App\Traits\GetSmartBlock;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use App\Jobs\SendEmail;
use Exception;
use Illuminate\Support\Facades\Mail;
use auth;

class InsuranceController extends Controller
{
    use SystemSettingTrait, GetSmartBlock, GetEmailTemplate;

    public function __construct()
    {
        $this->middleware('auth:web')->except('index');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });

		$this->system_settings = $this->systemSetting();
        $this->smart_blocks = $this->smartBlock();
    }

	public function index($slug = 'insurance',Request $request)
    {
		$request->session()->put('previous_url', url()->current());
        $page = get_page_by_slug($slug);
		//dd($page);
        if (!$page) {
            return abort(404);
        }
		return view('insurance',compact('page'));
    }

    public function insurance_store(Request $request)
    {
		$system_settings = $this->system_settings;
		// Get verify response data
		// $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $system_settings->recaptcha_secret_key . '&response=' . $request->captcha_response);
		// $responseData = json_decode($verifyResponse);
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
		$messages['driver_uen.required_if'] = 'The UEN field is required.';
		$messages['driver_passport.required_if'] = 'The Passport field is required.';
		$messages['driver_date_of_birth.required_if'] = 'The date of birth field is required.';
		$messages['license_pass_date.required_if'] = 'License pass date field is required.';
		$messages['driver_gender.required_if'] = ' Gender field is required.';
		$messages['driver_marital_status.required_if'] = ' Marital status field is required.';
		$messages['year_of_manufacture.integer'] = 'Year of manufacture accept integer value.';
		$messages['year_of_manufacture.before_or_equal'] = 'Year of manufacture cannot be greater than date of registration.';

		$request->validate([
			'main_driver_full_name' => 'required',
			'main_driver_nric' => 'required|min:4|max:4',
			'main_driver_uen' => 'required|min:4|max:4',
			'main_driver_passport' => 'required|min:4|max:4',
			'main_driver_date_of_birth' => 'required|date',
			'main_driver_license_pass_date' => 'required|date',
			'main_driver_gender' => 'required',
			'main_driver_marital_status' => 'required',
			'main_driver_occupation' => 'required',
			// 'main_driver_country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',
			'main_driver_contact_number' => 'required|numeric',
			'main_driver_email' => 'required|email',
			// 'named_driver' => 'required',
			'driver_full_name' => 'required_if:nameddriver,yes',
			'driver_nric' => 'required_if:nameddriver,yes',
			'driver_uen' => 'required_if:nameddriver,yes',
			'driver_passport' => 'required_if:nameddriver,yes',
			'driver_date_of_birth' => 'required_if:nameddriver,yes',
			'driver_license_pass_date' => 'required_if:nameddriver,yes',
			'driver_marital_status' => 'required_if:nameddriver,yes',
			'driver_occupation' => 'required_if:nameddriver,yes',
			'relationship_main_driver' => 'required_if:nameddriver,yes',
			'car_plate_no' => 'required',
			'vehicle_make' => 'required',
			'vehicle_model' => 'required',
			'engine_capacity' => 'required',
			'date_of_registration' => 'required',
			'year_of_manufacture' => 'required',
			// 'nric_uen_business_passport' => 'nullable|string|min:4|max:4',
			'terms_condition' => 'required',
		], $messages);

		// if (isset($request->date_of_registration)) {
		// 	$request->validate([
		// 		'main_driver_full_name' => 'required',
		// 		'main_driver_nric' => 'required|string|min:4|max:4',
		// 		'main_driver_uen' => 'required|string|min:4|max:4',
		// 		'main_driver_passport' => 'required|string|min:4|max:4',
		// 		'main_driver_date_of_birth' => 'required|date',
		// 		'main_driver_license_pass_date' => 'required|date',
		// 		'main_driver_gender' => 'required',
		// 		'main_driver_marital_status' => 'required',
		// 		'main_driver_occupation' => 'required',
		// 		'main_driver_country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',
		// 		'main_driver_contact_number' => 'required|numeric',
		// 		'main_driver_email' => 'required|email',
		// 		'named_driver' => 'required',
		// 		'driver_full_name' => 'required_if:nameddriver,yes',
		// 		'driver_nric' => 'required_if:nameddriver,yes',
		// 		'driver_uen' => 'required_if:nameddriver,yes',
		// 		'driver_passport' => 'required_if:nameddriver,yes',
		// 		'driver_date_of_birth' => 'required_if:nameddriver,yes',
		// 		'driver_license_pass_date' => 'required_if:nameddriver,yes',
		// 		'driver_marital_status' => 'required_if:nameddriver,yes',
		// 		'driver_occupation' => 'required_if:nameddriver,yes',
		// 		'relationship_main_driver' => 'required_if:nameddriver,yes',
		// 		'car_plate_no' => 'required',
		// 		'make_model' => 'required',
		// 		'engine_capacity' => 'required',
		// 		'date_of_registration' => 'required',
		// 		'year_of_manufacture' => 'required|integer|before_or_equal:' . date("Y", strtotime($request->date_of_registration)) . '|min:1900|max:' . date("Y"),
		// 		'nric_uen_business_passport' => 'nullable|string|min:4|max:4',
		// 		'terms_condition' => 'required',
		// 	], $messages);
		// } else {
		// 	$request->validate([
		// 		'main_driver_full_name' => 'required',
		// 		'main_driver_nric' => 'required|string|min:4|max:4',
		// 		'main_driver_uen' => 'required|string|min:4|max:4',
		// 		'main_driver_passport' => 'required|string|min:4|max:4',
		// 		'main_driver_date_of_birth' => 'required|date',
		// 		'main_driver_license_pass_date' => 'required|date',
		// 		'main_driver_gender' => 'required',
		// 		'main_driver_marital_status' => 'required',
		// 		'main_driver_occupation' => 'required',
		// 		'main_driver_country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',
		// 		'main_driver_contact_number' => 'required|numeric',
		// 		'main_driver_email' => 'required|email',
		// 		'named_driver' => 'required',
		// 		'driver_full_name' => 'required_if:named_driver,1',
		// 		'driver_nric' => 'required_if:named_driver,1',
		// 		'driver_date_of_birth' => 'required_if:named_driver,1',
		// 		'driver_license_pass_date' => 'required_if:named_driver,1',
		// 		'driver_marital_status' => 'required_if:named_driver,1',
		// 		'driver_occupation' => 'required_if:named_driver,1',
		// 		'relationship_main_driver' => 'required_if:named_driver,1',
		// 		'car_plate_no' => 'required',
		// 		'make_model' => 'required',
		// 		'engine_capacity' => 'required',
		// 		'date_of_registration' => 'required',
		// 		'year_of_manufacture' => 'required|integer|min:1900|max:' . date("Y"),
		// 		'nric_uen_business_passport' => 'nullable|string|min:4|max:4',
		// 		'terms_condition' => 'required',
		// 	], $messages);
		// }

		// if (!$responseData->success) {
		// 	return redirect()->back()->withInput()->with('error', __('constant.CAPTCHA_ERROR'));
		// }
		// dd($request->all());
		$insurance = new Insurance();
		$insurance->user_id = Auth::user()->id;

		if ($request->hasFile('upload_photo')) {
			$imageNameArr = [];
			foreach ($request->upload_photo as $file) {
				// you can also use the original name
				$imageName = time() . '-' . $file->getClientOriginalName();
				$imageNameArr[] = $imageName;
				// Upload file to public path in images directory
				$file->move(public_path('images'), $imageName);
				// Database operation
			}
		}


		//$insurance->discount = systemSetting()->insurance_discount;
		$insurance->main_driver_full_name = isset($request->main_driver_full_name) ? $request->main_driver_full_name : NULL;
		$insurance->main_driver_nric = isset($request->main_driver_nric) ? $request->main_driver_nric : NULL;
		$insurance->main_driver_date_of_birth = isset($request->main_driver_date_of_birth) ? $request->main_driver_date_of_birth : NULL;
		$insurance->main_driver_license_pass_date = isset($request->main_driver_license_pass_date) ? $request->main_driver_license_pass_date : NULL;
		$insurance->main_driver_gender = isset($request->main_driver_gender) ? $request->main_driver_gender : NULL;
		$insurance->main_driver_marital_status = isset($request->main_driver_marital_status) ? $request->main_driver_marital_status : NULL;
		$insurance->main_driver_occupation = isset($request->main_driver_occupation) ? $request->main_driver_occupation : NULL;
		// $insurance->main_driver_country_code = isset($request->main_driver_country_code) ? $request->main_driver_country_code : NULL;
		$insurance->main_driver_contact_number = isset($request->main_driver_contact_number) ? $request->main_driver_contact_number : NULL;
		$insurance->main_driver_email = isset($request->main_driver_email) ? $request->main_driver_email : NULL;
		// $insurance->named_driver = isset($request->named_driver) ? $request->named_driver : NULL;
		$insurance->driver_full_name = isset($request->driver_full_name) ? $request->driver_full_name : NULL;
		$insurance->driver_nric = isset($request->driver_nric) ? $request->driver_nric : NULL;
		$insurance->driver_date_of_birth = isset($request->driver_date_of_birth) ? $request->driver_date_of_birth : NULL;
		$insurance->driver_license_pass_date = isset($request->driver_license_pass_date) ? $request->driver_license_pass_date : NULL;
		$insurance->driver_gender = isset($request->driver_gender) ? $request->driver_gender : NULL;
		$insurance->driver_marital_status = isset($request->driver_marital_status) ? $request->driver_marital_status : NULL;
		$insurance->driver_occupation = isset($request->driver_occupation) ? $request->driver_occupation : NULL;
		$insurance->relationship_main_driver = isset($request->relationship_main_driver) ? $request->relationship_main_driver : NULL;
		$insurance->terms_condition = isset($request->terms_condition) ? $request->terms_condition : NULL;
		$insurance->status = 2;
		$insurance->ncd_percentage = isset($request->ncd_percentage) ? $request->ncd_percentage : NULL;
		$insurance->previous_vehicle_no = isset($request->previous_vehicle_no) ? $request->previous_vehicle_no : NULL;
		// new filed
		$insurance->document1 = isset($imageNameArr[0]) ? $imageNameArr[0] : NULL;
		$insurance->document2 = isset($imageNameArr[1]) ? $imageNameArr[1] : NULL;
		$insurance->driver_uen = isset($request->driver_uen) ? $request->driver_uen : NULL;
		$insurance->driver_passport = isset($request->driver_passport) ? $request->driver_passport : NULL;
		$insurance->driver_nationality = isset($request->driver_nationality) ? $request->driver_nationality : NULL;
		$insurance->main_driver_uen = isset($request->main_driver_uen) ? $request->main_driver_uen : NULL;
		$insurance->main_driver_passport = isset($request->main_driver_passport) ? $request->main_driver_passport : NULL;
		$insurance->main_driver_nationality = isset($request->main_driver_nationality) ? $request->main_driver_nationality : NULL;		
		$insurance->save();

		if ($insurance->id) {

			$insuranceInformation = new InsuranceInformation();
			$insuranceInformation->insurance_id = $insurance->id;
			$insuranceInformation->car_plate_no = isset($request->car_plate_no) ? $request->car_plate_no : NULL;
			// $insuranceInformation->nric_uen_business_passport = isset($request->nric_uen_business_passport) ? $request->nric_uen_business_passport : NULL;
			$insuranceInformation->ncd = isset($request->ncd) ? $request->ncd : NULL;
			$insuranceInformation->previous_vehicle_number = isset($request->previous_vehicle_number) ? $request->previous_vehicle_number : NULL;
			$insuranceInformation->terms_condition = isset($request->terms_condition) ? $request->terms_condition : NULL;
			$insuranceInformation->save();

			$insuranceVehicle = new InsuranceVehicle();
			$insuranceVehicle->insurance_id = $insurance->id;
			//$insuranceVehicle->vehicle_details = isset($request->vehicle_details)?$request->vehicle_details:NULL;
			$insuranceVehicle->vehicles_car_plate_no = isset($request->vehicles_car_plate_no) ? $request->vehicles_car_plate_no : NULL;
			$insuranceVehicle->make_model = isset($request->vehicle_make) . ' ' . $request->vehicle_model ? $request->vehicle_make : NULL;
			$insuranceVehicle->engine_capacity = isset($request->engine_capacity) ? $request->engine_capacity : NULL;
			$insuranceVehicle->date_of_registration = isset($request->date_of_registration) ? $request->date_of_registration : NULL;
			$insuranceVehicle->year_of_manufacture = isset($request->year_of_manufacture) ? $request->year_of_manufacture : NULL;
			$insuranceVehicle->is_opc_car = isset($request->is_opc_car) ? $request->is_opc_car : NULL;
			$insuranceVehicle->save();
		}

		$partners =  Admin::partner()->get();
		//dd($partners);
		foreach ($partners as $partner) {
			$url = url('admin/insurance/' . $insurance->id . '/edit');
			$link = '<a href="' . $url . '">' . $url . '</a>';
			$message = $request->main_driver_full_name . ' has submitted an application for Insurance.';
			$notification = new Notification();
			$notification->insurance_id = $insurance->id;
			$notification->quotaton_id = NULL;
			$notification->partner_id = $partner->id;
			$notification->message = $message;
			$notification->link = $url;
			$notification->status = 1;
			$notification->save();
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

			$data['subject'] = $email_template->subject;


			$partners =  Admin::partner()->get();
			//dd($partners);
			foreach ($partners as $partner) {
				$url = url('admin/insurance/' . $insurance->id . '/edit');
				$link = '<a href="' . $url . '">' . $url . '</a>';
				$key = ['{{name}}', '{{url}}', '{{customer}}'];
				$value = [$partner->firstname, $link, $request->main_driver_full_name];
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

		return redirect()->back()->with('success',   __('constant.INSURANCE_APPLICATION_SUBMITTED'));

    }
}
