<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Announcement;
use App\InstructorCalendar;
use App\Grade;
use App\GradingExam;
use App\GradingPaper;
use App\GradingExamList;
use App\GradingListingDetail;
use App\GradingStudent;
use App\LearningLocation;
use App\TeachingMaterials;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use App\TestManagement;
use App\TestQuestionSubmission;
use App\TestPaperQuestionDetail;
use App\TestSubmission;
use App\Survey;
use App\User;
use App\Allocation;
use App\TestPaperDetail;
use App\Admin;
use App\CategoryCompetition;
use App\Competition;
use App\CompetitionCategory;
use App\CompetitionPaper;
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
use App\Order;
use App\OrderDetail;
use App\TempCart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use Cart;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Illuminate\Support\Facades\URL;

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
		$grading = GradingStudent::where('instructor_id',$user->id)->paginate($this->pagination);
		$page = get_page_by_slug($slug);

		if (!$page) {
			return abort(404);
		}
        $gradingExam = GradingExam::where('status', 1)->orderBy('id','desc')->first();
		//dd($user);

		return view('account.grading-examination', compact("page", "user","grading","gradingExam"));
	}

    public function register_grading_examination($id)
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
        $gradingExam = GradingExam::find($id);
        $locations = LearningLocation::orderBy('id','desc')->get();
        //dd($gradingExam);
		$page = get_page_by_slug($slug);

		if (!$page) {
			return abort(404);
		}

		//dd($user);

		return view('account.register-grading-examination', compact("page", "user","students","locations","mental_grades","abacus_grades","gradingExam"));
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
        $locations = LearningLocation::orderBy('id','desc')->get();
		$page = get_page_by_slug($slug);
        $grading=GradingStudent::where('id', $id)->first();

		if (!$page) {
			return abort(404);
		}

		//dd($user);

		return view('account.edit-grading-examination', compact("page", "user","students","mental_grades","abacus_grades","gradingExam","locations","grading"));
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

    public function grading_overview($id)
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
        $today=date('Y-m-d');
		$gradingExam = GradingExam::find($id);
		$gradingStu = GradingStudent::where('grading_exam_id',$id)->where('user_id',$user->id)->first();

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

		return view('account.grading-overview', compact("page", "gradingExam","gradingExamList","gradingStu"));
	}

    public function detail_test($id){
        $test = TestManagement::find($id);
        $all_paper_detail=TestPaperDetail::where('paper_id',$test->paper->id)->get();
        $qId=$test->paper->question_template_id;
        //dd($qId);
        if($qId == 5){
            return view('account.testMultipleDivision', compact("test","all_paper_detail"));
        }
        elseif($qId == 6){
            return view('account.testChallenge', compact("test","all_paper_detail"));
        }
        elseif($qId == 8){
            return view('account.testAbacus', compact("test","all_paper_detail"));
        }
        elseif($qId == 7){
            return view('account.testMix', compact("test","all_paper_detail"));
        }
        elseif($qId == 4){
            return view('account.testAddSubQuestion', compact("test","all_paper_detail"));
        }
        elseif($qId == 3){
            return view('account.testNumber', compact("test","all_paper_detail"));
        }
        elseif($qId == 1){
            return view('account.testAudio', compact("test","all_paper_detail"));
        }
        elseif($qId == 2){
            return view('account.testVideo', compact("test","all_paper_detail"));
        }
        //return view('account.online-my-course-detail', compact('course'));
    }

    public function submit_test(Request $request){

        $test_id = $request->test_id;
        $questionTypeId = $request->question_type;
        $userId = Auth::user()->id;
        $questTem = array(1,2,3,4,5,6,7,8);
        $resultpage = array(1,2,3,4,5,6,7,8);

        foreach($request->test_paper_question_id as $test_paper_question_id)
        {
            if(in_array($questionTypeId, $questTem)){
                $courseSub = new TestSubmission();
                $courseSub->test_paper_question_id   = $test_paper_question_id;
                $courseSub->test_id  = $test_id;
                $courseSub->question_template_id = $questionTypeId;
                $courseSub->user_id = $userId;
                $courseSub->save();
                $totalMarks = 0;
                $userMarks = 0;

                foreach($request->answer as $key=>$value){
                    $quesSub = new TestQuestionSubmission();
                    $testPaperQuestion = TestPaperQuestionDetail::where('id', $key)->first();
                    $quesSub->test_submitted_id    = $courseSub->id;
                    $quesSub->question_id = $key;
                    $quesSub->question_answer = $testPaperQuestion->answer;
                    //dd($testPaperQuestion);
                    $quesSub->user_answer = $value;
                    $quesSub->marks = $testPaperQuestion->marks;
                    if($value == $testPaperQuestion->answer){
                        $quesSub->user_marks = $testPaperQuestion->marks;
                        $userMarks+= $testPaperQuestion->marks;
                    }else{
                        $quesSub->user_marks = null;
                    }
                    $totalMarks+= $testPaperQuestion->marks;
                    $quesSub->save();
                }
                $saveResult = TestSubmission::where('id', $courseSub->id)->first();
                $saveResult->total_marks = $totalMarks;
                $saveResult->user_marks = $userMarks;
                $saveResult->save();
            }
        }
        if(in_array($questionTypeId, $resultpage)){
            return view('result-course', compact('totalMarks', 'userMarks'));
        }


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
            'learning_location' => 'required',
        ]);


        $gradingStudent = new GradingStudent();
        $gradingStudent->user_id   = $request->user_id ?? NULL;
        $gradingStudent->grading_exam_id   = $request->grading_exam_id ?? NULL;
        $gradingStudent->instructor_id  = $this->user->id;
        $gradingStudent->mental_grade  = $request->mental_grade ?? NULL;
        $gradingStudent->learning_location  = $request->learning_location ?? NULL;
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
            'learning_location' => 'required',
        ]);


        $gradingStudent = GradingStudent::find($id);
        $gradingStudent->mental_grade  = $request->mental_grade ?? NULL;
        $gradingStudent->abacus_grade  = $request->abacus_grade ?? NULL;
        $gradingStudent->learning_location  = $request->learning_location ?? NULL;
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

        if(isset($_GET['keyword']) && $_GET['keyword']!='')
        {
            $materials = TeachingMaterials::where('title','like','%' .$_GET['keyword'].'%')->orderBy('id', 'asc')->paginate($this->pagination);
        }
        else if(isset($_GET['file_type']) && $_GET['file_type']!='')
        {

            $materials = TeachingMaterials::where('file_type',$_GET['file_type'])->orderBy('id', 'asc')->paginate($this->pagination);
            //dd($materials);
        }
        else
        {
            $materials = TeachingMaterials::orderBy('id', 'asc')->paginate($this->pagination);
        }

		return view('account.teaching-materials', compact("page", "user","materials"));
    }



    public function instructor_store(Request $request)
	{
              //dd($request->all());
        $users = User::find($this->user->id);
        $instructorDetail = User::where('id', $this->user->id)->first();
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
            $updateUserProfile = User::find($this->user->id);
            //$updateUserProfile->user_id  = $users->id;
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
                        //$mail = Mail::to($this->user->email)->send(new EmailNotification($data));
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
                       // $mail = Mail::to($admin->email)->send(new EmailNotification($data));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }

            }

		return redirect()->back()->with('success', __('constant.PROFILE_UPDATED'));
	}

	public function studentlist(){
		$instructor_id = User::where('id', Auth::user()->id)->first();
		$students = User::where('instructor_id', $instructor_id->id)->paginate(5);
		$levels = Level::get();
		return view('account.teaching-students', compact('students', 'levels'));
    }

    public function add_material()
    {
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('account.add-material', compact('instructors'));
    }

    public function store_add_material(Request $request)
    {
        $request->validate([
            'title'  =>  'required',
            'uploaded_files'  =>  'required|file|mimes:jpeg,jpg,png,gif,doc,docx,pdf',
        ]);

        $material = new TeachingMaterials;
        $material->title = $request->title ?? '';
        if ($request->hasFile('uploaded_files')) {
            $material->uploaded_files=$uploaded_file = uploadPicture($request->file('uploaded_files'), __('constant.TEACHING_MATERIALS'));
            $ext = pathinfo($uploaded_file, PATHINFO_EXTENSION);
            $material->file_type = $ext;
        }
        $material->description = $request->description ?? '';
        $material->teacher_id = $this->user->id;
        $material->created_at = Carbon::now();
        $material->save();

        return redirect()->route('teaching-materials')->with('success', __('constant.ACOUNT_CREATED'));
    }

    public function add_students()
    {
        $country = Country::orderBy('phonecode')->get();
        $levels = Level::get();
        return view('account.external-add-students', compact('levels', 'country'));
    }

    public function edit_students($id)
    {
        $country = Country::orderBy('phonecode')->get();
        $levels = Level::get();
        $customer = User::find($id);
        return view('account.external-edit-students', compact('levels', 'country','customer'));
    }


    public function store_add_students(Request $request)
    {
        $fields = [
            'email' =>  'required|email|unique:users,email',
            'name' => 'required|string',
            'password'  =>  'required|min:8',
            'country_code' => 'required',
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
        $messages['country_code.required'] = 'The country code field is required.';
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
        $customer->level_id = json_encode($request->level);
        $customer->name = $request->name;
        $customer->account_id = $accountId;
        $customer->user_type_id = 7;
        $customer->instructor_id = $this->user->id;
        $customer->dob = date('Y-m-d', strtotime($request->dob))??NULL;
        $customer->email = $request->email??NULL;
        $customer->address = $request->address??NULL;
        $customer->gender = $request->gender??NULL;
        $customer->country_code = $request->country_code??NULL;
        $customer->country_code_phone = $request->country_code_phone??NULL;
        $customer->mobile = $request->mobile??NULL;
		$customer->approve_status = 1;
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

        return redirect()->route('external-profile.my-students')->with('success', __('constant.ACOUNT_CREATED'));
    }

    public function delete_students($id)
    {
        User::where('id', $id)->delete();
        return redirect()->back()->with('success', __('constant.ALLOCATE_DELETED'));
    }

    public function update_students (Request $request,$id)
    {

        $fields = [
            'email' =>  'required|email|unique:users,email,' . $id . ',id',
            'name' => 'required|string',
            'password'  =>  'nullable|min:8',
            'country_code' => 'required',
            'level' => 'required',
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
        $messages['country_code.required'] = 'The country code field is required.';
        $messages['dob.required'] = 'Date of Birth is required.';
        $messages['mobile.required'] = 'The contact number field is required.';
        $messages['mobile.min'] = 'The contact number must be at least 8 characters.';
        $request->validate($fields, $messages);

        $customer = User::find($id);
        $customer->level_id = json_encode($request->level);
        $customer->name = $request->name;
        $customer->dob = date('Y-m-d', strtotime($request->dob))??NULL;
        $customer->email = $request->email??NULL;
        $customer->address = $request->address??NULL;
        $customer->gender = $request->gender??NULL;
        $customer->country_code = $request->country_code??NULL;
        $customer->country_code_phone = $request->country_code_phone??NULL;
        $customer->mobile = $request->mobile??NULL;
        if (!is_null($request->password)) {
            $customer->password = Hash::make($request->password);
        }
        $customer->updated_at = Carbon::now();
        $customer->save();
        return redirect()->route('external-profile.my-students')->with('success', __('constant.ACOUNT_UPDATED'));

    }


	public function competition()
	{
		$user = $this->user;
        $instructor_id = User::where('id', Auth::user()->id)->first();
        $allocated_competition = CompetitionStudent::where('instructor_id', $user->id)->pluck('competition_controller_id');
        $allocated_user = CompetitionStudent::where('instructor_id', $user->id)->pluck('user_id');
		$competition = Competition::where('status', 1)->orderBy('id', 'desc')->first();
		$students = User::whereNotIn('id',$allocated_user)->get();

        $compStudents = CompetitionStudent::where('instructor_id', $instructor_id->id)->paginate($this->pagination);


		return view('account.competition-students', compact('competition', 'compStudents', 'competition'));
	}

    public function delete_instructor_competition($id)
    {
        CompetitionStudent::where('id', $id)->delete();
        return redirect()->back()->with('success', __('constant.ALLOCATE_DELETED'));
    }

    public function edit_instructor_competition($id)
	{


        $students = User::where('user_type_id',1)->orderBy('id','desc')->get();
        $locations = LearningLocation::orderBy('id','desc')->get();
        $categories = CompetitionCategory::orderBy('id','desc')->get();
		$competition_student = CompetitionStudent::find($id);
        $competition = Competition::where('status', 1)->where('id', $competition_student->competition_controller_id)->first();
        $user = User::find($competition_student->user_id);
		//dd($user);
		return view('account.edit-competition-registration', compact('competition', 'students', 'competition_student','locations','categories','user'));
	}

    public function update_instructor_competition(Request $request,$id)
	{
        //dd($request->all());
        $users = User::find($this->user->id);

        $request->validate([
            'learning_location' => 'required',
            'category_id' => 'required',
        ]);


        $competitionStudent = CompetitionStudent::find($id);
        $competitionStudent->learning_location  = $request->learning_location ?? NULL;
        $competitionStudent->category_id  = $request->category_id ?? NULL;
        $competitionStudent->remarks  = $request->remarks ?? NULL;
        $competitionStudent->save();

		return redirect()->route('instructor-competition')->with('success', __('constant.GRADING_UPDATED'));
	}

    public function competition_register_instructor($competition_id)
	{
        $user = $this->user;
		$competition = Competition::where('status', 1)->where('id', $competition_id)->first();
        $allocated_user = CompetitionStudent::where('instructor_id', $user->id)->pluck('user_id');
        $students = User::where('user_type_id',1)->whereNotIn('id',$allocated_user)->get();
        $locations = LearningLocation::orderBy('id','desc')->get();
        $categories = CompetitionCategory::orderBy('id','desc')->get();
		$compStudents = CompetitionStudent::has('userlist')->where('competition_controller_id', $competition->id)->where('instructor_id', $user->id)->paginate($this->pagination);
		//dd($user);
		return view('account.competition-registration', compact('competition', 'students', 'compStudents','locations','categories'));
	}

    public function competition_register_instructor_store(Request $request,$id)
	{
        //dd($request->all());
        $users = User::find($this->user->id);

        $request->validate([
            'user_id' => 'required',
            'learning_location' => 'required',
            'category_id' => 'required',
        ]);


        $competitionStudent = new CompetitionStudent();
        $competitionStudent->user_id   = $request->user_id ?? NULL;
        $competitionStudent->competition_controller_id    = $id ?? NULL;
        $competitionStudent->instructor_id  = $this->user->id;   //Test /Survey
        $competitionStudent->learning_location  = $request->learning_location ?? NULL;
        $competitionStudent->category_id  = $request->category_id ?? NULL;
        $competitionStudent->remarks  = $request->remarks ?? NULL;
        $competitionStudent->save();

		return redirect()->route('instructor-competition')->with('success', __('constant.GRADING_UPDATED'));
	}

    public function update_competition(Request $request,$id)
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

    public function register_instructor_store(Request $request)
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



	public function achievements(){
		$userId = Auth::user()->id;
		$actualCompetitionPaperSubted = CompetitionPaperSubmitted::where('user_id', $userId)->where('paper_type', 'actual')->groupBy('category_id')->groupBy('competition_id')->get();
		//dd($actualCompetitionPaperSubted);
		return view("account.achievements", compact('actualCompetitionPaperSubted'));
		//$competitionId =
	}


    public function view_grading($id){
		$userId = $id;
		$actualCompetitionPaperSubted = CompetitionPaperSubmitted::where('user_id', $userId)->where('paper_type', 'actual')->groupBy('category_id')->groupBy('competition_id')->get();
		//dd($actualCompetitionPaperSubted);
		return view("account.achievements", compact('actualCompetitionPaperSubted'));
		//$competitionId =
	}

	public function cart(Request $request){
        //dd($request->all());
        if($request->type == 'physicalcompetition'){
            foreach($request->paper as $value){
                $paper = CompetitionPaper::where('id', $value)->first();
                $levelDetails = array();
                $levelDetails['type'] = 'physicalcompetition';
                $levelDetails['id'] = $value;
                $levelDetails['name'] = $paper->title;
                $levelDetails['description'] = $paper->description;
                $levelDetails['image'] = '';
                $levelDetails['amount'] = $paper->price;
                $levelDetails['months'] = '';

                $tempCart = new TempCart();
                $jsonEncode = json_encode($levelDetails);
                $tempCart->user_id = Auth::user()->id;
                $tempCart->type = $request->type;
                $tempCart->level_id = null;
                $tempCart->cart = $jsonEncode;
                $tempCart->save();
            }
        }elseif($request->type == 'onlinecompetition'){
                $paper = CompetitionPaper::where('id', $request->paper)->first();
                $levelDetails = array();
                $levelDetails['type'] = 'onlinecompetition';
                $levelDetails['id'] = $request->paper;
                $levelDetails['name'] = $paper->title;
                $levelDetails['description'] = $paper->description;
                $levelDetails['image'] = '';
                $levelDetails['amount'] = $paper->price;
                $levelDetails['months'] = '';

                $tempCart = new TempCart();
                $jsonEncode = json_encode($levelDetails);
                $tempCart->user_id = Auth::user()->id;
                $tempCart->type = $request->type;
                $tempCart->level_id = null;
                $tempCart->cart = $jsonEncode;
                $tempCart->save();
        }
        elseif($request->type == 'onlinegrading'){
            $paper = GradingListingDetail::where('id', $request->paper)->first();
            $levelDetails = array();
            $levelDetails['type'] = 'onlinegrading';
            $levelDetails['id'] = $request->paper;
            $levelDetails['name'] = $paper->title;
            $levelDetails['description'] = '';
            $levelDetails['image'] = '';
            $levelDetails['amount'] = $paper->price;
            $levelDetails['months'] = '';

            $tempCart = new TempCart();
            $jsonEncode = json_encode($levelDetails);
            $tempCart->user_id = Auth::user()->id;
            $tempCart->type = $request->type;
            $tempCart->level_id = null;
            $tempCart->cart = $jsonEncode;
            $tempCart->save();
    }
    if($request->type == 'physicalgrading'){
        foreach($request->paper as $value){
            $paper = GradingListingDetail::where('id', $value)->first();
            $levelDetails = array();
            $levelDetails['type'] = 'physicalgrading';
            $levelDetails['id'] = $value;
            $levelDetails['name'] = $paper->title;
            $levelDetails['description'] = $paper->description;
            $levelDetails['image'] = '';
            $levelDetails['amount'] = $paper->price;
            $levelDetails['months'] = '';

            $tempCart = new TempCart();
            $jsonEncode = json_encode($levelDetails);
            $tempCart->user_id = Auth::user()->id;
            $tempCart->type = $request->type;
            $tempCart->level_id = null;
            $tempCart->cart = $jsonEncode;
            $tempCart->save();
        }
    }
        else{
            $levelId = $request->levelId ?? null;
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
            $tempCart->level_id = $levelId ?? null;
            $tempCart->cart = $jsonEncode;
            $tempCart->save();
        }




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

    public function cartListClear(Request $request){
        $cartDetails = TempCart::whereIn('id', $request->deletecart)->where('user_id', Auth::user()->id)->get();
		foreach($cartDetails as $cart){
			$cart->delete();
		}
		return redirect()->to('/cart');
    }

	public function checkout(){
		$cartDetails = TempCart::where('user_id', Auth::user()->id)->get();

		return view('account.checkout', compact("cartDetails"));
	}

    public function membership(){
        $orderDetails = array();
        $orders = Order::where('user_id', Auth::user()->id)->where('payment_status', 'COMPLETED')->pluck('id')->toArray();
        if($orders){
            $orderDetails = OrderDetail::whereIn('order_id', $orders)->paginate(10);
        }
        return view('account.membership', compact('orderDetails'));
    }
}
