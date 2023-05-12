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
use Illuminate\Support\Facades\Session;
use PDF;

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

	public function index($slug = 'insurance', Request $request)
	{
		$request->session()->put('previous_url', url()->current());
		$page = get_page_by_slug($slug);
		//dd($page);
		if (!$page) {
			return abort(404);
		}
		return view('insurance', compact('page'));
	}

	public function insurance_store(Request $request)
	{
		// dd($request->all());
		$system_settings = $this->system_settings;
		// Get verify response data
		// $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $system_settings->recaptcha_secret_key . '&response=' . $request->captcha_response);
		// $responseData = json_decode($verifyResponse);
		$messages = [];
// 		$messages['main_driver_full_name.required'] = 'The name field is required.';
// 		$messages['main_driver_full_name.string'] = 'The name field accept string.';
// 		$messages['main_driver_nric.required'] = 'The NRIC field is required.';
// 		$messages['main_driver_date_of_birth.required'] = 'The date of birth field is required.';
// 		$messages['main_driver_license_pass_date.required'] = 'The license passed date field is required.';
// 		$messages['main_driver_gender.required'] = 'The gender field is required.';
// 		$messages['main_driver_marital_status.required'] = 'The marital status field is required.';
// 		$messages['main_driver_country_code.regex'] = 'The country code value is wrong.';
// 		$messages['main_driver_country_code.required'] = 'The country code field is required.';
// 		$messages['main_driver_contact_number.required'] = 'The contact number field is required.';
// 		$messages['main_driver_contact_number.numeric'] = 'The contact number field accept only numeric value.';
// 		$messages['main_driver_email.required'] = 'The email field is required.';
// 		$messages['main_driver_email.email'] = 'Please enter valid email id.';
// 		$messages['main_driver_occupation.required'] = 'The occupation field is required.';
// 		$messages['driver_full_name.required_if'] = 'The name field is required.';
// 		$messages['driver_occupation.required_if'] = 'The occupation field is required.';
// 		$messages['driver_license_class.required_if'] = 'Driver License Class is required';
// 		$messages['driver_license_validity.required_if'] = 'Driver License Validity is required.';
// 		$messages['driver_merit_status.required_if'] = 'Driver Merit status is required.';
// 		$messages['driver_license_pass_date.required_if'] = 'The license pass date field is required.';
// 		$messages['relationship_main_driver.required_if'] = 'The relationship to main driver field is required.';
// 		$messages['driver_nric.required_if'] = 'The NRIC field is required.';
// 		$messages['driver_uen.required_if'] = 'The UEN field is required.';
// 		$messages['driver_passport.required_if'] = 'The Passport field is required.';
// 		$messages['driver_date_of_birth.required_if'] = 'The date of birth field is required.';
// 		$messages['license_pass_date.required_if'] = 'License pass date field is required.';
// 		$messages['driver_gender.required_if'] = ' Gender field is required.';
// 		$messages['driver_marital_status.required_if'] = ' Marital status field is required.';
// 		$messages['year_of_manufacture.integer'] = 'Year of manufacture accept integer value.';
// 		$messages['year_of_manufacture.before_or_equal'] = 'Year of manufacture cannot be greater than date of registration.';

// 		$messages['car_plate_no1.required_if'] = 'The Vehicle no field is required.';
// 		$messages['vehicle_make1.required_if'] = 'The Vehicle make field is required.';
// 		$messages['vehicle_model1.required_if'] = 'The Vehicle model field is required.';
// 		$messages['engine_capacity1.required_if'] = 'The Vehicle engine capacity field is required.';
// 		$messages['date_of_registration1.required_if'] = 'The Vehicle Original Registration field is required.';
// 		$messages['year_of_manufacture1.required_if'] = 'Year of manufacture field is required.';

// 		$messages['car_plate_no.required_if'] = 'The Vehicle no field is required.';
// 		$messages['vehicle_make.required_if'] = 'The Vehicle make field is required.';
// 		$messages['vehicle_model.required_if'] = 'The Vehicle model field is required.';
// 		$messages['engine_capacity.required_if'] = 'The Vehicle engine capacity field is required.';
// 		$messages['date_of_registration.required_if'] = 'The Vehicle Original Registration field is required.';
// 		$messages['year_of_manufacture.required_if'] = 'Year of manufacture field is required.';
// 		$messages['vehicle_schme.required'] = 'The Vehicle Scheme field is required.';
// 		$messages['vechile_chasis_number.required'] = 'The Vehicle chassis no field is required.'; //
// 		$messages['vechile_propellant.required'] = 'The Vehicle propellant field is required.'; //

        $messages['main_driver_full_name.required'] = 'This field is required';
		$messages['main_driver_full_name.string'] = 'This field is required';
		$messages['main_driver_nric.required'] = 'This field is required';
		$messages['main_driver_date_of_birth.required'] = 'This field is required';
		$messages['main_driver_license_pass_date.required'] = 'This field is required';
		$messages['main_driver_gender.required'] = 'This field is required';
		$messages['main_driver_marital_status.required'] = 'This field is required';
		$messages['main_driver_country_code.regex'] = 'This field is required';
		$messages['main_driver_country_code.required'] = 'This field is required';
		$messages['main_driver_contact_number.required'] = 'This field is required';
		$messages['main_driver_contact_number.numeric'] = 'This field is required';
		$messages['main_driver_email.required'] = 'This field is required';
		$messages['main_driver_email.email'] = 'This field is required';
		$messages['main_driver_occupation.required'] = 'This field is required';
		$messages['driver_full_name.required_if'] = 'This field is required';
		$messages['driver_occupation.required_if'] = 'This field is required';


		$messages['driver_license_class.required_if'] = 'This field is required';
		$messages['driver_license_validity.required_if'] = 'This field is required';
		$messages['driver_merit_status.required_if'] = 'This field is required';

		$messages['driver_license_pass_date.required_if'] = 'This field is required';
		$messages['relationship_main_driver.required_if'] = 'This field is required';
		$messages['driver_nric.required_if'] = 'This field is required';
		$messages['driver_uen.required_if'] = 'This field is required';
		$messages['driver_passport.required_if'] = 'This field is required';
		$messages['driver_date_of_birth.required_if'] = 'This field is required';
		$messages['license_pass_date.required_if'] = 'This field is required';
		$messages['driver_gender.required_if'] = 'This field is required';
		$messages['driver_nationality.required_if'] = 'This field is required'; //
		$messages['driver_marital_status.required_if'] = 'This field is required';
		$messages['year_of_manufacture.integer'] = 'This field is required';
		$messages['year_of_manufacture.before_or_equal'] = 'This field is required';

		$messages['car_plate_no1.required_if'] = 'This field is required';
		$messages['vehicle_schme1.required_if'] = 'This field is required'; //
		$messages['vehicle_type1.required_if'] = 'This field is required'; //
		$messages['vehicle_primary_color1.required_if'] = 'This field is required'; //
		$messages['vehicle_engine_number1.required_if'] = 'This field is required'; //
		$messages['vechile_chasis_number1.required_if'] = 'This field is required'; //
		$messages['vechile_propellant1.required_if'] = 'This field is required'; //

		$messages['vehicle_make1.required_if'] = 'This field is required';
		$messages['vehicle_model1.required_if'] = 'This field is required';
		$messages['engine_capacity1.required_if'] = 'This field is required';
		$messages['date_of_registration1.required_if'] = 'This field is required';
		$messages['year_of_manufacture1.required_if'] = 'This field is required';

		$messages['car_plate_no.required_if'] = 'This field is required';
		$messages['vehicle_make.required_if'] = 'This field is required';
		$messages['vehicle_model.required_if'] = 'This field is required';
		$messages['engine_capacity.required_if'] = 'This field is required';
		$messages['date_of_registration.required_if'] = 'This field is required';
		$messages['year_of_manufacture.required_if'] = 'This field is required';

		$messages['vehicle_schme.required_if'] = 'This field is required'; //
		$messages['vehicle_type.required_if'] = 'This field is required'; //
		$messages['vehicle_primary_color.required_if'] = 'This field is required'; //
		$messages['vehicle_engine_number.required_if'] = 'This field is required'; //
		$messages['vechile_chasis_number.required_if'] = 'This field is required'; //
		$messages['vechile_propellant.required_if'] = 'This field is required'; //


		$messages['type_of_quote.required'] = 'This field is required'; //
		$messages['ncd_percentage.required'] = 'This field is required'; //
		$messages['main_driver_nationality.required'] = 'This field is required'; //
		$messages['main_driver_address.required'] = 'This field is required'; //
		$messages['main_driver_employer.required'] = 'This field is required'; //
		$messages['main_driver_licence_class.required'] = 'This field is required'; //
		$messages['main_driver_licence_validity.required'] = 'This field is required'; //
		$messages['main_driver_merit_status.required'] = 'This field is required'; //
		
		if (!Session::get('myinfodetails')) {
            $request->validate([
			'main_driver_country_code' => 'required',
			'main_driver_address' => 'required',
			'main_driver_employer' => 'required',
			'main_driver_full_name' => 'required',
            'main_driver_nric' => 'required',
            'main_driver_date_of_birth' => 'required|date',
            'main_driver_gender' => 'required',
            'main_driver_marital_status' => 'required',
			'main_driver_nationality' => 'required',
            'main_driver_occupation' => 'required',
            'main_driver_contact_number' => 'required|numeric',
            'main_driver_email' => 'required|email',
            'main_driver_licence_class' => 'required',
            'main_driver_licence_validity' => 'required',
            'main_driver_merit_status' => 'required',
            'driver_full_name' => 'required_if:nameddriver,1',
            'driver_nric' => 'required_if:nameddriver,1',
            'driver_date_of_birth' => 'required_if:nameddriver,1',
            'driver_marital_status' => 'required_if:nameddriver,1',
            'driver_occupation' => 'required_if:nameddriver,1',
            'driver_license_class' => 'required_if:nameddriver,1',
            'driver_license_validity' => 'required_if:nameddriver,1',
            'driver_merit_status' => 'required_if:nameddriver,1',
			'driver_gender' => 'required_if:nameddriver,1', //
			'driver_nationality' => 'required_if:nameddriver,1', //
			'relationship_main_driver' => 'required_if:nameddriver,1', //
            'car_plate_no' => 'required_if:vehicle,2', //
            'vehicle_make' => 'required_if:vehicle,2', //
            'vehicle_model' => 'required_if:vehicle,2', //
            'engine_capacity' => 'required_if:vehicle,2', //
            'date_of_registration' => 'required_if:vehicle,2', //
            'year_of_manufacture' => 'required_if:vehicle,2', //
			'vehicle_schme' => 'required_if:vehicle,2', //
			'vehicle_type' => 'required_if:vehicle,2', //
			'vehicle_primary_color' => 'required_if:vehicle,2', //
			'vehicle_engine_number' => 'required_if:vehicle,2', //
			'vechile_chasis_number' => 'required_if:vehicle,2', //
			'vechile_propellant' => 'required_if:vehicle,2', //

			'car_plate_no1' => 'required_if:vehicle,1', //
            'vehicle_make1' => 'required_if:vehicle,1', //
            'vehicle_model1' => 'required_if:vehicle,1', //
            'engine_capacity1' => 'required_if:vehicle,1', //
            'date_of_registration1' => 'required_if:vehicle,1', //
            'year_of_manufacture1' => 'required_if:vehicle,1', //
			'vehicle_schme1' => 'required_if:vehicle,1', //
			'vehicle_type1' => 'required_if:vehicle,1', //
			'vehicle_primary_color1' => 'required_if:vehicle,1', //
			'vehicle_engine_number1' => 'required_if:vehicle,1', //
			'vechile_chasis_number1' => 'required_if:vehicle,1', //
			'vechile_propellant1' => 'required_if:vehicle,1', //
			'ncd_percentage' => 'required',
			'type_of_quote' => 'required',
			// 'previous_vehicle_no' => 'required',
            'terms_condition' => 'required',
    	    ], $messages);
        }else{
			$request->validate([
			'main_driver_country_code' => 'required',
			'main_driver_address' => 'required',
			'main_driver_employer' => 'required',
			'main_driver_full_name' => 'required',
            'main_driver_nric' => 'required',
            'main_driver_date_of_birth' => 'required|date',
            'main_driver_gender' => 'required',
            'main_driver_marital_status' => 'required',
			'main_driver_nationality' => 'required',
            'main_driver_occupation' => 'required',
            'main_driver_contact_number' => 'required|numeric',
            'main_driver_email' => 'required|email',
            'main_driver_licence_class' => 'required',
            'main_driver_licence_validity' => 'required',
            'main_driver_merit_status' => 'required',
            'driver_full_name' => 'required_if:nameddriver,1',
            'driver_nric' => 'required_if:nameddriver,1',
            'driver_date_of_birth' => 'required_if:nameddriver,1',
            'driver_marital_status' => 'required_if:nameddriver,1',
            'driver_occupation' => 'required_if:nameddriver,1',
            'driver_license_class' => 'required_if:nameddriver,1',
            'driver_license_validity' => 'required_if:nameddriver,1',
            'driver_merit_status' => 'required_if:nameddriver,1',
			'driver_gender' => 'required_if:nameddriver,1', //
			'driver_nationality' => 'required_if:nameddriver,1', //
			'relationship_main_driver' => 'required_if:nameddriver,1', //
			'car_plate_no1' => 'required_if:vehicle,1', //
            'vehicle_make1' => 'required_if:vehicle,1', //
            'vehicle_model1' => 'required_if:vehicle,1', //
            'engine_capacity1' => 'required_if:vehicle,1', //
            'date_of_registration1' => 'required_if:vehicle,1', //
            'year_of_manufacture1' => 'required_if:vehicle,1', //
			'vehicle_schme1' => 'required_if:vehicle,1', //
			'vehicle_type1' => 'required_if:vehicle,1', //
			'vehicle_primary_color1' => 'required_if:vehicle,1', //
			'vehicle_engine_number1' => 'required_if:vehicle,1', //
			'vechile_chasis_number1' => 'required_if:vehicle,1', //
			'vechile_propellant1' => 'required_if:vehicle,1', //
			'ncd_percentage' => 'required',
			'type_of_quote' => 'required',
			// 'previous_vehicle_no' => 'required',
			// 'car_plate_no1' => 'required',
            'terms_condition' => 'required',
        	], $messages);
		}

// 		if (!Session::get('myinfodetails')) {
//             $request->validate([
// 			'main_driver_country_code' => 'required',
// 			'main_driver_address' => 'required',
// 			'main_driver_employer' => 'required',
// 			'main_driver_full_name' => 'required',
//             'main_driver_nric' => 'required',
//             'main_driver_date_of_birth' => 'required|date',
//             'main_driver_gender' => 'required',
//             'main_driver_marital_status' => 'required',
//             'main_driver_nationality' => 'required',
//             'main_driver_occupation' => 'required',
//             'main_driver_contact_number' => 'required|numeric',
//             'main_driver_email' => 'required|email',
//             'main_driver_licence_class' => 'required',
//             'main_driver_licence_validity' => 'required',
//             'main_driver_merit_status' => 'required',
//             'driver_full_name' => 'required_if:nameddriver,1',
//             'driver_nric' => 'required_if:nameddriver,1',
//             'driver_date_of_birth' => 'required_if:nameddriver,1',
//             'driver_marital_status' => 'required_if:nameddriver,1',
//             'driver_occupation' => 'required_if:nameddriver,1',
//             'driver_license_class' => 'required_if:nameddriver,1',
//             'driver_license_validity' => 'required_if:nameddriver,1',
//             'driver_merit_status' => 'required_if:nameddriver,1',
//             'car_plate_no' => 'required',
//             'vehicle_make' => 'required',
//             'vehicle_model' => 'required',
//             'engine_capacity' => 'required',
//             'date_of_registration' => 'required',
//             'year_of_manufacture' => 'required',
// 			'vehicle_schme' => 'required',
// 			'vehicle_type' => 'required',
// 			'vehicle_primary_color' => 'required',
// 			'vehicle_engine_number' => 'required',
// 			'vechile_chasis_number' => 'required',
// 			'vechile_propellant' => 'required',
//             'terms_condition' => 'required',
//         	], $messages);
//         }else{
// 			$request->validate([
//             'main_driver_full_name' => 'required',
//             'main_driver_nric' => 'required',
//             'main_driver_marital_status' => 'required',
//             'main_driver_contact_number' => 'required|numeric',
//             'main_driver_email' => 'required|email',
//             'main_driver_occupation' => 'required',
// 			'main_driver_employer' => 'required',
//             'driver_full_name' => 'required_if:nameddriver,1',
//             'driver_nric' => 'required_if:nameddriver,1',
//             'driver_date_of_birth' => 'required_if:nameddriver,1',
//             'driver_marital_status' => 'required_if:nameddriver,1',
//             'driver_occupation' => 'required_if:nameddriver,1',
//             'driver_license_class' => 'required_if:nameddriver,1',
//             'driver_license_validity' => 'required_if:nameddriver,1',
//             'driver_merit_status' => 'required_if:nameddriver,1',
// // 			'car_plate_no1' => 'required',
//             'terms_condition' => 'required',
//         	], $messages);
// 		}

	
		
		
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

        if(!empty($request->main_driver_date_of_birth)){
			$main_driver_date_of_birth = date('Y-m-d', strtotime($request->main_driver_date_of_birth));
		}else{
			$main_driver_date_of_birth = null;
		}

		if(!empty($request->driver_date_of_birth)){
			$driver_date_of_birth = date('Y-m-d', strtotime($request->driver_date_of_birth));
		}else{
			$driver_date_of_birth = null;
		}

		if(!empty($request->date_of_registration)){
			$date_of_registration = date('Y-m-d', strtotime($request->date_of_registration));
		}elseif(!empty($request->date_of_registration1)){
			$date_of_registration = date('Y-m-d', strtotime($request->date_of_registration1));
		}else{
			$date_of_registration = null;
		}
		//$insurance->discount = systemSetting()->insurance_discount;
		$insurance->main_driver_full_name = isset($request->main_driver_full_name) ? $request->main_driver_full_name : NULL;
		$insurance->main_driver_nric = isset($request->main_driver_nric) ? $request->main_driver_nric : NULL;
		$insurance->main_driver_date_of_birth = $main_driver_date_of_birth;
		$insurance->main_driver_license_pass_date = isset($request->main_driver_license_pass_date) ? $request->main_driver_license_pass_date : NULL;
		$insurance->main_driver_gender = isset($request->main_driver_gender) ? $request->main_driver_gender : NULL;
		$insurance->main_driver_marital_status = isset($request->main_driver_marital_status) ? $request->main_driver_marital_status : NULL;
		$insurance->main_driver_occupation = isset($request->main_driver_occupation) ? $request->main_driver_occupation : NULL;
		$insurance->main_driver_country_code = isset($request->main_driver_country_code) ? $request->main_driver_country_code : NULL;
		$insurance->main_driver_contact_number = isset($request->main_driver_contact_number) ? $request->main_driver_contact_number : NULL;
		$insurance->main_driver_email = isset($request->main_driver_email) ? $request->main_driver_email : NULL;
		$insurance->main_driver_passport = isset($request->main_driver_passport) ? $request->main_driver_passport : NULL;
		$insurance->main_driver_nationality = isset($request->main_driver_nationality) ? $request->main_driver_nationality : NULL;
		$insurance->main_driver_address = isset($request->main_driver_address) ? $request->main_driver_address : NULL; // New Field
		$insurance->main_driver_employer = isset($request->main_driver_employer) ? $request->main_driver_employer : NULL; // New Field
		$insurance->main_driver_licence_class = isset($request->main_driver_licence_class) ? $request->main_driver_licence_class : NULL; // New Field
		$insurance->main_driver_licence_validity = isset($request->main_driver_licence_validity) ? $request->main_driver_licence_validity : NULL; // New Field
		$insurance->main_driver_merit_status = isset($request->main_driver_merit_status) ? $request->main_driver_merit_status : NULL; // New Field
		
		
		
		

		$insurance->named_driver = isset($request->nameddriver) ? $request->nameddriver : NULL;
		$insurance->driver_full_name = isset($request->driver_full_name) ? $request->driver_full_name : NULL;
		$insurance->driver_nric = isset($request->driver_nric) ? $request->driver_nric : NULL;
		$insurance->driver_date_of_birth = $driver_date_of_birth;
		$insurance->driver_license_pass_date = isset($request->driver_license_pass_date) ? $request->driver_license_pass_date : NULL;
		$insurance->driver_gender = isset($request->driver_gender) ? $request->driver_gender : NULL;
		$insurance->driver_marital_status = isset($request->driver_marital_status) ? $request->driver_marital_status : NULL;
		$insurance->driver_occupation = isset($request->driver_occupation) ? $request->driver_occupation : NULL;
		$insurance->relationship_main_driver = isset($request->relationship_main_driver) ? $request->relationship_main_driver : NULL;
		$insurance->driver_passport = isset($request->driver_passport) ? $request->driver_passport : NULL;
		$insurance->driver_nationality = isset($request->driver_nationality) ? $request->driver_nationality : NULL;
		$insurance->driver_license_class = isset($request->driver_license_class) ? $request->driver_license_class : NULL; // New field
		$insurance->driver_license_validity = isset($request->driver_license_validity) ? $request->driver_license_validity : NULL; // New field
		$insurance->driver_merit_status = isset($request->driver_merit_status) ? $request->driver_merit_status : NULL; // New field
		
		
		


		$insurance->terms_condition = isset($request->terms_condition) ? $request->terms_condition : NULL;
		$insurance->status = 2;
		$insurance->ncd_percentage = isset($request->ncd_percentage) ? $request->ncd_percentage : NULL;
		$insurance->previous_vehicle_no = isset($request->previous_vehicle_no) ? $request->previous_vehicle_no : NULL;

		// new filed
		$insurance->document1 = isset($imageNameArr[0]) ? $imageNameArr[0] : NULL;
		$insurance->document2 = isset($imageNameArr[1]) ? $imageNameArr[1] : NULL;
		// $insurance->driver_uen = isset($request->driver_uen) ? $request->driver_uen : NULL;
		
		// $insurance->main_driver_uen = isset($request->main_driver_uen) ? $request->main_driver_uen : NULL;
				
		$insurance->save();
		
		if($request->vehicle == 1){
			$car_plate_no = $request->car_plate_no1 ?? null;
			$vehicle_schme = $request->vehicle_schme1 ?? null; // New field
			$vehicle_type = $request->vehicle_type1 ?? null; // New field
			$vehicle_primary_color = $request->vehicle_primary_color1 ?? null; // New field
			$vehicle_engine_number = $request->vehicle_engine_number1 ?? null; // New field
			$vechile_chasis_number = $request->vechile_chasis_number1 ?? null; // New field
			$vechile_propellant = $request->vechile_propellant1 ?? null; // New field
			$make_model = $request->vehicle_make1 . ' '. $request->vehicle_model1 ?? null;
			$engine_capacity = str_replace(',','',$request->engine_capacity1) ?? null;
			$date_of_registration = $date_of_registration;
			$year_of_manufacture = $request->year_of_manufacture1 ?? null;
		}else{
			$car_plate_no = $request->car_plate_no ?? null;
			$vehicle_schme = $request->vehicle_schme ?? null; // New field
			$vehicle_type = $request->vehicle_type ?? null; // New field
			$vehicle_primary_color = $request->vehicle_primary_color ?? null; // New field
			$vehicle_engine_number = $request->vehicle_engine_number ?? null; // New field
			$vechile_chasis_number = $request->vechile_chasis_number ?? null; // New field
			$vechile_propellant = $request->vechile_propellant ?? null; // New field
			$make_model = $request->vehicle_make . ' '. $request->vehicle_model ?? null;
			$engine_capacity = str_replace(',','',$request->engine_capacity) ?? null;
			$date_of_registration = $date_of_registration;
			$year_of_manufacture = $request->year_of_manufacture ?? null;
		}

		if ($insurance->id) {

			$insuranceInformation = new InsuranceInformation();
			$insuranceInformation->insurance_id = $insurance->id;
			$insuranceInformation->car_plate_no = isset($car_plate_no) ? $car_plate_no : NULL;
			// $insuranceInformation->nric_uen_business_passport = isset($request->nric_uen_business_passport) ? $request->nric_uen_business_passport : NULL;
			$insuranceInformation->type_of_quote = isset($request->type_of_quote) ? $request->type_of_quote : NULL;
			$insuranceInformation->ncd = isset($request->ncd_percentage) ? $request->ncd_percentage : NULL;
			$insuranceInformation->previous_vehicle_number = isset($request->previous_vehicle_no) ? $request->previous_vehicle_no : NULL;
			$insuranceInformation->terms_condition = isset($request->terms_condition) ? $request->terms_condition : NULL;
			$insuranceInformation->save();

			$insuranceVehicle = new InsuranceVehicle();
			$insuranceVehicle->insurance_id = $insurance->id;
			//$insuranceVehicle->vehicle_details = isset($request->vehicle_details)?$request->vehicle_details:NULL;
			$insuranceVehicle->vehicles_car_plate_no = isset($car_plate_no) ? $car_plate_no : NULL;
			$insuranceVehicle->make_model = $make_model ?? null;
			$insuranceVehicle->vehicle_schme = $vehicle_schme ?? null; // New field
			$insuranceVehicle->vehicle_type = $vehicle_type ?? null; // New field
			$insuranceVehicle->vehicle_primary_color = $vehicle_primary_color ?? null; // New field
			$insuranceVehicle->vehicle_engine_number = $vehicle_engine_number ?? null; // New field
			$insuranceVehicle->vechile_chasis_number = $vechile_chasis_number ?? null; // New field
			$insuranceVehicle->vechile_propellant = $vechile_propellant ?? null; // New field
			$insuranceVehicle->engine_capacity = isset($engine_capacity) ? $engine_capacity : NULL;
			$insuranceVehicle->date_of_registration = isset($date_of_registration) ? $date_of_registration : NULL;
			$insuranceVehicle->year_of_manufacture = isset($year_of_manufacture) ? $year_of_manufacture : NULL;
			$insuranceVehicle->is_opc_car = isset($request->is_opc_car) ? $request->is_opc_car : NULL;
			$insuranceVehicle->save();
		}
		
	    $pdf = PDF::loadView('pdf.newinsurance', compact("insurance"))->setPaper('a4', 'potrait');
		$path = public_path('insurance_form');
		$fileName =  rand().'-pdfview' . '.' . 'pdf' ;
		$pdf->save($path . '/' . $fileName);
		$insuranceIdd = $insurance->id;
		$insuranceee = Insurance::where('id', $insuranceIdd)->first();
		$insuranceee->insuracne_new_pdf = $fileName;
		$insuranceee->save();

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

			$key1 = ['{{customer}}'];
			$value1 = [$request->main_driver_full_name];
			$data['subject'] = str_replace($key1, $value1, $email_template->subject);
			// $data['subject'] = $email_template->subject;


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

// 		return redirect()->back()->with('success',   __('constant.INSURANCE_APPLICATION_SUBMITTED'));
return redirect('insurance-form-thank-you')->with('success', 'Insurance Application has been submitted.');
	}
}
