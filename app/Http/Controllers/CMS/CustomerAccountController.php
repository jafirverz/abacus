<?php

namespace App\Http\Controllers\CMS;

use App\AchievementOther;
use App\Country;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use App\User;
use App\Admin;
use App\Level;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\CompetitionStudentResult;
use App\GradingStudentResults;
use App\LearningLocation;
use Illuminate\Support\Facades\DB;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use App\UserFeedback;
use Exception;
use Illuminate\Support\Facades\Mail;

class CustomerAccountController extends Controller
{
    use SystemSettingTrait, GetEmailTemplate;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.CUSTOMER_ACCOUNT');
        $this->module = 'CUSTOMER_ACCOUNT';
        $this->middleware('grant.permission:' . $this->module);
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
        if($this->user->admin_role==2)
        {
            $customer = User::orderBy('id','desc')->where('country_code',$this->user->country_id)->whereIn('user_type_id',[1,2,3,4])->orderBy('name','asc')->paginate($this->pagination);
            $total_count = User::orderBy('id','desc')->where('country_code',$this->user->country_id)->whereIn('user_type_id',[1,2,3,4])->get()->count();
            $country = Country::where('id',$this->user->country_id)->orderBy('country','asc')->get();
        }
        else
        {
            $customer = User::orderBy('id','desc')->whereIn('user_type_id',[1,2,3,4])->orderBy('name','asc')->paginate($this->pagination);
            $total_count = User::orderBy('id','desc')->whereIn('user_type_id',[1,2,3,4])->get()->count();
            $country = Country::orderBy('country','asc')->get();
        }
        return view('admin.account.customer.index', compact('title', 'customer','country','total_count'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $learningLocations = LearningLocation::orderBy('title','asc')->get();
        if(isset($_GET['user_type']) && $_GET['user_type']==4)
        {
            if($this->user->admin_role==2)
            {
            $instructors = User::where('country_code',$this->user->country_id)-where('user_type_id', 6)->orderBy('name','asc')->get();
            }
            else
            {
            $instructors = User::where('user_type_id', 6)->orderBy('name','asc')->get();
            }
        }
        else
        {
            if($this->user->admin_role==2)
            {
            $instructors = User::where('country_code',$this->user->country_id)->where('user_type_id', 5)->orderBy('name','asc')->get();
            }
            else
            {
            $instructors = User::where('user_type_id', 5)->orderBy('name','asc')->get();
            }
        }

        if($this->user->admin_role==2)
        {
            $country = Country::where('id',$this->user->country_id)->orderBy('phonecode', 'asc')->get();
        }
        else
        {
            $franchiseAdmin = Admin::where('admin_role', 2)->where('status', 1)->pluck('country_id')->toArray();
            $country = Country::whereIn('id', $franchiseAdmin)->orderBy('phonecode', 'asc')->get();
        }

        $levels = Level::where('status',1)->get();
        return view('admin.account.customer.create', compact('title','instructors','levels', 'country', 'learningLocations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $fields = [
            'email' =>  'required|email',
            'name' => 'required|string',
            'password'  =>  'required|min:8',
            'country_code' => 'required',
            'user_type_id' => 'required',
            'instructor_id' => 'required_if:user_type_id,1,2',
            'level' => 'required',
            'dob' => 'required',
            'country_code_phone' => 'required',
            'mobile' => 'required|integer|min:8',
            'gender' => 'required|string',
            'status' => 'required',
        ];

        $messages = [];
        $messages['email.required'] = 'The email address field is required.';
        $messages['name.required'] = 'The name field is required.';
        $messages['password.required'] = 'The password field is required.';
        $messages['email.email'] = 'The email address must be a valid email address.';
        $messages['country_code_phone.required'] = 'The country code is required.';
        $messages['country_code.required'] = 'The country code field is required.';
        $messages['user_type_id.required'] = 'User type field is required.';
        $messages['dob.required'] = 'Date of Birth is required.';
        $messages['mobile.required'] = 'The contact number field is required.';
        $messages['instructor_id.required_if'] = 'The instructor field is required.';
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
        $instructor = User::find($request->instructor_id);
        //dd( $instructor);
        $customer = new User();
        $customer->level_id = json_encode($request->level);
        $customer->name = $request->name;
        $customer->role_id = 3;
        $customer->account_id = $accountId;
        $customer->learning_locations = $request->learning_location??NULL;
        $customer->instructor_id = $request->instructor_id??NULL;
        $customer->user_type_id = $request->user_type_id??NULL;
        $customer->dob = date('Y-m-d', strtotime($request->dob))??NULL;
        $customer->email = $request->email??NULL;
        $customer->address = $request->address??NULL;
        $customer->gender = $request->gender??NULL;
        $customer->country_code = $request->country_code??NULL;
        $customer->country_code_phone = $request->country_code_phone??NULL;
        $customer->mobile = $request->mobile??NULL;
		$customer->approve_status = $request->status??NULL;
        if (!is_null($request->password)) {
            $customer->password = Hash::make($request->password);
            $customer->user_pass = $request->password;
        }
        $customer->created_at = Carbon::now();
        $customer->save();

        if($request->gender == 1){
            $gender = 'Male';
        }else{
            $gender = 'Female';
        }


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
                    $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, getCountry($request->country_code), $instructor->name];

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
                $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, getCountry($request->country_code), $instructor->name];

                $newContents = str_replace($key, $value, $email_template->content);

                $data['contents'] = $newContents;
                try {
                    $mail = Mail::to($instructor->email)->send(new EmailNotification($data));
                } catch (Exception $exception) {
                    dd($exception);
                }

        }

        return redirect()->route('customer-account.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $customer = User::findorfail($id);
        $instructors = User::findorfail($customer->instructor_id);
        // $actualCompetitionPaperSubted = CompetitionStudentResult::where('user_id', $id)->orderBy('id', 'desc')->get();
        // $gradingExamResult = GradingStudentResults::where('user_id', $id)->orderBy('id', 'desc')->get();
        // $merged = $actualCompetitionPaperSubted->merge($gradingExamResult)->sortByDesc('created_at')->paginate(10);

        $actualCompetitionPaperSubted = CompetitionStudentResult::where('user_id', $id)->orderBy('total_marks', 'desc')->get();
        //dd($actualCompetitionPaperSubted);
        $gradingExamResult = GradingStudentResults::where('user_id', $id)->orderBy('total_marks', 'desc')->get();

        $achievementsOther = AchievementOther::where('user_id', $id)->orderBy('total_marks', 'desc')->get();

        // $merged = $actualCompetitionPaperSubted->merge($gradingExamResult)->sortByDesc('total_marks')->paginate(10);

        // $merged = $merged->merge($achievementsOther)->sortByDesc('total_marks')->paginate(10);
        $collection = collect([$actualCompetitionPaperSubted, $gradingExamResult, $achievementsOther]);

        $merged = $collection->collapse();
        $merged = $merged->paginate(10);

        return view('admin.account.customer.show', compact('title', 'customer','instructors','merged'));
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
        $customer = User::findorfail($id);
        $learningLocations = LearningLocation::orderBy('title','asc')->get();
        if($this->user->admin_role==2)
        {
            $country = Country::where('id',$this->user->country_id)->orderBy('phonecode', 'asc')->get();
        }
        else
        {
            $franchiseAdmin = Admin::where('admin_role', 2)->where('status', 1)->pluck('country_id')->toArray();
            $country = Country::whereIn('id', $franchiseAdmin)->orderBy('phonecode', 'asc')->get();
        }

        if(isset($customer->user_type_id) && $customer->user_type_id==4)
        {
            if($this->user->admin_role==2)
            {
            $instructors = User::where('country_code',$this->user->country_id)-where('user_type_id', 6)->orderBy('name','asc')->get();
            }
            else
            {
            $instructors = User::where('user_type_id', 6)->orderBy('name','asc')->get();
            }
        }
        else
        {
            if($this->user->admin_role==2)
            {
            $instructors = User::where('country_code',$this->user->country_id)->where('user_type_id', 5)->orderBy('name','asc')->get();
            }
            else
            {
            $instructors = User::where('user_type_id', 5)->orderBy('name','asc')->get();
            }
        }

        $levels = Level::where('status',1)->get();
        return view('admin.account.customer.edit', compact('title', 'customer','instructors','levels', 'country', 'learningLocations'));
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
        // dd(url('/login'));
        $fields = [
            'email' =>  'required|email',
            'name' => 'required|string',
            'password'  =>  'nullable|min:8',
            'country_code' => 'required',
            'level' => 'required',
            'dob' => 'required',
            'country_code_phone' => 'required',
            'mobile' => 'required|integer|min:8',
            'gender' => 'required|string',
            'status' => 'required',
        ];
        $messages = [];
        $messages['email.required'] = 'The email address field is required.';
        $messages['name.required'] = 'The name field is required.';
        $messages['password.required'] = 'The password field is required.';
        $messages['email.email'] = 'The email address must be a valid email address.';
        $messages['country_code_phone.required'] = 'The country code is required.';
        $messages['country_code.required'] = 'The country code field is required.';
        $messages['user_type_id.required'] = 'User type field is required.';
        $messages['dob.required'] = 'Date of Birth is required.';
        $messages['mobile.required'] = 'The contact number field is required.';
        $messages['mobile.min'] = 'The contact number must be at least 8 characters.';
        $request->validate($fields, $messages);
        $dob = date('Y-m-d', strtotime($request->dob));
            if($request->gender == 1){
            $gender = 'Male';
            }else{
            $gender = 'Female';
            }
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


        if($request->instructor_id!='' && $request->status==1 && $customer->approve_status==2)
        {
          // REACTIVATED EMAIL
          $instructor = User::find($request->instructor_id);

           //			Admin email for new student registration
                    $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_STUDENT_REACTIVATED'));
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
                            $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, getCountry($request->country_code), $instructor->name];

                            $newContents = str_replace($key, $value, $email_template->content);

                            $data['contents'] = $newContents;
                            //dd($data);
                            try {
                                $mail = Mail::to($admin->email)->send(new EmailNotification($data));
                                //$mail = Mail::to('jafir.verz@gmail.com')->send(new EmailNotification($data));
                            } catch (Exception $exception) {
                                dd($exception);
                            }
                        }

                    }

                    //Instructor email for new student registration
                $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_INSTRUCTOR_STUDENT_REACTIVATED'));

                if ($email_template) {
                    $data = [];
                        $data['email_sender_name'] = systemSetting()->email_sender_name;
                        $data['from_email'] = systemSetting()->from_email;
                        $data['to_email'] = [$instructor->email];
                        $data['cc_to_email'] = [];
                        $data['subject'] = $email_template->subject;

                        $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{country}}','{{instructor}}'];
                        $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, getCountry($request->country_code), $instructor->name];

                        $newContents = str_replace($key, $value, $email_template->content);

                        $data['contents'] = $newContents;

                        //dd($instructor->email);
                        try {
                            $mail = Mail::to($instructor->email)->send(new EmailNotification($data));
                        } catch (Exception $exception) {
                            dd($exception);
                        }

                }
        }
        $customer->name = $request->name;
        $customer->level_id = json_encode($request->level);
        $customer->instructor_id = $request->instructor_id??NULL;
        $customer->dob = date('Y-m-d', strtotime($request->dob))??NULL;
        $customer->email = $request->email??NULL;
        $customer->address = $request->address??NULL;
        $customer->learning_locations = $request->learning_location??NULL;
        $customer->gender = $request->gender??NULL;
        //$customer->user_type_id = $request->user_type_id??NULL;
        $customer->country_code = $request->country_code??NULL;
        $customer->country_code_phone = $request->country_code_phone??NULL;
        $customer->mobile = $request->mobile??NULL;
		$customer->approve_status = $request->status??NULL;
        if (!is_null($request->password)) {
            $customer->password = Hash::make($request->password);
            $customer->user_pass = $request->password;
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

        return redirect()->route('customer-account.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $ids = explode(',', $request->multiple_delete);
        //User::destroy($id);
        foreach($ids as $id)
        {
            if($this->user->admin_role==1)
            {
                try {
                    $customer = User::find($id);
                    $customer->role_id = NULL;
                    $customer->save();
                    User::destroy($id);
                } catch (Exception $exception) {
                    //return back()->withError($exception->getMessage())->withInput();
                    //dd($exception->getMessage());
                    return redirect()->back()->with('error', 'Student cannot be deleted');
                }
                
            }
            else
            {
                $customer = User::find($id);
                $customer->approve_status = NULL;
                $customer->save();
            }
        }


        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        if($this->user->admin_role==2)
        {
            $country = Country::where('id',$this->user->country_id)->orderBy('phonecode', 'asc')->get();
            $customer = User::join('user_types','users.user_type_id','user_types.id')->where('country_code',$this->user->country_id)->whereIn('user_type_id',[1,2,3,4])->select('users.*')->search($request)->orderBy('name','asc')->paginate($this->pagination);
            $total_count = User::orderBy('id','desc')->where('country_code',$this->user->country_id)->whereIn('user_type_id',[1,2,3,4])->get()->count();
        }
        else
        {
            $country = Country::orderBy('phonecode', 'asc')->get();
            $customer = User::join('user_types','users.user_type_id','user_types.id')->whereIn('user_type_id',[1,2,3,4])->select('users.*')->search($request)->orderBy('name','asc')->paginate($this->pagination);
            $total_count = User::orderBy('id','desc')->whereIn('user_type_id',[1,2,3,4])->get()->count();
        }





        if ($search_term) {
            $customer->appends('search', $search_term);
        }
        //dd($customer);
        return view('admin.account.customer.index', compact('title', 'customer','country','total_count'));
    }



}
