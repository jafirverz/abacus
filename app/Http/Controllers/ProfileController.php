<?php

namespace App\Http\Controllers;

use App\Insurance;
use App\Notification;
use App\InsuranceInformation;
use App\InsuranceQuotation;
use App\InsuranceVehicle;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use App\User;
use App\Admin;
use App\Chat;
use App\ChatMessage;
use App\UserProfileUpdate;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Traits\PageTrait;
use Illuminate\Support\Str;
use App\Jobs\SendEmail;
use App\Exports\NotifyListExport;
use App\Exports\EnquiryExport;
use App\Exports\TransactionExport;
use App\VehicleMain;
use App\VehicleDetail;
use Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use PDFMerger;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf as PDF;
use App\LikeCount;
use App\ReportVehicle;
use App\QuoteRequest;
use App\MessageTemplate;
use App\SellerParticular;
use App\Invoice;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
	use GetEmailTemplate, SystemSettingTrait, PageTrait;

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
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
		//dd($user);
		$page = get_page_by_slug($slug);
        $instructors = User::where('role_id', 7)->get();

		if (!$page) {
			return abort(404);
		}

		//dd($user);

		return view('account.my-profile', compact("page", "user", "instructors"));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
//        dd($request->all());
        $users = User::find($this->user->id);
        if($request->updateimage == 1 && $request->updateprofile == 0){
            if ($request->hasFile('profile_picture')) {

                $profile_picture = $request->file('profile_picture');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $profile_picture->getClientOriginalName();

                $filepath = 'storage/profile/';

                Storage::putFileAs(

                    'public/profile',
                    $profile_picture,
                    $filename

                );

                $path_profile_picture = $filepath . $filename;

                $users->profile_picture = $path_profile_picture;
            }
            $users->updated_at = Carbon::now();
            $users->save();
        }elseif($request->updateimage == 1 && $request->updateprofile == 1){
            $messages = [
                'country_code.regex' => 'The Country code entered is invalid.',
            ];
            if($request->updateprofile == 1){
                $request->validate([
                    'name' => 'required',
                    'email' => 'required|unique:users,email,'.$users->id,
                    'dob' => 'required',
                    'country_code_phone' => 'required',
                    'mobile' => 'required',
                    'gender' => 'required',
                    'instructor' => 'required',
                    'country_code' => 'required',
//                'password'  =>  'nullable|min:8',
//			'country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',


                ], $messages); //dd($request);
            }
            $dob = date('Y-m-d', strtotime($request->dob));
            $updateUserProfile = new UserProfileUpdate();
            $updateUserProfile->user_id  = $users->id;
            $updateUserProfile->name = $request->name;
            $updateUserProfile->email = $request->email;
            //$users->email = $request->email;
            if ($request->password != '') {
                //dd($request->password);
                $updateUserProfile->password = Hash::make($request->password);
            }
            $updateUserProfile->address = $request->address ?? NULL;
            $updateUserProfile->country_code = $request->country_code;
            $updateUserProfile->country_code_phone = $request->country_code_phone;
            $updateUserProfile->dob = $dob;
            $updateUserProfile->instructor_id  = $request->instructor;
            $updateUserProfile->mobile = $request->mobile;
            $updateUserProfile->gender = $request->gender;

            //Image upload..

            if ($request->hasFile('profile_picture')) {

                $profile_picture = $request->file('profile_picture');

                $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $profile_picture->getClientOriginalName();

                $filepath = 'storage/profile/';

                Storage::putFileAs(

                    'public/profile',
                    $profile_picture,
                    $filename

                );

                $path_profile_picture = $filepath . $filename;

                $updateUserProfile->profile_picture = $path_profile_picture;
            }
            $updateUserProfile->updated_at = Carbon::now();
            $updateUserProfile->save();
        }



		return redirect()->back()->with('success', __('constant.ACOUNT_UPDATED'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
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
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy()
	{
		// dd($this->user->id);
		$user = User::find($this->user->id);

		$user->status = 2;

		$user->save();
		// EMAIL TO USER

		$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_DELETE_USER_ACCOUNT'));

		if ($email_template) {

			$data = [];

			$data['email_sender_name'] = $this->systemSetting()->email_sender_name;

			$data['from_email'] = $this->systemSetting()->from_email;

			$data['cc_to_email'] = [];

			$data['subject'] = $email_template->subject;

			$key = ['{{full_name}}'];

			$value = [$user->first_name];

			$newContent = str_replace($key, $value, $email_template->content);

			$data['contents'] = $newContent;

			try {

				$mail = Mail::to($user->email)->send(new EmailNotification($data));
			} catch (Exception $exception) {

				dd($exception);
			}
		}
		Auth::logout();

		return redirect('login')->with('success', 'Your account deleted successfully.');
	}

	public function my_cars($slug = 'advertise-my-car')
	{
		$users = $this->user;
		$page = $this->getPages($slug);

		//dd($page);
		if (!$page) {
			return abort(404);
		}

		$all_pages = $this->getAllPages();
		$menu = $this->getMenu();
		$my_cars = VehicleMain::join('vehicle_details', 'vehicle_details.vehicle_id', 'vehicle_mains.id')
					->where('vehicle_mains.seller_id', $this->user->id)
					->where('vehicle_mains.status','!=',0)
					->select('vehicle_details.*', 'vehicle_mains.status as status')
					->paginate($this->pagination);
		//dd($my_cars);
		return view('account.my-car', compact("page", "all_pages", "menu", 'my_cars'));
	}

	public function my_quote_requests($slug = 'advertise-my-car'){
		$users = $this->user;
		$page = $this->getPages($slug);

		//dd($page);
		if (!$page) {
			return abort(404);
		}

		$all_pages = $this->getAllPages();
		$menu = $this->getMenu();

		$my_quote_requests = QuoteRequest::where('seller_id', $this->user->id)
								->orderBy('created_at', 'desc')
                            	->paginate($this->pagination);

		return view('account.my-quote-request', compact("page", "all_pages", "menu", 'my_quote_requests'));
	}

	public function my_invoices($slug = 'advertise-my-car'){
		$users = $this->user;
		$page = $this->getPages($slug);

		//dd($page);
		if (!$page) {
			return abort(404);
		}

		$all_pages = $this->getAllPages();
		$menu = $this->getMenu();

		$my_invoices = Invoice::where('seller_id', $this->user->id)->orWhere('buyer_id', $this->user->id)
								->orderBy('created_at', 'desc')
                            	->paginate($this->pagination);

		return view('account.my-invoice', compact("page", "all_pages", "menu", 'my_invoices'));
	}

	public function view_invoice($id, $slug = 'invoice'){
		$users = $this->user;
		$page = $this->getPages($slug);

		//dd($page);
		if (!$page) {
			return abort(404);
		}

		$all_pages = $this->getAllPages();
		$menu = $this->getMenu();

		$invoice = Invoice::with('items')->where('id', '=', $id)->get();

		return view('account.view-invoice', compact("page", "all_pages", "menu", 'invoice'));
	}

	public function advertise_my_car_form($slug = 'advertise-my-car')
	{
		$users = $this->user;
		$page = $this->getPages($slug);

		//dd($page);

		if (!$page) {
			return abort(404);
		}

		$all_pages = $this->getAllPages();

		$menu = $this->getMenu();

		return view('account.advertise-my-car-form', compact("page", "all_pages", "menu", 'users'));
	}

	public function quote_my_car_form($slug = 'quote-my-car')
	{
		$users = $this->user;
		$page = $this->getPages($slug);

		//dd($page);

		if (!$page) {
			return abort(404);
		}

		$all_pages = $this->getAllPages();

		$menu = $this->getMenu();

		return view('account.quote-my-car-form', compact("page", "all_pages", "menu", 'users'));
	}

	public function advertise_my_car_store(Request $request)
	{
		$system_settings = $this->system_settings;
		// Get verify response data
		// $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $system_settings->recaptcha_secret_key . '&response=' . $request->captcha_response);
		// $responseData = json_decode($verifyResponse);
		$messages = [];
// 		$messages['nric.required'] = 'The NRIC field is required.';
        $messages['full_name.required'] = 'This field is required';
		$messages['nric.required'] = 'This field is required';
		$messages['gender.required'] = 'This field is required';
		$messages['country.required'] = 'This field is required';
		$messages['contact_number.required'] = 'This field is required';
		$messages['email.required'] = 'This field is required';
		$messages['vehicle_number.required'] = 'This field is required';
		$messages['mileage.required'] = 'This field is required';
		$messages['price.required'] = 'This field is required';
		$messages['terms_condition.required'] = 'This field is required';
		$messages['vehicle_make.required'] = 'This field is required';
		$messages['vehicle_model.required'] = 'This field is required';
		$messages['primary_color.required'] = 'This field is required';
		$messages['year_of_manufacture.required'] = 'This field is required';
		$messages['open_market_value.required'] = 'This field is required';
		$messages['orig_reg_date.required'] = 'This field is required';
		$messages['first_reg_date.required'] = 'This field is required';
		$messages['no_of_transfer.required'] = 'This field is required';
		$messages['minimumparfbenefit.required'] = 'This field is required';
		$messages['coe_expiry_date.required'] = 'This field is required';
		$messages['coe_category.required'] = 'This field is required';
		$messages['quota_premium.required'] = 'This field is required';
		$messages['vehicle_type.required'] = 'This field is required';
		$messages['propellant.required'] = 'This field is required';
		$messages['power_rate.required'] = 'This field is required';
		$messages['vehicle_emission_rate.required'] = 'This field is required';
		$messages['max_weight.required'] = 'This field is required';
		$messages['vehicle_scheme.required'] = 'This field is required';
		$messages['engine_capacity.required'] = 'This field is required';
		$messages['roadtaxexpirydate.required'] = 'This field is required';
		$messages['mileage.required'] = 'This field is required';
		$messages['price.required'] = 'This field is required';

		if (!Session::get('myinfoadvertisecar')) {
            $request->validate([
            'full_name' => 'required',
			'nric' => 'required',
			'gender' => 'required',
			'country' => 'required',
			'contact_number' => 'required|numeric',
			'email' => 'required',
            'vehicle_number' => 'required',
			'mileage' => 'required',
            'price' => 'required',
            // 'specification' => 'required|array|min:1',
            'terms_condition' => 'required',
			// 'additional_accessories' => 'required|array|min:1',
			// 'open_market_value' => 'required',
			// 'no_of_transfer' => 'required',
			// 'minimumparfbenefit' => 'required',
			// 'coe_expiry_date' => 'required',
			// 'coe_category' => 'required',
			// 'quota_premium' => 'required',
			// 'vehicle_type' => 'required',
			// 'propellant' => 'required',
			// 'power_rate' => 'required',
			// 'vehicle_emission_rate' => 'required',
			// 'max_weight' => 'required',
			// 'vehicle_scheme' => 'required',
			// 'roadtaxexpirydate' => 'required',


            // 'upload_file' => 'required',

            // 'vehicle_make' => 'required',
            // 'vehicle_model' => 'required',
            // 'primary_color' => 'required',
            // 'year_of_manufacture' => 'required',
            // 'orig_reg_date' => 'required',
            // 'engine_capacity' => 'required',
        	], $messages);
        }else{
		    $request->validate([
			'full_name' => 'required',
			'nric' => 'required',
			'gender' => 'required',
			'country' => 'required',
			'contact_number' => 'required|numeric',
			'email' => 'required',
            'vehicle_number' => 'required',
			'vehicle_make' => 'required',
            'vehicle_model' => 'required',
			'primary_color' => 'required',
			'year_of_manufacture' => 'required',
			'open_market_value' => 'required',
			'orig_reg_date' => 'required',
			'first_reg_date' => 'required',
			'no_of_transfer' => 'required',
			'minimumparfbenefit' => 'required',
			'coe_expiry_date' => 'required',
			'coe_category' => 'required',
			'quota_premium' => 'required',
			'vehicle_type' => 'required',
			'propellant' => 'required',
			'power_rate' => 'required',
			'vehicle_emission_rate' => 'required',
			'max_weight' => 'required',
			'vehicle_scheme' => 'required',
			'engine_capacity' => 'required',
			'roadtaxexpirydate' => 'required',
			'mileage' => 'required',
			'price' => 'required',
			// 'specification' => 'required|array|min:1',
            'terms_condition' => 'required',

        	], $messages);
		}

// 		if (!Session::get('myinfoadvertisecar')) {
//             $request->validate([
//             'full_name' => 'required',
// 			'gender' => 'required',
// // 			'open_market_value' => 'required',
// // 			'no_of_transfer' => 'required',
// // 			'minimumparfbenefit' => 'required',
// // 			'coe_expiry_date' => 'required',
// // 			'coe_category' => 'required',
// // 			'quota_premium' => 'required',
// // 			'vehicle_type' => 'required',
// // 			'propellant' => 'required',
// // 			'power_rate' => 'required',
// // 			'vehicle_emission_rate' => 'required',
// // 			'max_weight' => 'required',
// // 			'vehicle_scheme' => 'required',
// // 			'roadtaxexpirydate' => 'required',
//             'country' => 'required',
//             'contact_number' => 'required|numeric',
//             'email' => 'required',
//             'vehicle_number' => 'required',
//             'nric' => 'required',
//             'price' => 'required',
//             'mileage' => 'required',
//             'specification' => 'required|array|min:1',
//             'additional_accessories' => 'required|array|min:1',
//             // 'upload_file' => 'required',
//             'terms_condition' => 'required',
//             // 'vehicle_make' => 'required',
//             // 'vehicle_model' => 'required',
//             // 'primary_color' => 'required',
//             // 'year_of_manufacture' => 'required',
//             // 'orig_reg_date' => 'required',
//             // 'engine_capacity' => 'required',
//         	], $messages);
//         }else{
// 			$request->validate([
//             'contact_number' => 'required|numeric',
//             'email' => 'required',
//             'price' => 'required',
//             'specification.*' => 'required',
//             'additional_accessories.*' => 'required',
//             'upload_file' => 'required',
//             'terms_condition' => 'required',

//         	], $messages);
// 		}

		// if (!$responseData->success) {
		// 	return redirect()->back()->withInput()->with('error', __('constant.CAPTCHA_ERROR'));
		// }
		//dd($request->all());
		$vehicleMain = new VehicleMain();
		$vehicleMain->seller_id = Auth::user()->id;
		$vehicleMain->full_name = $request->full_name;
		$vehicleMain->email = $request->email;
		$vehicleMain->country = $request->country;
		$vehicleMain->gender = $request->gender; // New
		$vehicleMain->contact_number = $request->contact_number;
		$vehicleMain->specification = json_encode($request->specification);
		$vehicleMain->additional_accessories = json_encode($request->additional_accessories);
		$vehicleMain->seller_comment = $request->seller_comment;
        $vehicleMain->status = 1;
		$vehicleMain->save();

		$VehicleDetail = new VehicleDetail();
		$VehicleDetail->vehicle_id  = $vehicleMain->id;
		$files = [];
		if ($request->hasfile('upload_file')) {
			foreach ($request->file('upload_file') as $file) {
				$filename = time() . rand(1, 50) . '.' . $file->extension();
				$filepath = 'storage/upload-file/';
				Storage::putFileAs(
					'public/upload-file',
					$file,
					$filename
				);
				$files[] = $filepath . $filename;
			}
		}
        $VehicleDetail->vehicle_number  = $request->vehicle_number;
        $VehicleDetail->coe_expiry_date  = date('Y-m-d', strtotime($request->coe_expiry_date));
		$VehicleDetail->year_of_mfg  = $request->year_of_manufacture;
		$VehicleDetail->first_reg_date  = date('Y-m-d', strtotime($request->first_reg_date));
		$VehicleDetail->vehicle_type  = $request->vehicle_type;
		$VehicleDetail->vehicle_make  = $request->vehicle_make;
		$VehicleDetail->vehicle_model  = $request->vehicle_model;
		$VehicleDetail->primary_color  = $request->primary_color;
		$VehicleDetail->open_market_value  = str_replace(',','',$request->open_market_value);
		$VehicleDetail->orig_reg_date  = date('Y-m-d', strtotime($request->orig_reg_date));
		$VehicleDetail->no_of_transfers  = $request->no_of_transfer;
		$VehicleDetail->min_parf_benefit  = str_replace(',','',$request->minimumparfbenefit);
		$VehicleDetail->coe_category  = $request->coe_category;
		$VehicleDetail->quota_premium  = str_replace(',','',$request->quota_premium);
		$VehicleDetail->propellant  = $request->propellant;
		$VehicleDetail->power_rate  = $request->power_rate;
		$VehicleDetail->co2_emission_rate  = $request->vehicle_emission_rate;
		$VehicleDetail->max_unladden_weight  = str_replace(',','',$request->max_weight);
		$VehicleDetail->vehicle_scheme  = $request->vehicle_scheme;
		$VehicleDetail->engine_cc  = $request->engine_capacity;
		$VehicleDetail->road_tax_expiry_date  = date('Y-m-d', strtotime($request->roadtaxexpirydate));
        $VehicleDetail->nric  = $request->nric;
        $VehicleDetail->price  = str_replace(',','',$request->price);
		$VehicleDetail->mileage  = str_replace(',','',$request->mileage);
		$VehicleDetail->upload_file  = json_encode($files);
		$VehicleDetail->save();

        $message = $request->full_name . ' added a new car.';
        $notification = new Notification();
        $notification->insurance_id = NULL;
        $notification->quotaton_id = NULL;
        $notification->partner_id = Auth::user()->id;
        $notification->message = $message;
        $notification->link = 'https://www.diycars.com/admin/marketplace/'.$vehicleMain->id.'/edit';
        $notification->status = 1;
        $notification->save();

        // EMAIL TO Admin
		$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_ADVERTISE_CAR_TO_ADMIN'));
		//dd($email_template);
		if ($email_template) {
			$data = [];

			$data['email_sender_name'] =  $this->systemSetting()->email_sender_name;
			// $data['from_email'] = $this->systemSetting()->from_email;
			$data['from_email'] = $this->systemSetting()->from_email;
			$data['cc_to_email'] = [];
			$data['subject'] = $email_template->subject;
			//dd($partners);

				$url = url('admin/marketplace/' . $VehicleDetail->id . '/edit');
				$link = '<a href="' . $url . '">' . $url . '</a>';

				$data['email'] = [$this->systemSetting()->to_email];

				$key = ['{{url}}'];
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

		return redirect('thank-you')->with('success', 'Your car added successfully.');
	}

	public function quote_my_car_store(Request $request)
	{
	   // dd("test");
		$system_settings = $this->system_settings;
		$messages = [];
// 		$messages['full_name.required'] = 'The name field is required.';
// 		$messages['nric.required'] = 'The NRIC field is required.';

        $messages['full_name.required'] = 'This field is required';
		$messages['nric.required'] = 'This field is required';
		$messages['country.required'] = 'This field is required';
		$messages['contact_number.required'] = 'This field is required';
		$messages['email.required'] = 'This field is required';
		$messages['gender.required'] = 'This field is required';
		$messages['vehicle_number.required'] = 'This field is required';
		$messages['mileage.required'] = 'This field is required';
		$messages['handing_over_date.required'] = 'This field is required';
		$messages['terms_condition.required'] = 'This field is required';

		$messages['vehicle_make.required'] = 'This field is required';
		$messages['vehicle_model.required'] = 'This field is required';
		$messages['primary_color.required'] = 'This field is required';
		$messages['year_of_manufacture.required'] = 'This field is required';
		$messages['open_market_value.required'] = 'This field is required';
		$messages['orig_reg_date.required'] = 'This field is required';
		$messages['first_reg_date.required'] = 'This field is required';
		$messages['no_of_transfer.required'] = 'This field is required';
		$messages['minimumparfbenefit.required'] = 'This field is required';
		$messages['coe_expiry_date.required'] = 'This field is required';
		$messages['coe_category.required'] = 'This field is required';
		$messages['quota_premium.required'] = 'This field is required';
		$messages['vehicle_type.required'] = 'This field is required';
		$messages['propellant.required'] = 'This field is required';
		$messages['engine_capacity.required'] = 'This field is required';
		$messages['engine_no.required'] = 'This field is required';
		$messages['chassis_no.required'] = 'This field is required';
		$messages['max_unladen_weight.required'] = 'This field is required';
		$messages['vehicle_scheme.required'] = 'This field is required';
		$messages['roadtaxexpirydate.required'] = 'This field is required';

		if (!Session::get('myinfoquotemycar')) {
            $request->validate([
            'full_name' => 'required',
			'nric' => 'required',
            'country' => 'required',
            'contact_number' => 'required|numeric',
            'email' => 'required',
			'gender' => 'required',
            'vehicle_number' => 'required',
            'mileage' => 'required',
			'handing_over_date' => 'required|date',
			'terms_condition' => 'required',
			// 'open_market_value' => 'required',
			// 'orig_reg_date' => 'required',
			// 'first_reg_date' => 'required',
			// 'no_of_transfer' => 'required',
			// 'minimumparfbenefit' => 'required',
			// 'coe_expiry_date' => 'required',
			// 'coe_category' => 'required',
			// 'quota_premium' => 'required',
			// 'vehicle_type' => 'required',
			// 'propellant' => 'required',
			// 'chassis_no' => 'required',
			// 'max_unladen_weight' => 'required',
			// 'vehicle_scheme' => 'required',
			// 'roadtaxexpirydate' => 'required',


            // 'upload_file' => 'required',

            // 'vehicle_make' => 'required',
            // 'vehicle_model' => 'required',
            // 'primary_color' => 'required',
            // 'year_of_manufacture' => 'required',
            // 'engine_capacity' => 'required',
            // 'engine_no' => 'required',
        	], $messages);
        }else{
			$request->validate([
            'full_name' => 'required',
			'nric' => 'required',
            'contact_number' => 'required|numeric',
            'email' => 'required',
			'vehicle_number' => 'required',
			'gender' => 'required',
			'vehicle_make' => 'required',
			'vehicle_model' => 'required',
			'primary_color' => 'required',
			'year_of_manufacture' => 'required',
			'open_market_value' => 'required',
			'orig_reg_date' => 'required',
			'first_reg_date' => 'required',
			'no_of_transfer' => 'required',
			'minimumparfbenefit' => 'required',
			'coe_expiry_date' => 'required',
			'coe_category' => 'required',
			'quota_premium' => 'required',
			'vehicle_type' => 'required',
			'propellant' => 'required',
			'engine_capacity' => 'required',
			'engine_no' => 'required',
			'chassis_no' => 'required',
			'max_unladen_weight' => 'required',
			'vehicle_scheme' => 'required',
			'roadtaxexpirydate' => 'required',
			'mileage' => 'required',
            'handing_over_date' => 'required|date',
            'terms_condition' => 'required',

        	], $messages);
		}

// 		if (!Session::get('myinfoquotemycar')) {
//             $request->validate([
//             'full_name' => 'required',
//             'country' => 'required',
//             'contact_number' => 'required|numeric',
//             'email' => 'required',
//             'vehicle_number' => 'required',
//             'nric' => 'required',
// 			'gender' => 'required',
// // 			'open_market_value' => 'required',
// // 			'orig_reg_date' => 'required',
// // 			'first_reg_date' => 'required',
// // 			'no_of_transfer' => 'required',
// // 			'minimumparfbenefit' => 'required',
// // 			'coe_expiry_date' => 'required',
// // 			'coe_category' => 'required',
// // 			'quota_premium' => 'required',
// // 			'vehicle_type' => 'required',
// // 			'propellant' => 'required',
// // 			'chassis_no' => 'required',
// // 			'max_unladen_weight' => 'required',
// // 			'vehicle_scheme' => 'required',
// // 			'roadtaxexpirydate' => 'required',
// 			'mileage' => 'required',
//             'handing_over_date' => 'required|date',
//             // 'upload_file' => 'required',
//             'terms_condition' => 'required',
//             // 'vehicle_make' => 'required',
//             // 'vehicle_model' => 'required',
//             // 'primary_color' => 'required',
//             // 'year_of_manufacture' => 'required',
//             // 'engine_capacity' => 'required',
//             // 'engine_no' => 'required',
//         	], $messages);
//         }else{
// 			$request->validate([
//             'full_name' => 'required',
//             'contact_number' => 'required|numeric',
//             'email' => 'required',
//             'nric' => 'required',
//             'mileage' => 'required',
//             'handing_over_date' => 'required|date',
//             'terms_condition' => 'required',

//         	], $messages);
// 		}

		//dd($request->all());
		if($request->gender == 'MALE' || $request->gender == 'Male'){
			$gender = 1;
		}elseif($request->gender == 'FEMALE' || $request->gender == 'Female'){
			$gender = 2;
		}else{
			$gender = $request->gender ?? 0;
		}
		$quote_request = new QuoteRequest;
        $quote_request->seller_id = $this->user->id;
        $quote_request->full_name = $request->full_name;
        $quote_request->email = $request->email;
        $quote_request->country = $request->country;
        $quote_request->contact_number = $request->contact_number;
        $quote_request->gender = $gender;
        $quote_request->seller_remarks = $request->seller_remarks;
        $quote_request->handing_over_date = date('Y-m-d', strtotime($request->handing_over_date)) ?? null;
        $quote_request->vehicle_number = $request->vehicle_number;

        $quote_request->vehicle_make = $request->vehicle_make; // New
		$quote_request->vehicle_model = $request->vehicle_model; // New
		$quote_request->primary_color = $request->primary_color; // New
		$quote_request->year_of_manufacture = $request->year_of_manufacture; // New
		$quote_request->open_market_value = str_replace(',','',$request->open_market_value); // New
		$quote_request->orig_reg_date = date('Y-m-d', strtotime($request->orig_reg_date)); // New
		$quote_request->first_reg_date = date('Y-m-d', strtotime($request->first_reg_date)); // New
		$quote_request->no_of_transfer = $request->no_of_transfer; // New
		$quote_request->minimumparfbenefit = str_replace(',','',$request->minimumparfbenefit); // New
		$quote_request->coe_expiry_date = date('Y-m-d', strtotime($request->coe_expiry_date)); // New
		$quote_request->coe_category = $request->coe_category; // New
		$quote_request->quota_premium = str_replace(',','',$request->quota_premium); // New
		$quote_request->vehicle_type = $request->vehicle_type; // New
		$quote_request->propellant = $request->propellant; // New
		$quote_request->engine_capacity = str_replace(',','',$request->engine_capacity); // New
		$quote_request->engine_no = $request->engine_no; // New
		$quote_request->chassis_no = $request->chassis_no; // New
		$quote_request->max_unladen_weight = str_replace(',','',$request->max_unladen_weight); // New
		$quote_request->vehicle_scheme = $request->vehicle_scheme; // New
		$quote_request->roadtaxexpirydate = date('Y-m-d', strtotime($request->roadtaxexpirydate)); // New

        $quote_request->nric = $request->nric;
        $quote_request->mileage = str_replace(',','',$request->mileage);
        $files = [];
        if($request->hasfile('upload_file'))
        {
            foreach($request->file('upload_file') as $file)
            {
                $filename = time().rand(1,50).'.'.$file->extension();
                $filepath = 'storage/upload-file/';
							Storage::putFileAs(
								'public/upload-file',
								$file,
								$filename
							);
                $files[] = $filepath.$filename;
            }
        }
        $quote_request->upload_file  = json_encode($files);
		$quote_request->status = 1;
        $quote_request->save();

        $message = 'New Quote Request by '.$request->full_name;
		$notification = new Notification();
		$notification->insurance_id = NULL;
		$notification->quotaton_id = NULL;
		$notification->partner_id = Auth::user()->id;
		$notification->message = $message;
		$notification->link = 'https://www.diycars.com/admin/quoterequest/'.$quote_request->id.'/edit';
		$notification->status = 1;
		$notification->save();

			// EMAIL TO Admin
		$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_QUOTE_MY_CAR_TO_ADMIN'));
		if ($email_template) {
			$data = [];

			$data['email_sender_name'] =  $this->systemSetting()->email_sender_name;
			// $data['from_email'] = $this->systemSetting()->from_email;
			$data['from_email'] = $this->systemSetting()->from_email;
			$data['cc_to_email'] = [];
			$data['subject'] = $email_template->subject;
			//dd($partners);

				$url = url('admin/quoterequest/' . $quote_request->id . '/edit');
				$link = '<a href="' . $url . '">' . $url . '</a>';

				$data['email'] = [$this->systemSetting()->to_email];

				$key = ['{{url}}'];
				$value = [$link];
				$newContent = str_replace($key, $value, $email_template->content);
				$data['contents'] = $newContent;

				try {
				    // $mail = Mail::to($this->systemSetting()->from_email)->send(new EmailNotification($data));
					SendEmail::dispatchNow($data);
				} catch (Exception $exception) {
				// 	dd($exception);
				}
		}



		return redirect('thank-you-quote-my-car')->with('success', 'Your quote request has been submitted successfully.');
	}

	public function change_password($slug = 'my-profile')
	{
		$title = __('constant.CHANGE_PASSWORD');
		$users = $this->user;

		$page = $this->getPages($slug);

		//dd($page);

		if (!$page) {

			return abort(404);
		}

		$all_pages = $this->getAllPages();

		$menu = $this->getMenu();

		return view('account.change_password', compact("page", "all_pages", "menu", 'title', 'users'));
	}

	public function change_password_update(Request $request)
	{
		$validate = $request->validate([

			'current_password' =>  'required|min:8',

			'password' =>  'required|min:8|confirmed',

		]);

		$user = User::find($this->user->id);
		if ($request->current_password) {
			if (!Hash::check($request->current_password, $user->password)) {
				return redirect()->back()->with('error', 'Old password does not match.');
			}
			$user->password = Hash::make($request->password);
		}
		$user->save();

		return redirect()->back()->with('success', 'Your account password has been changed.');
	}

	public function account_verification($token)
	{
		$title = __('constant.ACCOUNT_VERIFICATION');
		$users = User::where('verification_token', $token)->where('email_verified_at', null)->first();
		$slug = __('constant.SLUG_ACCOUNT_VERIFICATION');
		$page = get_page_by_slug($slug);

		//dd($users);

		if (!$page) {

			return abort(404);
		}

		if ($users) {
			$users->email_verified_at = Carbon::now();
			$users->verification_token = null;
			$users->status = 1;
			$users->save();
			return view("account.account_verified", compact("page", "title"));
		}
		return abort(404);
	}

	public function insurance_applications($slug = 'insurance-applications')
	{
		$page = get_page_by_slug($slug);
		$title = __('constant.INSURANCE_APPLICATION');
		//dd($page);
		if (!$page) {
			return abort(404);
		}
// 		$insurance = Insurance::join('insurance_information', 'insurance_information.insurance_id', 'insurances.id')->join('insurance_vehicles', 'insurance_vehicles.insurance_id', 'insurances.id')->where('insurances.user_id', $this->user->id)->orderBy('insurances.id', 'desc')->paginate($this->pagination);
        $insurance = Insurance::has('insurance_information')->has('insurance_vehicle')->where('user_id', $this->user->id)->orderBy('id', 'desc')->where('form_archived', 0)->paginate($this->pagination);
		return view("account.insurance-applications", compact("page", "title", "insurance"));
	}

	public function insurance_applications_detail($id, Request $request)
	{
		$slug = 'insurance-applications';
		$page = get_page_by_slug($slug);
		if (!$page) {
			return abort(404);
		}
		$title = __('constant.INSURANCE_APPLICATION');
		$slug = 'insurance';
		$page2 = get_page_by_slug($slug);
		if (!Auth::check()) {
			$request->session()->put('previous_url', url()->current());
			return $this->loginRedirect();
		}
// 		$insurance = Insurance::join('insurance_information', 'insurance_information.insurance_id', 'insurances.id')->join('insurance_vehicles', 'insurance_vehicles.insurance_id', 'insurances.id')->where('insurances.user_id', Auth::user()->id)->where('insurances.id', $id)->first();

		$insurance = Insurance::has('insurance_information')->has('insurance_vehicle')->where('user_id', $this->user->id)->orderBy('id', 'desc')->where('id', $id)->first();
		if (!$insurance) {
			return abort(403, "Unauthorized access.");
		}



		if ($insurance->quotation_id == null) {
			$partners =  InsuranceQuotation::join('admins', 'admins.id', '=', 'insurance_quotations.partner_id')->where('insurance_quotations.insurance_id', $id)->select('insurance_quotations.*')->groupBy('insurance_quotations.partner_id')->get();
		} else {
			$partners =  InsuranceQuotation::join('admins', 'admins.id', '=', 'insurance_quotations.partner_id')->where('insurance_quotations.insurance_id', $id)->where('insurance_quotations.id', $insurance->quotation_id)->select('insurance_quotations.*')->groupBy('insurance_quotations.partner_id')->get();
		}
		//dd($partners);
		return view("account.insurance-applications-detail", compact("page", "title", "insurance", "partners", "page2"));
	}

	public function insurance_customer_sign(Request $request)
	{

		$insuranceQuotation = InsuranceQuotation::find($request->quotation_id);
		$request->validate([
			'customer_sign' => 'required',
		]);


		$slug = 'insurance';
		$page = get_page_by_slug($slug);
		if ($request->customer_sign) {
			$encoded_image = explode(",", $request->customer_sign)[1];
			$decoded_image = base64_decode($encoded_image);
			$customer_sign = $decoded_image;
			$filename = Carbon::now()->format('Y-m-d H-i-s') . '__' . guid() . '__signature.jpg';
			$filepath = 'storage/signature/';

			$path_signature = $filepath . $filename;
			file_put_contents($path_signature, $customer_sign);
			$insuranceQuotation->customer_sign = $path_signature;
		}


		$insuranceQuotation->save();
		$insurance = Insurance::join('insurance_information', 'insurance_information.insurance_id', 'insurances.id')->join('insurance_vehicles', 'insurance_vehicles.insurance_id', 'insurances.id')->where('insurances.id', $insuranceQuotation->insurance_id)->first();
		$quote = getQuotation($insurance->quotation_id);
		$info = pathinfo($quote->insurance_proposal_form);
		// dd($insurance);
		$quotations =  InsuranceQuotation::where('insurance_id', $insuranceQuotation->insurance_id)->where('partner_id', $insurance->partner_id)->get();
		$content = [];
		$termandcondition = null;
		if ($page->json_content) {
			$content = json_decode($page->json_content, true);
			$termandcondition = isset($content['section_1']) ? $content['section_1'] : '';
		}
		//return View('pdf.insurance', compact("insurance", "quotations", 'termandcondition'));

		if (isset($info['extension']) && $info['extension'] == 'pdf') {


			/****************PDF to pdf generation**************************/
			$content = View::make('pdf.insurance', compact("insurance", "quotations", "termandcondition"));
			$insurancePDF = $this->generatePDF($content, "insurance.pdf");



			/*****************PDF SIGNATURE**************************/
			$content = View::make('pdf.signature', compact("insurance", "quotations", 'termandcondition'));
			$signaturePDF = $this->generatePDF($content, "signature.pdf");


			/****************PDF generation**************************/
			$pdfFile1Path = public_path() . '/' . $insurancePDF;
			$pdfFile2Path = public_path() . '/' . $quote->insurance_proposal_form;
			$pdfFile3Path = public_path() . '/' . $signaturePDF;

			// Create an instance of PDFMerger
			$merger = new PDFMerger();

			// Add 2 PDFs to the final PDF
			$merger->addPDF($pdfFile1Path, 'all');
			$merger->addPDF($pdfFile2Path, 'all');
			$merger->addPDF($pdfFile3Path, 'all');

			// Merge the files into a file in some directory
			$fullfilename =  $filepath . Carbon::now()->timestamp . "__result.pdf";

			// Merge PDFs into a file
			$merger->merge('file', $fullfilename);
		} else {
			/****************PDF generation from html and image**************************/
			$content = View::make('pdf.insurance-all', compact("insurance", "quotations", 'termandcondition'));
			$fullfilename = $this->generatePDF($content, "insurance.pdf");



			/****************PDF generation**************************/
		}
		$insurance = Insurance::find($insuranceQuotation->insurance_id);
		$insurance->insurance_pdf = isset($fullfilename) ? $fullfilename : NULL;
		$insurance->save();

		// EMAIL TO PARTNER
		$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_PARTNER_SIGN_SUBMIT'));
		//dd($email_template);
		if ($email_template) {
			$data = [];

			$data['email_sender_name'] = $this->systemSetting()->email_sender_name;
			$data['from_email'] = $this->systemSetting()->from_email;
			$data['cc_to_email'] = [];
			$data['subject'] = $email_template->subject;
			$partner =  Admin::find($insurance->partner_id);
			//dd($partners);
			if ($partner) {

				$url = url('admin/insurance/' . $insurance->id . '/edit');
				$link = '<a href="' . $url . '">' . $url . '</a>';
				$message = $insurance->main_driver_full_name . ' has signed the Insurance application form.';
				$notification = new Notification();
				$notification->insurance_id = isset($insurance->id) ? $insurance->id : NULL;
				$notification->quotaton_id = isset($request->quotation) ? $request->quotation : NULL;
				$notification->partner_id = $partner->id;
				$notification->message = $message;
				$notification->link = $url;
				$notification->status = 1;
				$notification->save();



				$data['email'] = [$partner->email];

				$name = $partner->firstname . ' ' . $partner->lastname;
				$key = ['{{name}}', '{{customer}}', '{{link}}'];
				$value = [$name, $insurance->main_driver_full_name, $link];
				$newContent = str_replace($key, $value, $email_template->content);
				$data['contents'] = $newContent;
				//dd($data);

				try {
					SendEmail::dispatch($data);
				} catch (Exception $exception) {
					//dd($exception);
				}
			}
		}

		return redirect()->back()->with('success', __('constant.QUOTATION_SIGNED_USER'));
	}

	public function quotation_submit(Request $request)
	{
		//dd($request);
		$quote = getQuotation($request->quotation);
		$insurance = Insurance::find($request->insurance_id);
		if (!$quote) {
			return redirect('insurance-applications/' . $insurance->id)->with('error', __('constant.QUOTATION_DELETED'));
		}

		$insurance->quotation_id = isset($request->quotation) ? $request->quotation : NULL;
		$insurance->partner_id = $quote->partner_id;
		$insurance->save();

		// EMAIL TO USER
		$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_QUOTATION_ACCEPTED'));

		if ($email_template) {
			$data = [];

			$data['email_sender_name'] = $this->systemSetting()->email_sender_name;
			$data['from_email'] = $this->systemSetting()->from_email;
			$data['cc_to_email'] = [];

			$key1 = ['{{customer}}'];
			$value1 = [$insurance->main_driver_full_name];
			$data['subject'] = str_replace($key1, $value1, $email_template->subject);
// 			$data['subject'] = $email_template->subject;

			//dd($data);

			$partner =  Admin::find($quote->partner_id);
			//dd($partners);
			if ($partner) {
				$url = url('admin/insurance/' . $insurance->id . '/edit');
				$link = '<a href="' . $url . '">' . $url . '</a>';
				$message = $insurance->main_driver_full_name . ' has accepted the quotation.';
				$notification = new Notification();
				$notification->insurance_id = isset($request->insurance_id) ? $request->insurance_id : NULL;
				$notification->quotaton_id = isset($request->quotation) ? $request->quotation : NULL;
				$notification->partner_id = $partner->id;
				$notification->message = $message;
				$notification->link = $url;
				$notification->status = 1;
				$notification->save();



				$name = $partner->firstname . ' ' . $partner->lastname;
				$key = ['{{name}}', '{{url}}', '{{customer}}'];
				$value = [$name, $link, $insurance->main_driver_full_name];
				$newContent = str_replace($key, $value, $email_template->content);
				$data['contents'] = $newContent;
				$data['email'] = [$partner->email];
				try {
					SendEmail::dispatchNow($data);
				} catch (Exception $exception) {
					//dd($exception);
				}
			}
		}


		return redirect('insurance-applications/'.$insurance->id)->with('success', __('constant.QUOTATION_ACCEPTED'));

	}


	public function generatePDF($content, $filename)
	{
		$fullfilename = 'storage/insurance/' . Carbon::now()->timestamp . '_' . $filename;
		Storage::makeDirectory('public/insurance');


		$defaultConfig = (new ConfigVariables)->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];

		$defaultFontConfig = (new FontVariables)->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];

		$mpdf = new PDF([
			'mode' => 'utf-8',
			//'format' => 'A4',
			//'orientation' => 'L',
			'margin_left' => 0,
			'margin_right' => 0,
			'margin_top' => 0,
			'margin_bottom' => 0,
			'margin_header' => 0,
			'margin_footer' => 0,
			'fontDir' => array_merge($fontDirs, [
				base_path() . '/public/fonts',
			]),
			'fontdata' => $fontData + [
				'open-sans' => [
					'B' => 'opensans-bold-webfont.ttf',
					'R' => 'opensans-regular-webfont.ttf',
					'useOTL' => 0xFF,
					'useKashida' => 75
				],
			],
			'default_font' => 'open-sans'
		]);
		$mpdf->SetTitle('Autolink');
		$mpdf->SetAuthor('Autolink');
		$mpdf->SetCreator('Autolink');
		$mpdf->SetSubject('Autolink');
		$mpdf->SetKeywords('Autolink');
		$mpdf->AddPageByArray([
			'margin-left' => '10',
			'margin-right' => '10',
			'margin-top' => '10',
			'margin-bottom' => '10',
		]);
		$mpdf->shrink_tables_to_fit = 0;
		$mpdf->WriteHTML($content);
		$mpdf->Output($fullfilename, 'F');
		return $fullfilename;
	}
	public function testPDF()
	{

		$filepath = 'storage/insurance/';
		$filename = Carbon::now()->timestamp . '__' . 'nikunj123.pdf';
		$fullfilename = $filepath . $filename;
		Storage::makeDirectory('public/insurance');


		$defaultConfig = (new ConfigVariables)->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];

		$defaultFontConfig = (new FontVariables)->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];

		$mpdf = new PDF([
			'mode' => 'utf-8',
			//'format' => 'A4',
			//'orientation' => 'L',
			'margin_left' => 0,
			'margin_right' => 0,
			'margin_top' => 0,
			'margin_bottom' => 0,
			'margin_header' => 0,
			'margin_footer' => 0,
			'fontDir' => array_merge($fontDirs, [
				base_path() . '/public/fonts',
			]),
			'fontdata' => $fontData + [
				'open-sans' => [
					'B' => 'opensans-bold-webfont.ttf',
					'R' => 'opensans-regular-webfont.ttf',
					'useOTL' => 0xFF,
					'useKashida' => 75
				],
			],
			'default_font' => 'open-sans'
		]);
		$mpdf->SetTitle('Autolink');
		$mpdf->SetAuthor('Autolink');
		$mpdf->SetCreator('Autolink');
		$mpdf->SetSubject('Autolink');
		$mpdf->SetKeywords('Autolink');
		$content = View::make('pdf.pdf-test');
		$mpdf->AddPageByArray([
			'margin-left' => '10',
			'margin-right' => '10',
			'margin-top' => '10',
			'margin-bottom' => '10',
		]);
		$mpdf->shrink_tables_to_fit = 0;
		$mpdf->WriteHTML($content);
		$mpdf->Output($fullfilename, 'F');
		dd("Hello");
		//return view('pdf.pdf-test');

		$pdf = PDF::loadView('pdf.pdf-test');
		$pdf->save($fullfilename);
	}

	public function myChat(Request $request, $carId = null, $buyerId = null)
	{
		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');
		$user = $this->user;
		$current_user_id = $buyerId;
		$page = get_page_by_slug($slug);
		if ($carId) {
			$chkCar = VehicleMain::where('id', $carId)->first();
			if (!$chkCar) {
				return abort(404);
			}
		}
		if ($buyerId) {
			$chkUser = User::where('id', $buyerId)->first();
			if (!$chkUser) {
				return abort(404);
			}
		}
		// if (!$page) {
		// 	return abort(404);
		// }
		$userId = Auth::user()->id;
		$carId = $carId;
		// $allChat = Chat::where('vehicle_main_id', $carId)->where('block_user', 0)->where('buyer_id', Auth::user()->id)->orWhere('seller_id', Auth::user()->id)->get();
		// $allChat = Chat::where(function ($query) use ($carId) {
		//     // $query->where('vehicle_main_id', $carId);
		//     $query->where('block_user', 0);
		// })->where(function ($query) use ($userId) {
		//     $query->where('buyer_id', $userId)
		//         ->orWhere('seller_id', $userId);
		// })->get();

		$searchMessage = $request->searchMessage;
		$filterData = $request->tabMessage;
		if (!empty($searchMessage)) {
			$allChat = Chat::with('allChat')
				->whereHas('vehicledetail', function ($query) use ($searchMessage) {
					$query->where('vehicle_make', 'like', '%' .  $searchMessage . '%');
					$query->orWhere('vehicle_model', 'like', '%' .  $searchMessage . '%');
				})
				// ->orWhereHas('vehiclemain', function ($query) use ($searchMessage) {
				// 	$query->where('full_name', 'like', '%' .  $searchMessage . '%');
				// })
				->where(function ($query) use ($carId) {
					// $query->where('vehicle_main_id', $carId);
					$query->where('block_user', 0);
				})
				->where(function ($query) use ($userId) {
					$query->where('buyer_id', $userId)
						->orWhere('seller_id', $userId);
				})->get();
			if (sizeof($allChat) <= 0) {
			    $allChat = '';
			    $userids[] = '';
			    $vehicleId[] = '';
				$authUserId = Chat::where('buyer_id', $userId)->orWhere('seller_id', $userId)->get();
				foreach($authUserId as $ids){
					if($userId == $ids->buyer_id){
						$userids[] = $ids->seller_id;
						$vehicleId[] = $ids->id;
					}else{
						$userids[] = $ids->buyer_id;
						$vehicleId[] = $ids->id;
					}
				}
				$userName = User::where('name', 'like', '%' .  $searchMessage . '%')->whereIn('id', $userids)->pluck('id')->toArray();
				$allChat = Chat::with('allChat')
					->where(function ($query) use ($carId) {
						// $query->where('vehicle_main_id', $carId);
						$query->where('block_user', 0);
					})
					->whereIn('id', $vehicleId)
					->where(function ($query) use ($userName) {
						$query->whereIn('buyer_id', $userName)
							->orWhereIn('seller_id', $userName);
					})->get();
			}

			// ->searchTab($_REQUEST)->get();
		} else {
			if (!empty($filterData)) {
				$allChat = Chat::with('allChat')->where(function ($query) use ($carId) {
					// $query->where('vehicle_main_id', $carId);
					$query->where('block_user', 0);
				})->where(function ($query) use ($userId) {
					$query->where('buyer_id', $userId)
						->orWhere('seller_id', $userId);
				})
					->searchTab($_REQUEST)->get();
			} else {
				$allChat = Chat::with('allChat')->where(function ($query) use ($carId) {
					// $query->where('vehicle_main_id', $carId);
					$query->where('block_user', 0);
				})->where(function ($query) use ($userId) {
					$query->where('buyer_id', $userId)
						->orWhere('seller_id', $userId);
				})->get();
			}
		}

		if (!empty($carId)) {
			$carDetails = VehicleMain::with('vehicleDetail')->where('id', $carId)->first();
			$chatDetails = Chat::with('allChat')->where(function ($query) use ($carId, $buyerId) {
				$query->where('vehicle_main_id', $carId);
				$query->where('buyer_id', $buyerId);
			})->where(function ($query) use ($userId) {
				$query->where('buyer_id', $userId)
					->orWhere('seller_id', $userId);
			})->first();
			// $allChat = Chat::where(function ($query) use ($carId, $buyerId) {
			// 	$query->where('vehicle_main_id', $carId);
			// 	$query->where('buyer_id', $buyerId);
			// })->where(function ($query) use ($userId) {
			// 	$query->where('buyer_id', $userId)
			// 		->orWhere('seller_id', $userId);
			// })->get();
			$allChat = Chat::where(function ($query) {
				$query->where('block_user', 0);
			})->where(function ($query) use ($userId) {
				$query->where('buyer_id', $userId)
					->orWhere('seller_id', $userId);
			})->get();
		} else {
			$carDetails = '';
			$chatDetails = '';
		}
		return view('account.my-chat', compact("page", "user", "carDetails", "allChat", "chatDetails", "current_user_id", "carId"));
	}

  public function saveChat(Request $request)
	{
		$chatSender = $request->buyer;
		$receiverId = $request->seller;
		$sender = $request->sender;
		$carId = $request->carDetail;
		$sellerDetails = VehicleMain::where('id', $carId)->first();
		$message = $request->chatText;
		$chkIfExistChat = Chat::where(function ($query) use ($carId) {
			$query->where('vehicle_main_id', $carId);
		})->where(function ($query) use ($chatSender, $receiverId) {
			$query->where('buyer_id', $chatSender)
				->orWhere('seller_id', $receiverId);
		})->first();
		if ($chkIfExistChat) {
			$chatMessage = new ChatMessage();
			$chatMessage->chat_id = $chkIfExistChat->id;
			$chatMessage->buyer_id = $chatSender;
			$chatMessage->seller_id = $sellerDetails->seller_id;
			$chatMessage->messages = $message;
			$chatMessage->sender_id = $sender;
			$chatMessage->new_chat = 1;
			$chatMessage->save();
			return response()->json(['success' => '200']);
		} else {
			$insertChat = new Chat();
			$insertChat->vehicle_main_id  = $carId;
			$insertChat->buyer_id  = $chatSender;
			$insertChat->seller_id  = $sellerDetails->seller_id;
			$insertChat->chat_notification  = 1;
			if ($insertChat->save()) {
				$chatMessage = new ChatMessage();
				$chatMessage->chat_id = $insertChat->id;
				$chatMessage->buyer_id = $chatSender;
				$chatMessage->seller_id = $sellerDetails->seller_id;
				$chatMessage->messages = $message;
				$chatMessage->new_chat = 1;
				$chatMessage->sender_id = $sender;
				$chatMessage->save();
				return response()->json(['success' => '200']);
			} else {
				return response()->json(['success' => '401']);
			}
		}
	}


    public function makeOffer($carId = null)
	{
		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');
		$user = $this->user;
		$page = get_page_by_slug($slug);
		$userId = Auth::user()->id;
		if (!$page) {
			return abort(404);
		}
		if (!empty($carId)) {
			$carDetails = VehicleMain::with('vehicleDetail')->where('id', $carId)->first();
			// $chatDetails = Chat::with('allChat')->where('buyer_id', $userId)->orWhere('seller_id', $userId)->where('vehicle_main_id', $carId)->first();
			$chatDetails = Chat::with('allChat')->where(function ($query) use ($carId) {
				$query->where('vehicle_main_id', $carId);
			})->where(function ($query) use ($userId) {
				$query->where('buyer_id', $userId)
					->orWhere('seller_id', $userId);
			})->first();
		} else {
			$carDetails = '';
			$chatDetails = '';
		}
		$allChats = Chat::where('buyer_id', $userId)->orWhere('seller_id', $userId)->get();
		return view('account.car-offer', compact("page", "user", "carDetails", "chatDetails", "allChats"));
	}

	public function chatDetails($id = null, $buyerId = null)
	{
		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');
		$user = $this->user;
		$page = get_page_by_slug($slug);
		if($id){
			$chkCar = VehicleMain::where('id', $id)->first();
			if(!$chkCar){
				return abort(404);
			}
		}
		if($buyerId){
			$chkUser = User::where('id', $buyerId)->first();
			if(!$chkUser){
				return abort(404);
			}
		}
		$userId = Auth::user()->id;
		$carId = $id;
        $buyerId = $buyerId;
        $seller_particular = '';
        $buyerEmail = Auth::user()->email;

		$chkSellerEmail = Chat::where('vehicle_main_id', $carId)->where('seller_id', $userId)->first();
		if($chkSellerEmail){
			$sellerEmail = User::where('id', $buyerId)->first();
			$buyerEmail = $sellerEmail->email;
		}

        $chatDeatials = Chat::where('vehicle_main_id', $carId)->where('buyer_id', $userId)->orWhere('seller_id', $userId)->first();
        if($chatDeatials){

        }else{
            $checkVehicle = VehicleMain::where('id', $carId)->first();
            if(Auth::user()->id != $checkVehicle->seller_id){
                $buyerId = Auth::user()->id;
                $sellerId = $checkVehicle->seller_id;
            }
            $newChat = new Chat();
            $newChat->vehicle_main_id = $carId;
            $newChat->buyer_id = $buyerId;
            $newChat->seller_id = $sellerId;
            $newChat->offer_amount = 0;
            $newChat->save();
        }

        // $allChat = Chat::where('buyer_id', Auth::user()->id)->orWhere('seller_id', Auth::user()->id)->get();
        $allChat = Chat::where(function ($query) use ($buyerId) {
            // $query->where('vehicle_main_id', $carId);
            $query->where('block_user', 0);
            // $query->where('buyer_id', $buyerId);
        })->where(function ($query) use ($userId) {
            $query->where('buyer_id', $userId)
                ->orWhere('seller_id', $userId);
        })->get();
		if (!empty($carId)) {
			$carDetails = VehicleMain::with('vehicleDetail')->where('id', $carId)->first();
			$chatDetails = Chat::with('allChat')->where(function ($query) use ($carId, $buyerId) {
				$query->where('vehicle_main_id', $carId);
                $query->where('buyer_id', $buyerId);
            })->where(function ($query) use ($userId) {
                $query->where('buyer_id', $userId)
                    ->orWhere('seller_id', $userId);
            })->first();

            // For chat notification
			$chatNotification = '';
            $chatNotification = Chat::where('vehicle_main_id', $carId)->where(function ($query) use ($userId) {
                $query->where('buyer_id', $userId)
                    ->orWhere('seller_id', $userId);
            })->first();
            if($chatNotification){
                $chatMessages = ChatMessage::where('chat_id', $chatNotification->id)->where('sender_id', '!=', $userId)->update(['new_chat' => 0]);
            }

            $sellerDetail = VehicleMain::where('id', $carId)->first();
            $sellerId = $sellerDetail->seller_id;
            $seller_particular = SellerParticular::whereHas('vehicleparticular')->where(function($query) use($buyerEmail, $sellerId, $carId) {
                $query->where('user_id', $sellerId)
				->Where('buyer_email', $buyerEmail)
				->Where('vehicle_main_id', $carId);
            })->where(function($query) {
                $query->whereNotIn('seller_archive', [Auth::user()->id])->whereNotIn('buyer_archive', [Auth::user()->id]);
            })->first();

        } else {
            $carDetails = '';
        }
        // if (!$page) {
        // 	return abort(404);
        // }
        return view('account.chat-details', compact("page", "user", "carDetails", "chatDetails", "allChat", "seller_particular"));
    }

	public function likeVehicle($id, Request $request){
		if(Auth::check()){
			$user_id = Auth::user()->id;
			$vehicle_liked = LikeCount::where('user_id', '=', $user_id)
						->where('vehicle_id', '=', $id)
						->first();
			if(isset($vehicle_liked)){
				if($vehicle_liked->is_liked == 1){
					$vehicle_liked->is_liked = 0;
				}else{
					$vehicle_liked->is_liked = 1;
				}
				$vehicle_liked->save();
			}else{
				$vehicle_like = new LikeCount;
				$vehicle_like->user_id = $user_id;
				$vehicle_like->vehicle_id = $id;
				$vehicle_like->is_liked = 1;
				$vehicle_like->save();
			}
			return redirect()->back()->with('success',  __('constant.SUCCESS', ['module' => 'Like']));
		}else{
			$request->session()->put('previous_url', url()->previous());
			return $this->loginRedirect();
		}
	}

	public function reportVehicle($id, Request $request){
		if(Auth::check()){
			$user_id = Auth::user()->id;
			$vehicle_reported = ReportVehicle::where('user_id', '=', $user_id)
								->where('vehicle_id', '=', $id)
								->first();
			if(isset($vehicle_reported)){
				if($vehicle_reported->is_reported == 1){
					$vehicle_reported->is_reported = 0;
				}else{
					$vehicle_reported->is_reported = 1;
				}
				$vehicle_reported->save();
			}else{
				$vehicle_report = new ReportVehicle;
				$vehicle_report->user_id = $user_id;
				$vehicle_report->vehicle_id = $id;
				$vehicle_report->is_reported = 1;
				$vehicle_report->save();
			}
			return redirect()->back()->with('success',  __('constant.SUCCESS', ['module' => 'Report']));
		}else{
			$request->session()->put('previous_url', url()->previous());
			return $this->loginRedirect();
		}
    }

	public function saveOffer(Request $request){
        // $offerAmount = $request->offeramount;
        $offerAmount = str_replace(',','', $request->offeramount);
        $vechileId = $request->offerAmtCarId;
        $chatId  = $request->chatId;
        $vechileDetail = Chat::where('vehicle_main_id', $vechileId)->where('id', $chatId)->first();
        if($vechileDetail){
            $vechileDetail->offer_amount = $offerAmount;
            $vechileDetail->cancel_offer_buyer = 0;
            $vechileDetail->save();
        }else{
            return abort(404);
        }
        return redirect()->back();

	}

    public function approveOffer(Request $request)
    {
        $status = $request->val;
        $chatId = $request->chatId;
        $chatDetail = Chat::where('id', $chatId)->first();
        if($chatDetail){
            $chatDetail->accept_reject_offer = $status;
            $chatDetail->save();
            return response()->json(['success' => '200']);
        }else{
            return response()->json(['success' => '401']);
        }
    }

    public function approveOfferRevised(Request $request)
    {
        $status = $request->val;
        $chatId = $request->chatId;
        $chatDetail = Chat::where('id', $chatId)->first();
        if($chatDetail){
            if($status == 1){
                $chatDetail->offer_amount = $chatDetail->revise_offer_amount;
                $chatDetail->accept_reject_offer = 1;
            }
            $chatDetail->revise_offer_status = $status;
            $chatDetail->save();
            return response()->json(['success' => '200']);
        }else{
            return response()->json(['success' => '401']);
        }
    }

    public function cancelOffer(Request $request)
    {
        $chatId = $request->chatId;
        $chatDetail = Chat::where('id', $chatId)->first();
        if($chatDetail){
            $chatDetail->cancel_offer_buyer = 1;
            $chatDetail->offer_amount = null;
            $chatDetail->accept_reject_offer = 0;
            $chatDetail->save();
            return response()->json(['success' => '200', 'message'=>'Offer cancelled']);
        }else{
            return response()->json(['success' => '401']);
        }
    }

    public function reviseOffer(Request $request)
    {
        $chatId = $request->chatId;
        $reviseAmount = $request->reviseAmount;
        $chatDetail = Chat::where('id', $chatId)->first();
        if($chatDetail){
            $chatDetail->revise_offer_amount = $reviseAmount;
            $chatDetail->revise_offer_buyer = 1;
            $chatDetail->revise_offer_notification = 1;
            $chatDetail->save();
            return response()->json(['success' => '200', 'message'=>'Offer revised']);
        }else{
            return response()->json(['success' => '401']);
        }
    }

    public function blockUser(Request $request)
    {
        $userId = $request->userId;
        $chatId = $request->chatId;
        $chat = Chat::where('id', $chatId)->first();
        if($chat){
            $chat->block_user = 1;
            $chat->save();
            return response()->json(['success' => '200', 'message'=>'User revised']);
        }else{
            return response()->json(['success' => '401']);
        }
    }

    public function deleteChat(Request $request)
    {
        $userId = $request->userId;
        $chatId = $request->chatId;
        // $deleteChat = ChatMessage::where('chat_id', $chatId)->delete();
        $deleteChat = ChatMessage::where('chat_id', $chatId)->where('sender_id', $userId)->delete();
        if($deleteChat){
            // $chatDetail = Chat::where('id', $chatId)->first();
            // $chatDetail->offer_amount = null;
            // $chatDetail->accept_reject_offer = 0;
            // $chatDetail->revise_offer_buyer = 0;
            // $chatDetail->revise_offer_status = 0;
            // $chatDetail->revise_offer_amount = '';
            // $chatDetail->save();
            return response()->json(['success' => '200', 'message'=>'Chat deleted']);
        }else{
            return response()->json(['success' => '401']);
        }
    }
    public function staInspection(Request $request)
    {
        $chatId = $request->chatId;
        $staChat = Chat::where('id', $chatId)->first();
        if($staChat){
            $staChat->sta_inspection = 1;
            $staChat->save();
            return response()->json(['success' => '200', 'message'=>'STA Inspection']);
        }else{
            return response()->json(['success' => '401']);
        }
    }

    public function buyerInfo(Request $request)
    {
        $chatId = $request->chatId;
        $status = $request->status;
        $staChat = Chat::where('id', $chatId)->first();
        if($staChat){
            $staChat->buyer_info = $status;
            $staChat->sp_agreement = 1;
            $staChat->save();
            return response()->json(['success' => '200', 'message'=>'Success']);
        }else{
            return response()->json(['success' => '401']);
        }
    }

    public function confirmBooking(Request $request)
    {
        $chatId = $request->chatId;
        // $datebooking = $request->datebooking;
        $datebooking = date('Y-m-d', strtotime($request->datebooking));
        $timebooking = explode(" ", $request->timebooking);
        $bookingDateTime = $datebooking . ' ' . $timebooking[0];
        $staChat = Chat::where('id', $chatId)->first();
        if ($staChat) {
            $staChat->sta_inspection_date = $bookingDateTime;
            $staChat->save();
            return response()->json(['success' => '200', 'message' => 'Success']);
        } else {
            return response()->json(['success' => '401']);
        }

    }

    public function reportUser(Request $request)
    {
        $userId = $request->userId;
        $chatId = $request->chatId;
        $chat = Chat::where('id', $chatId)->first();
        if($chat){
            $chat->report_user_id = 1;
            $chat->save();
            return response()->json(['success' => '200', 'message'=>'User revised']);
        }else{
            return response()->json(['success' => '401']);
        }
    }

    public function viewQuote($id, Request $request)
	{
		if (Auth::check()) {
			$user_id = Auth::user()->id;
			$quote_request = QuoteRequest::where('id', '=', $id)->first();
			return view('account.view-quote', compact('quote_request'));

		} else {
			$request->session()->put('previous_url', url()->previous());
			return $this->loginRedirect();
		}
	}

	public function archivedInsurance(Request $request){
		$id = $request->multiple_archive;
		$expId = explode(',', $id);
		foreach($expId as $id){
				$chkId = Insurance::where('id', $id)->first();
				if($chkId){
						$chkId->form_archived = 1;
						$chkId->save();
				}
		}
		return redirect()->back()->with('success', 'Application archived.');
}

	public function archivedInsuranceShow()
    {
        $title = 'Insurance Archived';
        $insurance = Insurance::has('insurance_information')->has('insurance_vehicle')->where('user_id', $this->user->id)->orderBy('id', 'desc')->where('form_archived', 1)->paginate($this->pagination);

			return view("account.insurance-applications_show", compact("title", "insurance"));
    }
}
