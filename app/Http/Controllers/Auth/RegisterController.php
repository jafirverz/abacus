<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Country;
use App\Http\Controllers\Controller;
use App\Instructor;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

     use RegistersUsers, GetEmailTemplate, SystemSettingTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/my-profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->system_settings = $this->systemSetting();
		$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
		  //  'company_name' => ['required', 'string'],
			'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country_code' => ['required', 'regex:/^(\+)([1-9]{1,3})$/'],
			'mobile' => ['required', 'string'],
 			'dob' => ['required'],
			'gender' => ['required'],
            'instructor' => ['required'],
        ]);
    }

	public function register(Request $request)
    {
        // Get verify response data
        $system_settings = $this->system_settings;
//		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $system_settings->recaptcha_secret_key . '&response=' . $request->captcha_response);
//		$responseData = json_decode($verifyResponse);
        if(!empty($request->url)){
            return redirect('register')->with('success',  'Your account has been created with DIY Cars! We have sent you an account activation email. Please check your inbox to activate the account.');
        }

        $messages = [
            'country_code.regex' => 'The Country code entered is invalid.',
            'name.required' => 'This field is required',
            'email.required' => 'This field is required',
            'password.required' => 'This field is required',
            'country_code.required' => 'This field is required',
            'mobile.required' => 'This field is required',
            'gender.required' => 'This field is required',
            'dob.required' => 'This field is required',
            'instructor.required' => 'This field is required',

        ];

		$request->validate([
				'name' => 'required|string',
                'email' =>  'required|email',
                'password'  =>  'required|min:8',
                'country_code' => 'required',
				'mobile' => 'required|string',
				'gender' => 'required',
                'dob' => 'required',
                'instructor' => 'required',
            ], $messages);

        $usersCheck = User::where('email', $request->email)->first();
        if($usersCheck){
            if($usersCheck->approve_status == 1 || $usersCheck->approve_status == 0){
                throw ValidationException::withMessages(['email' => 'Email Id already exist']);
            }
        }
        

//        if (!$responseData->success) {
//            return redirect()->back()->withInput()->with('error', __('constant.CAPTCHA_ERROR'));
//        }
            $acName = '';
            $var = $request->dob;
            $date = str_replace('/', '-', $var);
            $dob = date('Y-m-d', strtotime($date));
            $dob1 = date('dmy', strtotime($dob));
            $fullnameEx = explode(' ', $request->name);
            foreach($fullnameEx as $funame){
                $acName .= strtoupper(substr($funame, 0, 1));
            }
            $accountId = 'SUD-'.$dob1.$acName;
            $chkAccountId = User::where('account_id', 'like', '%'.$accountId.'%')->orderBy('id', 'desc')->first();
            if($chkAccountId){
                $accId = $chkAccountId->account_id;
                $expAcc = explode('-', $accId);
                $i = 1;
                if(count($expAcc) < 3){
                    $accountId = 'SUD-'.$dob1.$acName.'-'.$i;
                }else{
                    $incre = $expAcc[2] + 1;
                    $accountId = 'SUD-'.$dob1.$acName.'-'.$incre;
                }
            }else{
                $accountId = 'SUD-'.$dob1.$acName;
            }
            
            //dd($request->all());
			$users = new User;
            $users->dob = $dob ?? null;
			$users->name = $request->name;
            $users->account_id = $accountId;
            $users->email = $request->email;
            $users->password = Hash::make($request->password);
			$users->address = $request->address??NULL;
            $users->country_code = $request->country_code;
            $users->instructor_id = $request->instructor;
            $users->country_code_phone = $request->country_code_phone;
			$users->mobile = $request->mobile;
			$users->gender = $request->gender;
			$users->verification_token = Str::random(60);
			$users->role_id = 3;
            $users->user_type_id = 1;
            $users->created_at = Carbon::now();
            $users->save();

            if($request->gender == 1){
                $gender = 'Male';
            }else{
                $gender = 'Female';
            }
            $instructor = User::where('id', $request->instructor)->first();

//			Admin email for new student registration
			$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_STUDENT_REGISTRATION'));
            $admins = Admin::get();

            if ($email_template) {
                $data = [];
                foreach($admins as $admin){
                    $data['email_sender_name'] = systemSetting()->email_sender_name;
                    $data['from_email'] = systemSetting()->from_email;
                    $data['to_email'] = [$admin->email];
                    $data['cc_to_email'] = [];
                    $data['subject'] = $email_template->subject;

                    $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{country}}','{{instructor}}'];
                    $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $instructor->name];

                    $newContents = str_replace($key, $value, $email_template->content);

                    $data['contents'] = $newContents;
                    try {
                        $mail = Mail::to($admin->email)->send(new EmailNotification($data));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }

            }

            //			Instructor email for new student registration
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_INSTRUCTOR_STUDENT_REGISTRATION'));

        if ($email_template) {
            $data = [];
                $data['email_sender_name'] = systemSetting()->email_sender_name;
                $data['from_email'] = systemSetting()->from_email;
                $data['to_email'] = [$instructor->email];
                $data['cc_to_email'] = [];
                $data['subject'] = $email_template->subject;

                $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{country}}','{{instructor}}'];
                $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $instructor->name];

                $newContents = str_replace($key, $value, $email_template->content);

                $data['contents'] = $newContents;
                try {
                    $mail = Mail::to($instructor->email)->send(new EmailNotification($data));
                } catch (Exception $exception) {
                    dd($exception);
                }

        }

			return redirect('register')->with('success',  'Your account has been created. Waiting for the approval from Admin.');

	}

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

	public function showRegistrationForm()
    {
        $slug = __('constant.SLUG_REGISTER');
		$page = get_page_by_slug($slug);
        $instructors = User::where('user_type_id', 5)->get();
        $country = Country::orderBy('country', 'asc')->get();
        return view('auth.register',compact("page","instructors", 'country'));
    }

}
