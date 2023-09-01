<?php

namespace App\Http\Controllers;

use App\VehicleMain;
use App\VehicleDetail;
use App\Advertiser;
use App\BuyerParticular;
use App\Faq;
use App\Admin;
use App\Gallery;
use App\ViewCount;
use App\LikeCount;
use Illuminate\Http\Request;
use App\Page;
use App\Contact;
use App\Menu;
use App\Slider;
use App\Category;
use App\Competition;
use App\Country;
use App\Partner;
use App\SystemSetting;
use App\GradingExam;
use App\GradingStudent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;
use PDF;
use App\Traits\SystemSettingTrait;
use App\Traits\GetSmartBlock;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Mail\EmailNotification;
use App\SellerParticular;
use App\Jobs\SendEmail;
use App\Level;
use App\Survey;
use App\SurveyQuestion;
use App\Traits\GetEmailTemplate;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PagesFrontController extends Controller
{
    use SystemSettingTrait,  GetEmailTemplate,GetSmartBlock;

    public function __construct()
    {

        $this->system_settings = $this->systemSetting();
        $this->smart_blocks = $this->smartBlock();
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware('auth:web');



        $this->middleware(function ($request, $next) {
            $this->student_id = Auth::user()->id;
            $this->previous = url()->previous();
            return $next($request);

        });
    }


    public function index($slug = 'home')
    {
        session()->forget('previous_url');
        $page = get_page_by_slug($slug);
        if (!$page) {
            return abort(404);
        }
        $levels = Level::get();
        $levelArray = json_decode(Auth::user()->level_id) ?? array();
        $todayDate = date('Y-m-d');

        $competition = Competition::where('status', 1)->where('date_of_competition', $todayDate)->first();
        $grading_exam = GradingExam::join('grading_students','grading_students.grading_exam_id','grading_exams.id')->select('grading_exams.*')->whereDate('grading_exams.exam_date','=',$todayDate)->where('grading_exams.status', 1)->where('grading_students.approve_status', 1)->where('grading_students.user_id', Auth::user()->id)->first();
        $competition = Competition::where('status', 1)->where('date_of_competition', '>=', $todayDate)->first();


//        $sliders = Slider::where('status', 1)->orderBy('view_order', 'asc')->get();
//		$partners = Partner::where('status', 1)->orderBy('view_order', 'asc')->get();
//		$testimonials = Testimonial::where('status', 1)->get();
        //dd($grading_exam);
        $grading_exam = GradingExam::join('grading_students','grading_students.grading_exam_id','grading_exams.id')->select('grading_exams.*')->whereDate('grading_exams.exam_date','=',$todayDate)->where('grading_exams.status', 1)->where('grading_students.user_id', Auth::user()->id)->first();
        $surveys = Survey::where('status', 1)->first();
        $user = User::where('id', Auth::user()->id)->first();
        $country = Country::orderBy('phonecode', 'asc')->get();
        return view('home', compact("page", 'levels', 'levelArray', 'competition', 'surveys', 'user', 'country','grading_exam'));
    }

    public function instructor($slug = null){
        // dd($slug);
        $page = get_page_by_slug($slug);
        $userType = array(1,2,3,4);
        if (!$page || in_array(Auth::user()->user_type_id,$userType) ) {
            return abort(404);
        }else{

        }

    }

    public function pages($slug, $reference = null, $id = null, Request $request)
    {
        session()->forget('previous_url');
        $page = get_page_by_slug($slug);
		$system_settings = $this->system_settings;
        $smart_blocks = $this->smart_blocks;
        if (!$page) {
            return abort(404);
        }
        if (in_array($page->id, [__('constant.FAQ_PAGE_ID'), __('constant.TERMS_OF_USE'), __('constant.PRIVACY_POLICY'), __('constant.ABOUT_PAGE_ID')])) {
            return view('about', compact('page', 'system_settings', 'smart_blocks'));
        }

        if (in_array($page->id, [__('constant.STANDALONE_PAGE_ID')])) {
            return view('standalone', compact('page', 'system_settings', 'smart_blocks'));
        }

        return view('pages', compact('page', 'system_settings', 'smart_blocks'));
    }


    public function contact_store(Request $request)
    {
        if(!empty($request->url)){
            return redirect('thank-you')->with('success', 'Contact form submitted successfully.');
        }
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $this->system_settings->recaptcha_secret_key . '&response=' . $request->captcha_response);
        $responseData = json_decode($verifyResponse);

        $messages = [];
        // $messages['full_name.required'] = 'The name field is required.';
        // $messages['email_id.required'] = 'The e-mail address field is required.';
        // $messages['email_id.email'] = 'The e-mail address must be a valid email address.';
        // $messages['country_code.required'] = 'The country code field is required.';
        // $messages['country_code.regex'] = 'The Country code entered is invalid.';
        // $messages['contact_number.required'] = 'The contact number field is required.';
        // $messages['contact_number.min'] = 'The contact number must be at least 8 characters.';
        // $messages['message.required'] = 'The comments/feedback field is required.';
        $messages['full_name.required'] = 'This field is required';
        $messages['email_id.required'] = 'This field is required';
        $messages['email_id.email'] = 'The e-mail address must be a valid email address.';
        $messages['country_code.required'] = 'This field is required';
        $messages['country_code.regex'] = 'The Country code entered is invalid.';
        $messages['contact_number.required'] = 'This field is required';
        $messages['contact_number.min'] = 'The contact number must be at least 8 characters.';
        $messages['message.required'] = 'This field is required';
        //$messages['message.max'] = 'The comments/feedback may not be greater than 1000 characters.';
        $request->validate([
            'full_name' => 'required|string',
            'email_id' => 'required|email',
            'country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',
            'contact_number' => 'required|numeric|min:8',
            'message'   =>  'required|max:1000',
        ], $messages);

        if (!$responseData->success) {
            return redirect()->back()->withInput()->with('error', __('constant.CAPTCHA_ERROR'));
        }

        $contact = new Contact;
        $contact->full_name = $request->full_name;
        $contact->email_id = $request->email_id;
        $contact->country_code = $request->country_code;
        $contact->contact_number = $request->contact_number;
		$phone_number=$request->country_code.$request->contact_number;
        $contact->message = $request->message;
        $contact->save();
        // EMAIL TO USER
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_USER_CONTACT_ENQUIRY'));

        if ($email_template) {
            $data = [];

            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['cc_to_email'] = [];

            $data['subject'] = $email_template->subject;


            $key = ['{{name}}'];
            $value = [$request->full_name];
            $newContent = str_replace($key, $value, $email_template->content);
            $data['contents'] = $newContent;
			//dd($data);
            try {
                $mail = Mail::to($request->email_id)->send(new EmailNotification($data));
            } catch (Exception $exception) {
                //dd($exception);
            }

        }
        // EMAIL TO ADMIN
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_CONTACT_ENQUIRY'));
        if ($email_template) {
            $data = [];

            $url = url("/admin/contact/" . $contact->id);

            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['cc_to_email'] = [];

            $data['subject'] = $email_template->subject;


            $key = ['{{full_name}}', '{{email}}', "{{contact_number}}", "{{message}}", "/{{action_url}}", "{{action_url}}"];
            $value = [$request->full_name, $request->email_id, $phone_number, $request->message, $url, $url];
            $newContent = str_replace($key, $value, $email_template->content);
            $data['contents'] = $newContent;
            $admins =  Admin::admin()->get();
			//dd($admins);
			foreach($admins as $admin)
			{
               $data['email'] = [$admin->email];
                try {
                    SendEmail::dispatch($data);
                } catch (Exception $exception) {
                    // dd($exception);
                }
            }
        }

    //   return redirect()->back()->with('success',  "Contact form submitted successfully.");
        return redirect('thank-you')->with('success', 'Contact form submitted successfully.');
    }

    public function marketplace_search_results()
    {
        $slug="market-place-search";
        $page = get_page_by_slug($slug);
        //Most viewed vehicle
        if(!Auth::guest()){
            $loggedUserID = Auth::user()->id;
            $mostViewedVehicles = ViewCount::with('vehicle.vehicleDetail')
                                    ->where('vehicle_view_counts.user_id', '=', $loggedUserID)
                                    ->orderBy('view_count', 'desc')
                                    ->get();
            //dd($mostViewedVehicles);
        }else{
            $user_ip = \Request::ip();
            $mostViewedVehicles = ViewCount::with('vehicle.vehicleDetail')
                                    ->where('vehicle_view_counts.user_ip', '=', $user_ip)
                                    ->whereNull('vehicle_view_counts.user_id')
                                    ->orderBy('view_count', 'desc')
                                    ->get();
            //dd($mostViewedVehicles);
        }

        $mostViwewdVehicleIds = $mostViewedVehicles->map(function ($mostViewedVehicle) {
            return $mostViewedVehicle->vehicle_id;
        });

        // Most Liked Vehicles
        $mostLikedVehicles = LikeCount::with('vehicle.vehicleDetail')
                                ->addSelect('vehicle_like_counts.vehicle_id', DB::raw('count(*) as like_count'))
                                ->where('vehicle_like_counts.is_liked', '=', 1)
                                ->groupBy('vehicle_like_counts.user_id', 'vehicle_like_counts.vehicle_id')
                                ->orderBy('like_count', 'desc')
                                ->get();

        $mostLikedVehicleIds = $mostLikedVehicles->map(function ($mostLikedVehicle) {
            return $mostLikedVehicle->vehicle_id;
        });

        if (!$page) {
            return abort(404);
        }
        $query = VehicleMain::query();
        $query->join('vehicle_details','vehicle_details.vehicle_id','vehicle_mains.id');
        $query->select('vehicle_details.*','vehicle_mains.status as status',DB::raw('(YEAR(CURDATE()) - vehicle_details.year_of_mfg) as age'));
        $query->whereIn('status', [2,5]);
        if(request()->get('search_input')!="")
        {
            $search_input=request()->get('search_input');
            $query->where(function($query) use ($search_input) {
                $query->where('vehicle_details.vehicle_make', 'LIKE', '%' . $search_input . '%')->orWhere('vehicle_details.vehicle_model', 'LIKE', '%' . $search_input . '%');
            });
        }

        if(request()->get('make')!="")
        {
            $query->where('vehicle_details.vehicle_make', 'LIKE', '%' . request()->get('make') . '%');
        }

        if(request()->get('model')!="")
        {
            $query->where('vehicle_details.vehicle_model', 'LIKE', '%' . request()->get('model') . '%');
        }

        if(request()->get('vehicle_type')!="")
        {
            $query->where('vehicle_details.vehicle_type', 'LIKE', '%' . request()->get('vehicle_type') . '%');
        }

        if(request()->get('orig_reg_date')!="")
        {
            $query->where('vehicle_details.year_of_mfg', request()->get('orig_reg_date'));
        }


        if(request()->get('price')!="")
        {
            $price=explode('_', request()->get('price'));
            $query->whereBetween('vehicle_details.price', [$price[0], $price[1]]);
        }

        if(request()->get('depreciation_price')!="")
        {
            $price=explode('_', request()->get('depreciation_price'));
            $query->whereBetween('vehicle_details.depreciation_price', [$price[0], $price[1]]);
        }


        if(request()->get('mileage')!="")
        {
            $mileage=explode('_', request()->get('mileage'));
            $query->whereBetween('vehicle_details.mileage', [$mileage[0], $mileage[1]]);
        }

        if(request()->get('engine_cc')!="")
        {
            $engine_cc=explode('_', request()->get('engine_cc'));
            $query->whereBetween('vehicle_details.engine_cc', [$engine_cc[0], $engine_cc[1]]);
        }

        if(request()->get('status')!="")
        {
            $query->where('vehicle_mains.status', request()->get('status'));
        }

        if(request()->get('listing_status')!="" && request()->get('listing_status')==1)
        {
            $query->whereIn('vehicle_details.vehicle_id', $mostViwewdVehicleIds);
        }
        elseif(request()->get('listing_status')!="" && request()->get('listing_status')==2)
        {
            $query->whereIn('vehicle_details.vehicle_id', $mostLikedVehicleIds);
        }
        elseif(request()->get('listing_status')!="" && request()->get('listing_status')==3)
        {
            $query->orderBy('vehicle_details.price', 'asc');
        }
        elseif(request()->get('listing_status')!="" && request()->get('listing_status')==4)
        {
            $query->orderBy('vehicle_details.depreciation_price', 'asc');
        }
        elseif(request()->get('listing_status')!="" && request()->get('listing_status')==5)
        {
            $query->orderBy('age', 'asc');
        }

        $query->orderBy('vehicle_mains.created_at', 'desc');

        $cars=$query->get();
        //dd($cars);
        return view('marketplace.car-search-results', compact("cars","page"));
    }

    public function sign_signature()
    {
        return view('signature');
    }
}
