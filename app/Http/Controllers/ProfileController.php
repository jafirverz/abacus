<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Announcement;
use App\InstructorCalendar;
use App\Grade;
use App\GradingExam;
use App\GradingPaper;
use App\GradingExamList;
use App\GradingStudent;
use App\TeachingMaterials;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use App\TestManagement;
use App\Survey;
use App\User;
use App\Allocation;
use App\Admin;
use App\CategoryCompetition;
use App\Competition;
use App\CompetitionCategory;
use App\CompetitionPaperSubmitted;
use App\CompetitionStudent;
use App\Country;
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
use App\Level;
use App\TempCart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use Cart;

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
	public function instructor()
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
		//dd($user);
		$page = get_page_by_slug($slug);

		if (!$page) {
			return abort(404);
		}


		return view('account.instructor-profile', compact("page", "user"));
	}

    public function instructor_overview()
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
		$announcements = Announcement::where('teacher_id', $user->id)->get();
        $calendars = InstructorCalendar::where('teacher_id', $user->id)->get();
		$page = get_page_by_slug($slug);

		if (!$page) {
			return abort(404);
		}

		//dd($user);

		return view('account.instructor-overview', compact("page", "user","announcements","calendars"));
	}

    public function grading_examination()
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
		$grading = GradingStudent::where('instructor_id',$user->id)->paginate($this->pagination);;
		$page = get_page_by_slug($slug);

		if (!$page) {
			return abort(404);
		}

		//dd($user);

		return view('account.grading-examination', compact("page", "user","grading"));
	}

    public function register_grading_examination()
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
        $allocated_user = GradingStudent::where('instructor_id',$user->id)->select('user_id')->get();
        $allocate_user_array=[];
        foreach($allocated_user->toArray() as $value)
        {
            $allocate_user_array[]=$value['user_id'];
        }
        $students = User::where('user_type_id',1)->whereNotIn('id',$allocate_user_array)->orderBy('id','desc')->get();
        $mental_grades = Grade::where('grade_type_id', 1)->orderBy('id','desc')->get();
        $abacus_grades = Grade::where('grade_type_id', 2)->orderBy('id','desc')->get();
        $gradingExam = GradingExam::where('status', 1)->get();
		$page = get_page_by_slug($slug);

		if (!$page) {
			return abort(404);
		}

		//dd($user);

		return view('account.register-grading-examination', compact("page", "user","students","mental_grades","abacus_grades","gradingExam"));
	}

    public function edit_grading($id)
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
        $students = User::where('user_type_id',1)->orderBy('id','desc')->get();
        $mental_grades = Grade::where('grade_type_id', 1)->orderBy('id','desc')->get();
        $abacus_grades = Grade::where('grade_type_id', 2)->orderBy('id','desc')->get();
        $gradingExam = GradingExam::where('status', 1)->get();
		$page = get_page_by_slug($slug);
        $grading=GradingStudent::where('id', $id)->first();

		if (!$page) {
			return abort(404);
		}

		//dd($user);

		return view('account.edit-grading-examination', compact("page", "user","students","mental_grades","abacus_grades","gradingExam","grading"));
	}

    public function delete_grading($id)
    {
        GradingStudent::where('id', $id)->delete();
        return redirect()->back()->with('success', __('constant.ALLOCATE_DELETED'));
    }

    public function allocation()
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
		$test = TestManagement::orderBy('id', 'asc')->paginate($this->pagination);
        $survey = Survey::where('status',1)->orderBy('id', 'asc')->paginate($this->pagination);
		$page = get_page_by_slug($slug);

		if (!$page) {
			return abort(404);
		}

		//dd($user);

		return view('account.allocation', compact("page", "user","test","survey"));
	}

    public function allocation_test($test_id)
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
        $allocated_user = Allocation::where('type',1)->where('assigned_id',$test_id)->select('student_id')->get();
        $allocate_user_array=[];
        foreach($allocated_user->toArray() as $value)
        {
            $allocate_user_array[]=$value['student_id'];
        }
        $students = User::where('user_type_id','!=', 5)->whereNotIn('id',$allocate_user_array)->orderBy('id','desc')->get();

        $test = TestManagement::findorfail($test_id);
        $list = Allocation::where('allocations.assigned_id',$test_id)->where('allocations.type',1)->paginate($this->pagination);
		$page = get_page_by_slug($slug);

		if (!$page) {
			return abort(404);
		}

		//dd($user);

		return view('account.allocation-test', compact("page", "user","test_id","test","list","students"));
	}

    public function allocation_survey($survey_id)
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
        $allocated_user = Allocation::where('type',2)->where('assigned_id',$survey_id)->select('student_id')->get();
        $allocate_user_array=[];
        foreach($allocated_user->toArray() as $value)
        {
            $allocate_user_array[]=$value['student_id'];
        }
        $students = User::where('user_type_id','!=', 5)->whereNotIn('id',$allocate_user_array)->orderBy('id','desc')->get();
		$survey = Survey::findorfail($survey_id);
		$page = get_page_by_slug($slug);
        $list = Allocation::where('allocations.assigned_id',$survey_id)->where('allocations.type',2)->paginate($this->pagination);
		if (!$page) {
			return abort(404);
		}

		//dd($user);

		return view('account.allocation-survey', compact("page", "user","survey","list","students","survey_id"));
	}

    public function grading_overview()
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
        $today=date('Y-m-d');
		$gradingExam = GradingExam::where('status', 1)->whereDate('exam_date','=',$today)->first();
        if (!$gradingExam) {
			return abort(404);
		}
        $gradingExamList = GradingExamList::where('grading_exams_id', $gradingExam->id)->get();
		$page = get_page_by_slug($slug);
        //dd($gradingExamList);
		if (!$page) {
			return abort(404);
		}

		//dd($user);

		return view('account.grading-overview', compact("page", "gradingExam","gradingExamList"));
	}

    public function grading_paper($grading_exam_id,$listing_id,$paper_id)
    {
        $paper=GradingPaper::find($paper_id);
        $gradingExam = GradingExam::find($grading_exam_id);
        $qId=$paper->question_type;
        if(empty($qId)){
            return abort(404);
        }

        if($qId == 5){
            return view('account.gradingMultipleDivision', compact("paper","grading_exam_id","listing_id","gradingExam"));
        }
        elseif($qId == 6){
            return view('account.gradingChallenge', compact("paper","grading_exam_id","listing_id","gradingExam"));
        }
        elseif($qId == 8){
            return view('account.gradingAbacus', compact("paper","grading_exam_id","listing_id","gradingExam"));
        }
        elseif($qId == 7){
            return view('account.gradingMix', compact("paper","grading_exam_id","listing_id","gradingExam"));
        }
        elseif($qId == 4){
            return view('account.gradingAddSubQuestion', compact("paper","grading_exam_id","listing_id","gradingExam"));
        }
        elseif($qId == 3){
            return view('account.gradingNumber', compact("paper","grading_exam_id","listing_id","gradingExam"));
        }
        elseif($qId == 1){
            return view('account.gradingAudio', compact("paper","grading_exam_id","listing_id","gradingExam"));
        }
        elseif($qId == 2){
            return view('account.gradingAudio', compact("paper","grading_exam_id","listing_id","gradingExam"));
        }
    }

    public function competition_overview()
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
		$page = get_page_by_slug($slug);
		if (!$page) {
			return abort(404);
		}

        //$competition = Competition::find($id);
        //$competitionCategory = CompetitionCategory::get();
        $userType = array(1,2,3,4);
        //$students = User::whereIn('user_type_id', $userType)->where('approve_status', 1)->get();
        //$categoryCompetition = CategoryCompetition::where('competition_id', $id)->pluck('category_id')->toArray();
        $competetion = Competition::join('competition_students','competition_students.competition_controller_id','competition_controllers.id')->select('competition_controllers.*')->where('competition_students.user_id', $user->id)->first();

		//dd($competetion);

		return view('account.competition-overview', compact("page", 'competetion'));
	}


    public function index()
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
		//dd($user);
		$page = get_page_by_slug($slug);
        $instructors = User::where('user_type_id', 5)->get();

		if (!$page) {
			return abort(404);
		}

		//dd($user);
		$country = Country::orderBy('country', 'asc')->get();
		return view('account.my-profile', compact("page", "user", "instructors", 'country'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
	}


    public function allocation_store(Request $request,$id)
	{
        //dd($request->all());
        $users = User::find($this->user->id);

        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);


        $allocation = new Allocation();
        $allocation->student_id  = $request->student_id ?? NULL;
        $allocation->assigned_by  = $this->user->id; // Instructor
        $allocation->assigned_id  = $id;   //Test /Survey
        $allocation->start_date  = $request->start_date ?? NULL;
        $allocation->end_date  = $request->end_date ?? NULL;
        $allocation->type  = 1;
        $allocation->save();

		return redirect()->back()->with('success', __('constant.ALLOCATE_UPDATED'));
	}

    public function grading_register_store(Request $request)
	{
        //dd($request->all());
        $users = User::find($this->user->id);

        $request->validate([
            'user_id' => 'required',
            'mental_grade' => 'required',
            'abacus_grade' => 'required',
            'grading_exam_id' => 'required',
        ]);


        $gradingStudent = new GradingStudent();
        $gradingStudent->user_id   = $request->user_id ?? NULL;
        $gradingStudent->grading_exam_id   = $request->grading_exam_id ?? NULL;
        $gradingStudent->instructor_id  = $this->user->id;   //Test /Survey
        $gradingStudent->mental_grade  = $request->mental_grade ?? NULL;
        $gradingStudent->abacus_grade  = $request->abacus_grade ?? NULL;
        $gradingStudent->remarks  = $request->remarks ?? NULL;
        $gradingStudent->save();

		return redirect()->route('grading-examination')->with('success', __('constant.GRADING_UPDATED'));
	}

    public function update_grading(Request $request,$id)
	{
        //dd($request->all());
        $users = User::find($this->user->id);

        $request->validate([
            'mental_grade' => 'required',
            'abacus_grade' => 'required',
        ]);


        $gradingStudent = GradingStudent::find($id);
        $gradingStudent->mental_grade  = $request->mental_grade ?? NULL;
        $gradingStudent->abacus_grade  = $request->abacus_grade ?? NULL;
        $gradingStudent->remarks  = $request->remarks ?? NULL;
        $gradingStudent->save();

		return redirect()->route('grading-examination')->with('success', __('constant.GRADING_UPDATED'));
	}

    public function cal_store(Request $request)
	{
        //dd($request->all());
        $users = User::find($this->user->id);

        $request->validate([
            'full_name' => 'required',
            'start_date' => 'date|required',
            'start_time' => 'required',
            'note' => 'required',
            'reminder' => 'required',
        ]);


        $instructorCalendar = new InstructorCalendar();
        $instructorCalendar->full_name  = $request->full_name ?? NULL;
        $instructorCalendar->teacher_id  = $this->user->id;
        $instructorCalendar->start_date  = $request->start_date ?? NULL;
        $instructorCalendar->start_time  = $request->start_time ?? NULL;
        $instructorCalendar->note  = $request->note ?? NULL;
        $instructorCalendar->reminder  = 1;
        $instructorCalendar->save();

		return redirect()->back()->with('success', __('constant.ALLOCATE_UPDATED'));
	}



    public function survey_store(Request $request,$id)
	{
        //dd($request->all());
        $users = User::find($this->user->id);

        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);


        $allocation = new Allocation();
        $allocation->student_id  = $request->student_id ?? NULL;
        $allocation->assigned_id  = $id;
        $allocation->assigned_by  = $this->user->id;
        $allocation->start_date  = $request->start_date ?? NULL;
        $allocation->end_date  = $request->end_date ?? NULL;
        $allocation->type  = 2;
        $allocation->save();

		return redirect()->back()->with('success', __('constant.SURVEY_UPDATED'));
	}


    public function allocation_test_delete($id)
    {
        Allocation::where('id', $id)->delete();
        return redirect()->back()->with('success', __('constant.ALLOCATE_DELETED'));
    }

    public function allocation_survey_delete($id)
    {
        Allocation::where('id', $id)->delete();
        return redirect()->back()->with('success', __('constant.ALLOCATE_DELETED'));
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
                    // 'instructor' => 'required',
                    'country_code' => 'required',
//                'password'  =>  'nullable|min:8',
//			'country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',


                ], $messages); //dd($request);
            }
//            $checkPendingRequest = UserProfileUpdate::where('user_id', $users->id)->where('approve_status', '!=', 1)->first();
//            if($checkPendingRequest){
//                //throw ValidationException::withMessages(['Profile Update request already pending']);
//                return back()->withErrors('Profile Update request already pending');
//            }
						$var = $request->dob;
						$date = str_replace('/', '-', $var);
						$dob = date('Y-m-d', strtotime($date));
            // $dob = date('Y-m-d', strtotime($request->dob));
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
            $updateUserProfile->instructor_id  = $request->oldInstructorId;
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

            if($request->gender == 1){
                $gender = 'Male';
            }else{
                $gender = 'Female';
            }

            $instructorDetail = User::where('id', $request->oldInstructorId)->first();
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_INSTRUCTOR_STUDENT_PROFILE_UPDATE'));

            if ($email_template) {
                if($instructorDetail){
                    $data = [];
                    $data['email_sender_name'] = systemSetting()->email_sender_name;
                    $data['from_email'] = systemSetting()->from_email;
                    $data['to_email'] = [$instructorDetail->email];
                    $data['cc_to_email'] = [];
                    $data['subject'] = $email_template->subject;

                    $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{country}}','{{instructor}}'];
                    $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $instructorDetail->name];

                    $newContents = str_replace($key, $value, $email_template->content);

                    $data['contents'] = $newContents;
                    try {
                        $mail = Mail::to($instructorDetail->email)->send(new EmailNotification($data));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }


            }
            //			Admin email for new student registration
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_STUDENT_PROFILE_UPDATE'));
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
                    $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $instructorDetail->name];

                    $newContents = str_replace($key, $value, $email_template->content);

                    $data['contents'] = $newContents;
                    try {
                        $mail = Mail::to($admin->email)->send(new EmailNotification($data));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }

            }
        }



		return redirect()->back()->with('success', __('constant.ACOUNT_UPDATED'));
	}


    public function teaching_materials()
    {
        $title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
		//dd($user);
		$page = get_page_by_slug($slug);

		if (!$page) {
			return abort(404);
		}

        $materials = TeachingMaterials::orderBy('id', 'asc')->paginate($this->pagination);
		return view('account.teaching-materials', compact("page", "user","materials"));
    }



    public function instructor_store(Request $request)
	{
//        dd($request->all());
        $users = User::find($this->user->id);

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
                ], $messages); //dd($request);
            }


            $dob = date('Y-m-d', strtotime($request->dob));
            $updateUserProfile = new User();
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
            $updateUserProfile->mobile = $request->mobile;
            $updateUserProfile->gender = $request->gender;

            $updateUserProfile->year_attained_qualified_instructor = $request->year_attained_qualified_instructor??NULL;
            $updateUserProfile->year_attained_senior_instructor = $request->year_attained_senior_instructor??NULL;
            $updateUserProfile->highest_abacus_grade = $request->highest_abacus_grade??NULL;
            $updateUserProfile->highest_mental_grade = $request->highest_mental_grade??NULL;
            $updateUserProfile->awards = $request->awards??NULL;

            $updateUserProfile->updated_at = Carbon::now();
            $updateUserProfile->save();

            if($request->gender == 1){
                $gender = 'Male';
            }else{
                $gender = 'Female';
            }

            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_INSTRUCTOR_STUDENT_PROFILE_UPDATE'));

            if ($email_template) {
                if($this->user){
                    $data = [];
                    $data['email_sender_name'] = systemSetting()->email_sender_name;
                    $data['from_email'] = systemSetting()->from_email;
                    $data['to_email'] = [$this->user->email];
                    $data['cc_to_email'] = [];
                    $data['subject'] = $email_template->subject;

                    $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{country}}','{{instructor}}'];
                    $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $this->user->name];

                    $newContents = str_replace($key, $value, $email_template->content);

                    $data['contents'] = $newContents;
                    try {
                        $mail = Mail::to($this->user->email)->send(new EmailNotification($data));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }


            }

            //			Admin email for new student registration
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_STUDENT_PROFILE_UPDATE'));
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
                    $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $instructorDetail->name];

                    $newContents = str_replace($key, $value, $email_template->content);

                    $data['contents'] = $newContents;
                    try {
                        $mail = Mail::to($admin->email)->send(new EmailNotification($data));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }

            }




		return redirect()->back()->with('success', __('constant.ACOUNT_UPDATED'));
	}

	public function studentlist(){
		$instructor_id = User::where('id', Auth::user()->id)->first();
		$students = User::where('instructor_id', $instructor_id->id)->paginate(5);
		$levels = Level::get();
		return view('account.teaching-students', compact('students', 'levels'));
	}

	public function competition()
	{
		$instructor_id = User::where('id', Auth::user()->id)->first();
		$competition = Competition::where('status', 1)->orderBy('id', 'desc')->first();
		$students = User::has('userlist')->where('instructor_id', $instructor_id->id)->paginate(5);
		$compStudents = CompetitionStudent::has('userlist')->where('competition_controller_id', $competition->id)->where('instructor_id', $instructor_id->id)->paginate(5);
		return view('account.competition-students', compact('competition', 'compStudents', 'competition'));
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

	public function achievements(){
		$userId = Auth::user()->id;
		$actualCompetitionPaperSubted = CompetitionPaperSubmitted::where('user_id', $userId)->where('paper_type', 'actual')->groupBy('category_id')->groupBy('competition_id')->get();
		//dd($actualCompetitionPaperSubted);
		return view("account.achievements", compact('actualCompetitionPaperSubted'));
		//$competitionId =
	}

	public function cart(Request $request){
		$levelId = $request->levelId;
		$level = Level::where('id', $levelId)->first();
		$levelName = $level->title;
		$levelDescription = $level->description;
		$levelImage = $level->image;
		$premium_amount = $level->premium_amount;
		$premium_months = $level->premium_months;
		//$levelDetails[$levelId] = array();
		$levelDetails = array();
		$levelDetails['type'] = 'level';
		$levelDetails['id'] = $levelId;
		$levelDetails['name'] = $levelName;
		$levelDetails['description'] = $levelDescription;
		$levelDetails['image'] = $levelImage;
		$levelDetails['amount'] = $premium_amount;
		$levelDetails['months'] = $premium_months;

		$tempCart = new TempCart();
		$jsonEncode = json_encode($levelDetails);
		$tempCart->user_id = Auth::user()->id;
		$tempCart->type = $request->type;
		$tempCart->cart = $jsonEncode;
		$tempCart->save();

		$cartDetails = TempCart::where('user_id', Auth::user()->id)->get();

		return view('account.cart', compact("cartDetails"));
	}

	public function cartList($id = null){
		$cartDetailsDelete = TempCart::where('user_id', Auth::user()->id)->where('id', $id)->first();
		if($cartDetailsDelete){
			$cartDetailsDelete->delete();
			return redirect()->to('/cart');
		}
		$cartDetails = TempCart::where('user_id', Auth::user()->id)->get();

		return view('account.cart', compact("cartDetails"));
	}

	public function cartListDelete(){
		$cartDetails = TempCart::where('user_id', Auth::user()->id)->get();
		foreach($cartDetails as $cart){
			$cart->delete();
		}
		return redirect()->to('/cart');
		//return view('account.cart', compact("cartDetails"));
	}

	public function checkout(){
		$cartDetails = TempCart::where('user_id', Auth::user()->id)->get();

		return view('account.checkout', compact("cartDetails"));
	}

	
}
