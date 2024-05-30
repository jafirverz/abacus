<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\SystemSettingTrait;
use App\Traits\PageTrait;
use App\User;
use App\Level;
use App\Country;
use App\LearningLocation;
use Carbon\Carbon;
use Exception;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use App\UserFeedback;
use Illuminate\Support\Facades\Mail;

class ExternalAccountController extends Controller
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
    //
    public function my_students()
    {
        $country = Country::orderBy('phonecode')->get();
        $levels = Level::get();

        if(isset($_GET['keyword']) && $_GET['keyword']!='')
        {
            $students = User::where('name','like','%' .$_GET['keyword'].'%')->where('instructor_id', Auth::user()->id)->paginate($this->pagination);
        }
        elseif(isset($_GET['status']) && $_GET['status']!='')
        {
            $students = User::where('approve_status', $_GET['status'])->where('instructor_id', Auth::user()->id)->paginate($this->pagination);
        }
        else
        {
            $students=User::where('user_type_id',4)->where('instructor_id',$this->user->id)->paginate($this->pagination);
        }
        return view('account.external-my-students', compact('levels', 'country','students'));
    }


    public function add_students()
    {
        $country = Country::orderBy('phonecode')->get();
        $levels = Level::get();
        $locations = LearningLocation::orderBy('id','desc')->get();
        return view('account.external-add-students', compact('levels', 'country','locations'));
    }

    public function edit_students($id)
    {
        $country = Country::orderBy('phonecode')->get();
        $levels = Level::get();
        $customer = User::find($id);
        $locations = LearningLocation::orderBy('id','desc')->get();
        return view('account.external-edit-students', compact('levels', 'country','customer','locations'));
    }


    public function view_students($id)
    {
        $country = Country::orderBy('phonecode')->get();
        $levels = Level::get();
        $customer = User::find($id);
        return view('account.external-view-students', compact('levels', 'country','customer'));
    }

    public function store_add_students(Request $request)
    {
        $fields = [
            'email' =>  'required|email',
            'name' => 'required|string',
            'password'  =>  'required|min:8',
            'dob' => 'required',
            'country_code_phone' => 'required',
            'mobile' => 'required|integer|min:8',
            'gender' => 'required|string',
        ];
        //dd($request);
        $messages = [];
        $messages['email.required'] = 'The email address field is required.';
        $messages['name.required'] = 'The name field is required.';
        $messages['password.required'] = 'The password field is required.';
        $messages['email.email'] = 'The email address must be a valid email address.';
        $messages['country_code_phone.required'] = 'The country code is required.';
        //$messages['country_code.required'] = 'The country code field is required.';
        $messages['dob.required'] = 'Date of Birth is required.';
        $messages['mobile.required'] = 'The contact number field is required.';
        $messages['mobile.min'] = 'The contact number must be at least 8 characters.';
        $request->validate($fields, $messages);
        $acName = '';
        $dob = date('Y-m-d', strtotime($request->dob));
        $dob1 = date('dmy', strtotime($dob));
        $fullnameEx = explode(' ', $request->name);
        foreach($fullnameEx as $funame){
            $acName .= strtoupper(substr($funame, 0, 1));
        }
        $accountId = 'SUD-'.$dob1.$acName;
        $customer = new User();
        if(Auth::user()->user_type_id==5)
        {
            $customer->level_id = json_encode($request->level);
            $customer->country_code = Auth::user()->country_code;
            $customer->learning_updates = $request->learning_updates??NULL;
        }

        $customer->name = $request->name;
        $customer->account_id = $accountId;
        $customer->instructor_id = $this->user->id;
        $customer->dob = date('Y-m-d', strtotime($request->dob))??NULL;
        $customer->email = $request->email??NULL;
        $customer->address = $request->address??NULL;
        $customer->gender = $request->gender??NULL;
        $customer->learning_locations = $request->learning_locations??NULL;
        $customer->remarks = $request->remarks??NULL;

        $customer->country_code_phone = $request->country_code_phone??NULL;
        $customer->mobile = $request->mobile??NULL;
        if(Auth::user()->user_type_id==6)
        {
		$customer->approve_status = 1;
        $customer->user_type_id = 4;
        }
        else
        {
        $customer->user_type_id = 1;
        }

        if (!is_null($request->password)) {
            $customer->password = Hash::make($request->password);
        }
        $customer->created_at = Carbon::now();
        $customer->save();

        if($request->gender == 1){
            $gender = 'Male';
        }else{
            $gender = 'Female';
        }


        //			Admin email for new student registration
			// $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_STUDENT_REGISTRATION'));
            // $admins = Admin::get();

            // if ($email_template) {
            //     $data = [];
            //     foreach($admins as $admin){
            //         $data['email_sender_name'] = systemSetting()->email_sender_name;
            //         $data['from_email'] = systemSetting()->from_email;
            //         $data['to_email'] = [$admin->email];
            //         $data['cc_to_email'] = [];
            //         $data['subject'] = $email_template->subject;

            //         $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{country}}','{{instructor}}'];
            //         $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $instructor->name];

            //         $newContents = str_replace($key, $value, $email_template->content);

            //         $data['contents'] = $newContents;
            //         try {
            //             $mail = Mail::to($admin->email)->send(new EmailNotification($data));
            //         } catch (Exception $exception) {
            //             dd($exception);
            //         }
            //     }

            // }

            //			Instructor email for new student registration
        // $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_INSTRUCTOR_STUDENT_REGISTRATION'));

        // if ($email_template) {
        //     $data = [];
        //         $data['email_sender_name'] = systemSetting()->email_sender_name;
        //         $data['from_email'] = systemSetting()->from_email;
        //         $data['to_email'] = [$instructor->email];
        //         $data['cc_to_email'] = [];
        //         $data['subject'] = $email_template->subject;

        //         $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{country}}','{{instructor}}'];
        //         $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $instructor->name];

        //         $newContents = str_replace($key, $value, $email_template->content);

        //         $data['contents'] = $newContents;
        //         try {
        //             $mail = Mail::to($instructor->email)->send(new EmailNotification($data));
        //         } catch (Exception $exception) {
        //             dd($exception);
        //         }

        // }

        if(Auth::user()->user_type_id==5)
        {
            return redirect()->route('instructor.my-students')->with('success', __('constant.ACOUNT_CREATED'));
        }
        else
        {
            return redirect()->route('external-profile.my-students')->with('success', __('constant.ACOUNT_CREATED'));
        }
    }

    public function delete_students($id)
    {
        User::where('id', $id)->delete();
        return redirect()->back()->with('success', __('constant.ALLOCATE_DELETED'));
    }

    public function update_students (Request $request,$id)
    {
        //dd($request->all());
        $fields = [
            'email' =>  'required|email',
            'name' => 'required|string',
            'password'  =>  'nullable|min:8',
            'dob' => 'required',
            'country_code_phone' => 'required',
            'mobile' => 'required|integer|min:8',
            'gender' => 'required|string',
        ];

        //dd($request);
        $messages = [];
        $messages['email.required'] = 'The email address field is required.';
        $messages['name.required'] = 'The name field is required.';
        $messages['password.required'] = 'The password field is required.';
        $messages['email.email'] = 'The email address must be a valid email address.';
        $messages['country_code_phone.required'] = 'The country code is required.';
        //$messages['country_code.required'] = 'The country code field is required.';
        $messages['dob.required'] = 'Date of Birth is required.';
        $messages['mobile.required'] = 'The contact number field is required.';
        $messages['mobile.min'] = 'The contact number must be at least 8 characters.';
        $request->validate($fields, $messages);

        $customer = User::find($id);

        $flag = 0;
        $userStatus = $customer->approve_status;
        if($userStatus == 1){
            // No need to send email for user account activation
        }elseif($userStatus == 0 && $request->status == 1 ){
            $flag = 1;
        }
        $userAccountId = $customer->account_id;
        $userPassword = $request->password ?? $customer->user_pass;

        if(Auth::user()->user_type_id==5)
        {
            $customer->level_id = json_encode($request->level);
            $customer->country_code = Auth::user()->country_code;
            $customer->learning_updates = $request->learning_updates??NULL;
        }
        $customer->name = $request->name;
        $customer->dob = date('Y-m-d', strtotime($request->dob))??NULL;
        $customer->email = $request->email??NULL;
        $customer->address = $request->address??NULL;
        $customer->gender = $request->gender??NULL;
        $customer->learning_locations = $request->learning_locations??NULL;
        $customer->remarks = $request->remarks??NULL;
        $customer->country_code_phone = $request->country_code_phone??NULL;
        $customer->mobile = $request->mobile??NULL;
        if (!is_null($request->password)) {
            $customer->password = Hash::make($request->password);
            $customer->user_pass = $request->password;
        }
        $customer->approve_status=$request->status??NULL;
        if($request->status==2)
        {
            $customer->instructor_id=null;
            $customer->learning_locations=null;
        }
        $customer->updated_at = Carbon::now();
        $customer->save();

        if($flag == 1){
            // User email for accout activation
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_USER_ACCOUNT_ACTIVATION'));
            // $admins = Admin::get();

            if ($email_template) {
                $data = [];
                $data['email_sender_name'] = systemSetting()->email_sender_name;
                $data['from_email'] = systemSetting()->from_email;
                $data['to_email'] = [$customer->email];
                $data['cc_to_email'] = [];
                $data['subject'] = $email_template->subject;
                $url = url('/login');
                $key = ['{{name}}','{{url}}','{{account_id}}','{{password}}'];
                $value = [$request->name,$url, $userAccountId, $userPassword];

                $newContents = str_replace($key, $value, $email_template->content);

                $data['contents'] = $newContents;
                try {
                    $mail = Mail::to($customer->email)->send(new EmailNotification($data));
                } catch (Exception $exception) {
                    dd($exception);
                }

            }
        }

        if(Auth::user()->user_type_id==5)
        {
            return redirect()->route('instructor.my-students')->with('success', __('constant.ACOUNT_UPDATED'));

        }
        else
        {
            return redirect()->route('external-profile.my-students')->with('success', __('constant.ACOUNT_UPDATED'));

        }


    }

    public function external_store(Request $request)
    {
        //        dd($request->all());
        $updateUserProfile = User::find($this->user->id);

        $messages = [
            'country_code.regex' => 'The Country code entered is invalid.',
        ];
        $request->validate([
            'name' => 'required',
            'in_charge_name' => 'required',
            'email' => 'required|unique:users,email,' . $updateUserProfile->id,
            'dob' => 'required',
            'country_code_phone' => 'required',
            'mobile' => 'required',
            'gender' => 'required',
            // 'instructor' => 'required',
            'country_code' => 'required',
        ], $messages); //dd($request);


        $dob = date('Y-m-d', strtotime($request->dob));
        //$updateUserProfile = new User();
        $updateUserProfile->name = $request->name;
        $updateUserProfile->in_charge_name = $request->in_charge_name;
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
        $updateUserProfile->mobile = $request->mobile;
        $updateUserProfile->gender = $request->gender;

        // $updateUserProfile->year_attained_qualified_instructor = $request->year_attained_qualified_instructor ?? NULL;
        // $updateUserProfile->year_attained_senior_instructor = $request->year_attained_senior_instructor ?? NULL;
        // $updateUserProfile->highest_abacus_grade = $request->highest_abacus_grade ?? NULL;
        // $updateUserProfile->highest_mental_grade = $request->highest_mental_grade ?? NULL;
        // $updateUserProfile->awards = $request->awards ?? NULL;

        $updateUserProfile->updated_at = Carbon::now();
        $updateUserProfile->save();

        if ($request->gender == 1) {
            $gender = 'Male';
        } else {
            $gender = 'Female';
        }

        // $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_INSTRUCTOR_STUDENT_PROFILE_UPDATE'));

        // if ($email_template) {
        //     if ($this->user) {
        //         $data = [];
        //         $data['email_sender_name'] = systemSetting()->email_sender_name;
        //         $data['from_email'] = systemSetting()->from_email;
        //         $data['to_email'] = [$this->user->email];
        //         $data['cc_to_email'] = [];
        //         $data['subject'] = $email_template->subject;

        //         $key = ['{{full_name}}', '{{email}}', '{{dob}}', '{{gender}}', '{{contact_number}}', '{{address}}', '{{country}}', '{{instructor}}'];
        //         $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $this->user->name];

        //         $newContents = str_replace($key, $value, $email_template->content);

        //         $data['contents'] = $newContents;
        //         try {
        //             $mail = Mail::to($this->user->email)->send(new EmailNotification($data));
        //         } catch (Exception $exception) {
        //             dd($exception);
        //         }
        //     }
        // }

        // //			Admin email for new student registration
        // $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_STUDENT_PROFILE_UPDATE'));
        // $admins = Admin::get();

        // if ($email_template) {
        //     $data = [];
        //     foreach ($admins as $admin) {
        //         $data['email_sender_name'] = systemSetting()->email_sender_name;
        //         $data['from_email'] = systemSetting()->from_email;
        //         $data['to_email'] = [$admin->email];
        //         $data['cc_to_email'] = [];
        //         $data['subject'] = $email_template->subject;

        //         $key = ['{{full_name}}', '{{email}}', '{{dob}}', '{{gender}}', '{{contact_number}}', '{{address}}', '{{country}}', '{{instructor}}'];
        //         $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $instructorDetail->name];

        //         $newContents = str_replace($key, $value, $email_template->content);

        //         $data['contents'] = $newContents;
        //         try {
        //             $mail = Mail::to($admin->email)->send(new EmailNotification($data));
        //         } catch (Exception $exception) {
        //             dd($exception);
        //         }
        //     }
        // }




        return redirect()->back()->with('success', __('constant.ACOUNT_UPDATED'));
    }
}
