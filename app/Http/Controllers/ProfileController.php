<?php

namespace App\Http\Controllers;

use App\AchievementOther;
use App\Notification;
use App\Announcement;
use App\InstructorCalendar;
use App\Grade;
use App\CategoryGrading;
use App\GradingCategory;
use App\GradingStudentResults;
use App\GradingExam;
use App\GradingPaper;
use App\GradingExamList;
use App\GradingListingDetail;
use App\GradingStudent;
use App\LearningLocation;
use App\TeachingMaterials;
use App\SubHeading;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use App\TestManagement;
use App\TestQuestionSubmission;
use App\TestPaperQuestionDetail;
use App\TestSubmission;
use App\Survey;
use App\User;
use ZipArchive;
use App\Allocation;
use App\TestPaperDetail;
use App\Admin;
use App\CategoryCompetition;
use App\CompetitionStudentResult;
use App\Competition;
use App\CompetitionCategory;
use App\CompetitionPaper;
use App\CompetitionPaperSubmitted;
use App\CompetitionPassUpload;
use App\CompetitionStudent;
use App\Country;
use App\ExaminationPass;
use App\GradingPassUpload;
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
use PDF;
use Response;

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
        $today=date('Y-m-d');
        $highest_competetion_grade = CompetitionStudentResult::join('competition_controllers','competition_student_results.competition_id','competition_controllers.id')->join('competition_students','competition_students.competition_controller_id','competition_controllers.id')->select('competition_student_results.*','competition_controllers.title as comp_title','competition_controllers.date_of_competition')->where('competition_students.instructor_id', $user->id)->where('competition_controllers.date_of_competition','<',$today)->orderBy('competition_student_results.total_marks','desc')->orderBy('competition_controllers.date_of_competition','desc')->first();
        $highest_grading_grade = GradingStudentResults::join('grading_exams','grading_student_results.grading_id','grading_exams.id')->join('grading_students','grading_students.grading_exam_id','grading_exams.id')->select('grading_student_results.*','grading_exams.title as grade_title','grading_exams.date_of_competition')->where('grading_students.instructor_id', $user->id)->where('grading_exams.date_of_competition','<',$today)->orderBy('grading_student_results.total_marks','desc')->orderBy('grading_exams.date_of_competition','desc')->first();


        //dd($highest_grading_grade);
        return view('account.instructor-profile', compact("page", "user","highest_competetion_grade","highest_grading_grade"));
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

    public function grading_examination($id)
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');
        $todayDate = date('Y-m-d');
		$user = $this->user;
		$grading = GradingStudent::where('instructor_id',$user->id)->where('grading_exam_id',$id)->paginate($this->pagination);
		$page = get_page_by_slug($slug);

		if (!$page) {
			return abort(404);
		}
        $gradingExam = GradingExam::where('status', 1)->whereDate('date_of_competition','>=',$todayDate)->where('id',$id)->first();
		//dd($user);

		return view('account.grading-examination', compact("page", "user","grading","gradingExam","id"));
	}

    public function grading_examination_listing()
	{

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');
        $page = get_page_by_slug($slug);
        $todayDate = date('Y-m-d');
		$user = $this->user;
		$grading_exam = GradingExam::where('status', 1)->whereDate('date_of_competition','>=',$todayDate)->orderBy('id','desc')->get();

		return view('account.grading-examination-listing', compact("page", "user","grading_exam"));
	}

    public function register_grading_examination($id)
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
        $allocated_user = GradingStudent::where('instructor_id',$user->id)->where('grading_exam_id',$id)->select('user_id')->get();
        $allocate_user_array=[];
        foreach($allocated_user->toArray() as $value)
        {
            $allocate_user_array[]=$value['user_id'];
        }
        //dd($allocated_user);
        if($user->user_type_id==6)
        {
            $students = User::where('user_type_id',4)->where('instructor_id',$user->id)->whereNotIn('id',$allocate_user_array)->orderBy('id','desc')->get();
        }
        else
        {
            $students = User::whereIN('user_type_id',[1,2,3])->where('instructor_id',$user->id)->whereNotIn('id',$allocate_user_array)->orderBy('id','desc')->get();
        }

        $mental_grades = CategoryGrading::join('grading_categories','grading_categories.id','category_gradings.category_id')->where('grading_categories.grade_type_id', 1)->where('category_gradings.competition_id', $id)->orderBy('grading_categories.category_name','asc')->select('grading_categories.*')->get();
        $abacus_grades = CategoryGrading::join('grading_categories','grading_categories.id','category_gradings.category_id')->where('grading_categories.grade_type_id', 2)->where('category_gradings.competition_id', $id)->orderBy('grading_categories.category_name','asc')->select('grading_categories.*')->get();
        $gradingExam = GradingExam::find($id);
        $locations = LearningLocation::orderBy('title','asc')->get();
        //dd($abacus_grades);
		$page = get_page_by_slug($slug);

		if (!$page) {
			return abort(404);
		}

		//dd($user);

		return view('account.register-grading-examination', compact("page", "user","students","locations","mental_grades","abacus_grades","gradingExam"));
	}

    public function edit_grading($id, $geid)
	{
		//

		$title = __('constant.MY_PROFILE');
		$slug =  __('constant.SLUG_MY_PROFILE');

		$user = $this->user;
        $students = User::where('user_type_id',1)->orderBy('id','desc')->get();
        $mental_grades = CategoryGrading::join('grading_categories','grading_categories.id','category_gradings.category_id')->where('grading_categories.grade_type_id', 1)->where('category_gradings.competition_id', $geid)->orderBy('grading_categories.category_name','asc')->select('grading_categories.*')->get();
        $abacus_grades = CategoryGrading::join('grading_categories','grading_categories.id','category_gradings.category_id')->where('grading_categories.grade_type_id', 2)->where('category_gradings.competition_id', $geid)->orderBy('grading_categories.category_name','asc')->select('grading_categories.*')->get();
        $gradingExam = GradingExam::where('status', 1)->get();
        $locations = LearningLocation::orderBy('title','asc')->get();
		$page = get_page_by_slug($slug);
        $grading=GradingStudent::where('id', $id)->first();

		if ($grading->approve_status==1) {
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

		$test = TestManagement::join('allocations','allocations.assigned_id','test_management.id')->select('test_management.*')->where('allocations.type',1)->groupBy('allocations.assigned_id')->orderBy('test_management.id', 'asc')->where('allocations.assigned_by', $this->user->id)->get();

        $survey = Survey::paginate($this->pagination);
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
        $students = User::whereIn('user_type_id',[1,2])->where('instructor_id',$user->id)->whereNotIn('id',$allocate_user_array)->orderBy('id','desc')->get();

        $test = TestManagement::findorfail($test_id);
        $list = Allocation::where('allocations.assigned_id',$test_id)->where('allocations.assigned_by', $this->user->id)->where('allocations.type',1)->select('allocations.*')->paginate($this->pagination);
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
        $students = User::whereIn('user_type_id',[1,2,3])->where('instructor_id',$user->id)->whereNotIn('id',$allocate_user_array)->orderBy('id','desc')->get();
		$survey = Survey::findorfail($survey_id);
		$page = get_page_by_slug($slug);
        $list = Allocation::where('allocations.assigned_id',$survey_id)->where('allocations.assigned_by', $this->user->id)->where('allocations.type',2)->paginate($this->pagination);
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
        $test = TestManagement::join('allocations','allocations.assigned_id','test_management.id')->where('allocations.student_id',$this->user->id)->where('test_management.id',$id)->select('test_management.*','allocations.id as allocation_id')->first();
        //$test = TestManagement::find($id);
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
        elseif($qId == 11){
            $all_paper_detail=TestPaperDetail::where('paper_id',$test->paper->id)->first();
            return view('account.testOther', compact("test","all_paper_detail"));
        }
        elseif($qId == 7){
            $all_paper_detail_v=TestPaperDetail::where('paper_id',$test->paper->id)->where('template',1)->get();
            $all_paper_detail_h=TestPaperDetail::where('paper_id',$test->paper->id)->where('template',2)->get();
            return view('account.testMix', compact("test","all_paper_detail_h","all_paper_detail_v"));
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

    public function detail_test2($id){
        $test = TestManagement::find($id);
        //dd($test);
        //$test = TestManagement::find($id);
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
        elseif($qId == 11){
            $all_paper_detail=TestPaperDetail::where('paper_id',$test->paper->id)->first();
            return view('account.testOther', compact("test","all_paper_detail"));
        }
        elseif($qId == 7){
            $all_paper_detail_v=TestPaperDetail::where('paper_id',$test->paper->id)->where('template',1)->get();
            $all_paper_detail_h=TestPaperDetail::where('paper_id',$test->paper->id)->where('template',2)->get();
            return view('account.testMix', compact("test","all_paper_detail_h","all_paper_detail_v"));
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

    public function view_test_result($user,$id){
        $test = TestManagement::join('allocations','allocations.assigned_id','test_management.id')->where('allocations.student_id',$user)->where('test_management.id',$id)->select('test_management.*','allocations.id as allocation_id')->first();
        //$test = TestManagement::find($id);
        $all_paper_detail=TestPaperDetail::where('paper_id',$test->paper->id)->get();
        $testSubmitted = TestSubmission::where('test_id',$id)->where('test_submissions.user_id', $user)->first();
        $qId=$test->paper->question_template_id;
        //dd($qId);
        if($qId == 5){
            return view('account.testSubmitMultipleDivision', compact("test","all_paper_detail","testSubmitted"));
        }
        elseif($qId == 6){
            return view('account.testSubmitChallenge', compact("test","all_paper_detail","testSubmitted"));
        }
        elseif($qId == 8){
            return view('account.testSubmitAbacus', compact("test","all_paper_detail","testSubmitted"));
        }
        elseif($qId == 11){
            $all_paper_detail=TestPaperDetail::where('paper_id',$test->paper->id)->first();
            return view('account.testOther', compact("test","all_paper_detail","testSubmitted"));
        }
        elseif($qId == 7){
            $all_paper_detail_v=TestPaperDetail::where('paper_id',$test->paper->id)->where('template',1)->get();
            $all_paper_detail_h=TestPaperDetail::where('paper_id',$test->paper->id)->where('template',2)->get();
            return view('account.testSubmitMix', compact("test","all_paper_detail_h","all_paper_detail_v","testSubmitted"));
        }
        elseif($qId == 4){
            return view('account.testSubmitAddSubQuestion', compact("test","all_paper_detail","testSubmitted"));
        }
        elseif($qId == 3){
            return view('account.testSubmitNumber', compact("test","all_paper_detail","testSubmitted"));
        }
        elseif($qId == 1){
            return view('account.testSubmitAudio', compact("test","all_paper_detail","testSubmitted"));
        }
        elseif($qId == 2){
            return view('account.testSubmitVideo', compact("test","all_paper_detail","testSubmitted"));
        }
        //return view('account.online-my-course-detail', compact('course'));
    }

    public function submit_test(Request $request){

        $test_id = $request->test_id;
        $questionTypeId = $request->question_type;
        $userId = Auth::user()->id;
        $questTem = array(1,2,3,4,5,6,7,8,11);
        $resultpage = array(1,2,3,4,5,6,7,8,11);

        foreach($request->test_paper_question_id as $test_paper_question_id)
        {
            if(in_array($questionTypeId, $questTem)){
                $testPaperdetail = TestPaperDetail::find($test_paper_question_id);
                //dd($testPaperdetail);
                $flag=1;
                if(isset($request->answer2))
                {
                    foreach($request->answer2 as $key=>$value)
                    {
                        if($key+$testPaperdetail->write_from!=$value)
                        {
                            $flag=0;
                        }
                    }
                }

                //echo $flag;die;
                $courseSub = new TestSubmission();
                $courseSub->test_paper_question_id   = $test_paper_question_id;
                $courseSub->test_id  = $test_id;
                $courseSub->question_template_id = $questionTypeId;
                $courseSub->user_id = $userId;
                $courseSub->allocation_id = $request->allocation_id;
                if(isset($request->answer2))
                {
                $courseSub->other_answer = json_encode($request->answer2);
                }
                if($questionTypeId==11)
                {
                    if( $flag==1)
                    {
                        $courseSub->other_marks =$other_marks= $testPaperdetail->marks;
                    }
                    else
                    {
                        $courseSub->other_marks=$other_marks = 0;
                    }
                }


                $courseSub->save();
                $allocation =Allocation::find($request->allocation_id);
                $allocation->is_finished =1;
                $allocation->save();

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
                if($questionTypeId==11)
                {
                    $totalMarks+=$testPaperdetail->marks;
                    $userMarks+=$other_marks;
                }
                $saveResult = TestSubmission::where('id', $courseSub->id)->first();
                $saveResult->total_marks = $totalMarks;
                $saveResult->user_marks = $userMarks;
                $saveResult->save();
            }
        }
        if(in_array($questionTypeId, $resultpage)){
            return view('result-test', compact('totalMarks', 'userMarks'));
        }


    }

    public function grading_paper($grading_exam_id,$listing_id,$paper_id)
    {
        $paper=GradingPaper::join('grading_listing_details','grading_listing_details.paper_id','grading_papers.id')->where('grading_listing_details.id',$paper_id)->where('grading_papers.status',1)->select('grading_papers.*','grading_listing_details.id as listing_paper_id')->first();
        //dd($paper);
        $gradingExam = GradingExam::find($grading_exam_id);
        if($paper){
            $qId=$paper->question_type;
        }else{
            $qId='';
        }

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
        $franchiseCountry = Admin::where('admin_role', 2)->pluck('country_id')->toArray();
        $country = Country::whereIn('id', $franchiseCountry)->get();
        // $country = Country::orderBy('country', 'asc')->get();
        $country_phone = Country::orderBy('phonecode', 'asc')->get();
        //dd( $country_phone);
        if($this->user->user_type_id==4)
        {
            return view('account.event-online-profile', compact("page", "instructors", 'country','country_phone'));
        }
        else
        {
            return view('account.my-profile', compact("page", "user", "instructors", 'country','country_phone'));
        }

	}

    public function download_all_announcements($id)
    {
               $file= public_path(). "/upload-file/";
               $today=date('Y-m-d H:i:s');
               $zipFileName = strtotime($today).'.zip';
               $zip = new ZipArchive;
               $announcement = Announcement::find($id);
               $json=json_decode($announcement->attachments);
               for($i=0;$i<count($json);$i++)
               {

                    if ($zip->open($file . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
                        $zip->addFile($file.$json[$i]);
                        $zip->close();
                       // dd($file.$json[$i]);
                    }
                }
            // Set Header
            $headers = array(
                'Content-Type' => 'application/octet-stream',
            );
            $filetopath=$file.$zipFileName;

            // Create Download Response
            if(file_exists($filetopath)){
                return response()->download($filetopath,$zipFileName,$headers);
            }
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

        foreach($request->student_id as $student)
        {
        $allocation = new Allocation();
        $allocation->student_id  = $student ?? NULL;
        $allocation->assigned_by  = $this->user->id; // Instructor
        $allocation->assigned_id  = $id;   //Test /Survey
        $allocation->start_date  = $request->start_date ?? NULL;
        $allocation->end_date  = $request->end_date ?? NULL;
        $allocation->type  = 1;
        $allocation->save();
        }

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


        foreach($request->student_id as $student)
        {
            $allocation = new Allocation();
            $allocation->student_id  = $student ?? NULL;
            $allocation->assigned_id  = $id;
            $allocation->assigned_by  = $this->user->id;
            $allocation->start_date  = $request->start_date ?? NULL;
            $allocation->end_date  = $request->end_date ?? NULL;
            $allocation->type  = 2;
            $allocation->save();
        }

		return redirect()->back()->with('success', __('constant.SURVEY_UPDATED'));
	}

    public function grading_register_store(Request $request)
	{
        //dd($request->all());
        $users = User::find($this->user->id);

        $request->validate([
            'user_id' => 'required',
        ]);

        //dd($request);

        $gradingStudent = new GradingStudent();
        $gradingStudent->user_id   = $request->user_id ?? NULL;
        $gradingStudent->grading_exam_id   = $request->grading_exam_id ?? NULL;
        $gradingStudent->instructor_id  = $this->user->id;
        $gradingStudent->mental_grade  = $request->mental_grade ?? NULL;
        //$gradingStudent->learning_location  = $request->learning_location ?? NULL;
        $gradingStudent->abacus_grade  = $request->abacus_grade ?? NULL;
        $gradingStudent->remarks  = $request->remarks ?? NULL;
        $gradingStudent->save();


        //			Admin email for new grading registration
			$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_GRADING_REGISTRATION'));
            $admins = Admin::get();

            if ($email_template) {
                $gradingExamDetail = GradingExam::where('id', $request->grading_exam_id)->first();
                $data = [];
                foreach($admins as $admin){
                    $data['email_sender_name'] = systemSetting()->email_sender_name;
                    $data['from_email'] = systemSetting()->from_email;
                    $data['to_email'] = [$admin->email];
                    $data['cc_to_email'] = [];
                    $data['subject'] = $email_template->subject;

                    $key = ['{{grading_exam}}'];
                    $value = [$gradingExamDetail->title ?? ''];

                    $newContents = str_replace($key, $value, $email_template->content);

                    $data['contents'] = $newContents;
                    try {
                        $mail = Mail::to($admin->email)->send(new EmailNotification($data));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }

            }

		return redirect()->route('grading-examination',[$request->grading_exam_id])->with('success', __('constant.GRADING_UPDATED'));
	}

    public function update_grading(Request $request,$id)
	{
        //dd($request->all());
        $users = User::find($this->user->id);




        $gradingStudent = GradingStudent::find($id);
        $gradingStudent->mental_grade  = $request->mental_grade ?? NULL;
        $gradingStudent->abacus_grade  = $request->abacus_grade ?? NULL;
        //$gradingStudent->learning_location  = $request->learning_location ?? NULL;
        $gradingStudent->remarks  = $request->remarks ?? NULL;
        $gradingStudent->save();

		//return redirect()->route('grading-examination')->with('success', __('constant.GRADING_UPDATED'));
        return redirect()->back()->with('success', 'Updated successfully');
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
        $instructorCalendar->start_time  = ($request->start_time)?date('H:i:s',strtotime($request->start_time)):NULL;
        $instructorCalendar->note  = $request->note ?? NULL;
        $instructorCalendar->reminder  = $request->reminder;
        $instructorCalendar->save();

		return redirect()->back()->with('success', __('constant.CALENDAR_UPDATED'));
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
                if($users->user_type_id == 3){
                    $request->validate([
                        'name' => 'required',
                        'email' => 'required|unique:users,email,'.$users->id,
                        'dob' => 'required',
                        //'country_code_phone' => 'required',
                        'mobile' => 'required',
                        'gender' => 'required',
                        'country_code_phone' => 'required',
                        // 'instructor' => 'required',
                        // 'country_code' => 'required',
                        //'password'  =>  'nullable|min:8',
                        //'country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',
                        ], $messages); //dd($request);
                }
                else if($users->user_type_id == 4)
                {
                    $request->validate([
                        'name' => 'required',
                        'dob' => 'required',
                        'country_code_phone' => 'required',
                        'mobile' => 'required',
                        'gender' => 'required',
                        // 'instructor' => 'required',
                        //'country_code' => 'required',
                        //'password'  =>  'nullable|min:8',
                        //'country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',
                        ], $messages);
                }
                else{
                    $request->validate([
                        'name' => 'required',
                        'email' => 'required|unique:users,email,'.$users->id,
                        'dob' => 'required',
                        'country_code_phone' => 'required',
                        'mobile' => 'required',
                        'gender' => 'required',
                        // 'instructor' => 'required',
                        // 'country_code' => 'required',
                        //'password'  =>  'nullable|min:8',
                        //'country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',
                        ], $messages); //dd($request);
                }
            }
            //            $checkPendingRequest = UserProfileUpdate::where('user_id', $users->id)->where('approve_status', '!=', 1)->first();
            //            if($checkPendingRequest){
            //                //throw ValidationException::withMessages(['Profile Update request already pending']);
            //                return back()->withErrors('Profile Update request already pending');
            //            }
            $var = $request->dob;
            $date = str_replace('/', '-', $var);
            $dob = date('Y-m-d', strtotime($date));
            //dd($request);

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
            // $updateUserProfile->country_code = $request->country_code;
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

            //$instructorDetail = User::where('id', $request->oldInstructorId)->first();
            $instructorDetail = User::where('id', $users->instructor_id)->first();
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_INSTRUCTOR_STUDENT_PROFILE_UPDATE'));

            if ($email_template) {
                if($instructorDetail){
                    $data = [];
                    $data['email_sender_name'] = systemSetting()->email_sender_name;
                    $data['from_email'] = systemSetting()->from_email;
                    $data['to_email'] = [$instructorDetail->email];
                    $data['cc_to_email'] = [];
                    $data['subject'] = $email_template->subject;

                    $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{instructor}}'];
                    $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $instructorDetail->name];

                    $newContents = str_replace($key, $value, $email_template->content);

                    $data['contents'] = $newContents;
                    try {
                        $mail = Mail::to($instructorDetail->email)->send(new EmailNotification($data));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }


            }
            // dd("aa");
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

                    $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{instructor}}'];
                    //dd($instructorDetail);
                    $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $instructorDetail->name];
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
		$slug =  'teaching-materials';

		$user = $this->user;
		//dd($user);
		$page = get_page_by_slug($slug);
        $subHeading = SubHeading::get();
		if (!$page) {
			return abort(404);
		}

        if(isset($_GET['keyword']) && $_GET['keyword']!='')
        {
            $materials = TeachingMaterials::where('title','like','%' .$_GET['keyword'].'%')->where('teacher_id',$this->user->id)->orderBy('id', 'asc')->paginate($this->pagination);
        }
        else if(isset($_GET['file_type']) && $_GET['file_type']!='')
        {

            $materials = TeachingMaterials::where('file_type',$_GET['file_type'])->where('teacher_id',$this->user->id)->orderBy('id', 'asc')->paginate($this->pagination);
            //dd($materials);
        }
        else if(isset($_GET['sub_heading']) && $_GET['sub_heading']!='')
        {

            $materials = TeachingMaterials::where('sub_heading',$_GET['sub_heading'])->where('teacher_id',$this->user->id)->orderBy('id', 'asc')->paginate($this->pagination);
            //dd($materials);
        }
        else
        {
            $materials = TeachingMaterials::orderBy('id', 'asc')->where('teacher_id',$this->user->id)->paginate($this->pagination);
        }

		return view('account.teaching-materials', compact("page", "user","materials","subHeading"));
    }

    public function teaching_materials_download($id)
    {

        $material = TeachingMaterials::find($id);
        //PDF file is stored under project/public/download/info.pdf
        $file= public_path(). "/".$material->uploaded_files;
        $filename = explode('/', $material->uploaded_files);
        $filename =end($filename);
        $file_name = explode('_', $filename);
        $download_filename=end($file_name);
        $headers = array(
                'Content-Type: application/pdf',
                );

        return Response::download($file, $download_filename, $headers);
    }

    public function teaching_materials_view($id)
    {

        $material = TeachingMaterials::find($id);
        //PDF file is stored under project/public/download/info.pdf
        $full_file= asset($material->uploaded_files);


        return view('account.view-teaching-materials', compact("full_file",));
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
                    //'country_code' => 'required',
                ], $messages); //dd($request);
            }


            $dob = date('Y-m-d', strtotime($request->dob));
            $updateUserProfile = User::find($this->user->id);
            //$updateUserProfile->user_id  = $users->id;
            $updateUserProfile->name = $request->name;
            $updateUserProfile->instructor_full_name = $request->instructor_full_name ?? NULL;
            $updateUserProfile->email = $request->email;
            //$users->email = $request->email;
            if ($request->password != '') {
                //dd($request->password);
                $updateUserProfile->password = Hash::make($request->password);
            }
            $updateUserProfile->address = $request->address ?? NULL;
            //$updateUserProfile->country_code = $request->country_code;
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

                    $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{instructor}}'];
                    $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address,  $this->user->name];

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

                    $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{instructor}}'];
                    $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $instructorDetail->name];

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

    public function approve_students($user_id)
    {
        $customer=UserProfileUpdate::where('user_id',$user_id)->first();
        $levels = Level::where('status',1)->get();
        $country = Country::orderBy('phonecode')->get();
        //dd($customer);
        return view('account.edit-approved-students', compact('customer','levels','country'));
    }

	public function studentlist(){
		$instructor_id = User::where('id', Auth::user()->id)->first();
        if(isset($_GET['level_id']) && $_GET['level_id']!='')
        {
            $students = User::where('level_id','like','%' .$_GET['level_id'].'%')->whereIn('approve_status',[1,0])->where('instructor_id', $instructor_id->id)->orderBy('id', 'desc')->paginate($this->pagination);
        }
        elseif(isset($_GET['learning_locations']) && $_GET['learning_locations']!='')
        {   $students = User::where('learning_locations',$_GET['learning_locations'])->whereIn('approve_status',[1,0])->where('instructor_id', $instructor_id->id)->orderBy('id', 'desc')->paginate($this->pagination);
        }
        elseif(isset($_GET['status']) && $_GET['status']!='')
        {   
            if($_GET['status'] == 1){
                $students = User::where('approve_status', $_GET['status'])->whereIn('approve_status',[1])->where('instructor_id', $instructor_id->id)->orderBy('id', 'desc')->paginate($this->pagination);
            }else{
                $students = User::where('approve_status', $_GET['status'])->whereIn('approve_status',[0])->where('instructor_id', $instructor_id->id)->orderBy('id', 'desc')->paginate($this->pagination);
            }
        }
        else
        {
            $students = User::where('instructor_id', $instructor_id->id)->whereIn('approve_status',[1,0])->orderBy('id', 'desc')->paginate($this->pagination);
        }
        $locations = LearningLocation::orderBy('title','asc')->get();
		$levels = Level::where('status',1)->get();
		return view('account.teaching-students', compact('students', 'levels','locations'));
    }

    public function add_material()
    {
        $slug =  'teaching-materials';

		$user = $this->user;
		//dd($user);
		$page = get_page_by_slug($slug);
        $subHeading = SubHeading::get();
        $instructors = User::where('user_type_id', 5)->orderBy('name','asc')->get();
        return view('account.add-material', compact('instructors','page','subHeading'));
    }

    public function store_add_material(Request $request)
    {
        $request->validate([
            'title'  =>  'required',
            'sub_heading'  =>  'required',
            'uploaded_files'  =>  'required|file|mimes:jpeg,jpg,png,gif,doc,docx,pdf,mp4,pptx,ppt',
        ]);

        $material = new TeachingMaterials;
        $material->title = $request->title ?? '';
        $material->sub_heading = $request->sub_heading ?? '';
        if ($request->hasFile('uploaded_files')) {
            $material->uploaded_files=$uploaded_file = uploadPicture($request->file('uploaded_files'), __('constant.TEACHING_MATERIALS'));
            $ext = pathinfo($uploaded_file, PATHINFO_EXTENSION);
            $material->file_type = $ext;
        }
        $material->description = $request->description ?? '';
        $material->link = $request->abacus_simulator ?? '';
        $material->teacher_id = $this->user->id;
        $material->created_at = Carbon::now();
        $material->save();

        return redirect()->route('teaching-materials')->with('success', __('constant.ACOUNT_CREATED'));
    }

    public function add_students()
    {
        $country = Country::orderBy('phonecode')->get();
        $levels = Level::where('status',1)->orderBy('title','asc')->get();
        $locations = LearningLocation::orderBy('title','asc')->get();
        return view('account.instructor-add-students', compact('levels', 'country','locations'));
    }

    public function edit_students($id)
    {
        $country = Country::orderBy('phonecode')->get();
        $levels = Level::where('status',1)->orderBy('title','asc')->get();
        $customer = User::find($id);
        $locations = LearningLocation::orderBy('title','asc')->get();
        return view('account.instructor-edit-students', compact('levels', 'country','customer','locations'));
    }

    public function view_students($id)
    {
        $country = Country::orderBy('phonecode')->get();
        $levels = Level::where('status',1)->orderBy('title','asc')->get();
        $customer = User::find($id);
        $locations = LearningLocation::orderBy('title','asc')->get();
        return view('account.instructor-view-students', compact('levels', 'country','customer','locations'));
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
        $customer->approve_status=$request->status??NULL;
        if($request->status==2)
        {
            $customer->instructor_id=null;
            $customer->learning_locations=null;
        }
        $customer->updated_at = Carbon::now();
        $customer->save();
        return redirect()->route('external-profile.my-students')->with('success', __('constant.ACOUNT_UPDATED'));

    }

    public function update_approved_students (Request $request,$id)
    {

        $fields = [
            'email' =>  'required|email|unique:users,email,' . $id . ',id',
            'name' => 'required|string',
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
        $messages['email.email'] = 'The email address must be a valid email address.';
        $messages['country_code_phone.required'] = 'The country code is required.';
        $messages['country_code.required'] = 'The country code field is required.';
        $messages['dob.required'] = 'Date of Birth is required.';
        $messages['mobile.required'] = 'The contact number field is required.';
        $messages['mobile.min'] = 'The contact number must be at least 8 characters.';
        $request->validate($fields, $messages);

        $userProfileUpdate = UserProfileUpdate::find($request->user_profile_update_id);
        $userProfileUpdate->approve_status  = 1;
        $userProfileUpdate->save();
        $customer = User::find($id);
        $customer->name = $request->name;
        $customer->dob = date('Y-m-d', strtotime($request->dob))??NULL;
        $customer->email = $request->email??NULL;
        $customer->address = $request->address??NULL;
        $customer->gender = $request->gender??NULL;
        $customer->country_code = $request->country_code??NULL;
        $customer->country_code_phone = $request->country_code_phone??NULL;
        $customer->mobile = $request->mobile??NULL;
        $customer->updated_at = Carbon::now();
        $customer->save();
        return redirect()->route('instructor.my-students')->with('success', __('constant.ACOUNT_UPDATED'));

    }


	public function competition()
	{
		$user = $this->user;
        $instructor_id = User::where('id', Auth::user()->id)->first();
        $allocated_competition = CompetitionStudent::where('instructor_id', $user->id)->pluck('competition_controller_id');
        $allocated_user = CompetitionStudent::where('instructor_id', $user->id)->pluck('user_id');
		$competition = Competition::where('status', 1)->orderBy('id', 'desc')->first();

        if($user->user_type_id==6)
        {
            $students = User::where('user_type_id',4)->whereNotIn('id',$allocated_user)->get();
        }
        else
        {
            $students = User::where('user_type_id',1)->whereNotIn('id',$allocated_user)->get();
        }
        $compStudents = CompetitionStudent::where('instructor_id', $instructor_id->id)->where('competition_controller_id', $competition->id)->paginate($this->pagination);


		return view('account.competition-students', compact('competition', 'compStudents', 'competition'));
	}

    public function delete_instructor_competition($id)
    {
        CompetitionStudent::where('id', $id)->delete();
        return redirect()->back()->with('success', __('constant.ALLOCATE_DELETED'));
    }

    public function edit_instructor_competition($id)
	{

        $user = $this->user;
        $students = User::where('user_type_id',1)->where('instructor_id',$user->id)->orderBy('id','desc')->get();
        $locations = LearningLocation::orderBy('title','asc')->get();
        $categories = CompetitionCategory::orderBy('id','desc')->get();
		$competition_student = CompetitionStudent::find($id);

        $competition = Competition::where('id', $competition_student->competition_controller_id)->first();
        if(!isset($competition))
        {
            abort(404);
        }
        $user = User::find($competition_student->user_id);
		//dd($user);
		return view('account.edit-competition-registration', compact('competition', 'students', 'competition_student','locations','categories','user'));
	}

    public function update_instructor_competition(Request $request,$id)
	{
        // dd($request->all());
        $users = User::find($this->user->id);

        $request->validate([
            'learning_location' => 'required',
            'category_id' => 'required',
        ]);
        $user = User::where('id', $request->user_id)->first();
        $user->mobile = $request->phone;
        $user->dob = $request->dob;
        $user->country_code_phone = $request->phone_code;
        $user->save();

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
        $todayDate = date('Y-m-d');
		$competition = Competition::where('status', 1)->whereDate('date_of_competition','>=',$todayDate)->where('id', $competition_id)->first();
        $allocated_user = CompetitionStudent::where('instructor_id', $user->id)->where('competition_controller_id',$competition_id)->pluck('user_id');
        if($user->user_type_id==6)
        {
            $students = User::where('user_type_id',4)->where('instructor_id',$user->id)->whereNotIn('id',$allocated_user)->get();
        }
        else
        {
            $students = User::whereIn('user_type_id',[1,2,3])->where('instructor_id',$user->id)->whereNotIn('id',$allocated_user)->get();
        }
        $locations = LearningLocation::orderBy('title','asc')->get();
        $categoryComp = CategoryCompetition::where('competition_id', $competition_id)->pluck('category_id')->toArray();
        $categories = CompetitionCategory::whereIn('id', $categoryComp)->orderBy('id','desc')->get();
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
            'category_id' => 'required',
        ]);


        $competitionStudent = new CompetitionStudent();
        $competitionStudent->user_id   = $request->user_id ?? NULL;
        $competitionStudent->competition_controller_id    = $id ?? NULL;
        $competitionStudent->instructor_id  = $this->user->id;   //Test /Survey
        $competitionStudent->learning_location  = $request->learning_locations ?? NULL;
        $competitionStudent->category_id  = $request->category_id ?? NULL;
        $competitionStudent->remarks  = $request->remarks ?? NULL;
        $competitionStudent->save();

        //			Admin email for new competition registration
			$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_COMPETITION_REGISTRATION'));
            $admins = Admin::get();

            if ($email_template) {
                $competitionExamDetail = Competition::where('id', $id)->first();
                $data = [];
                foreach($admins as $admin){
                    $data['email_sender_name'] = systemSetting()->email_sender_name;
                    $data['from_email'] = systemSetting()->from_email;
                    $data['to_email'] = [$admin->email];
                    $data['cc_to_email'] = [];
                    $data['subject'] = $email_template->subject;

                    $key = ['{{competition_exam}}'];
                    $value = [$competitionExamDetail->title ?? ''];

                    $newContents = str_replace($key, $value, $email_template->content);

                    $data['contents'] = $newContents;
                    try {
                        $mail = Mail::to($admin->email)->send(new EmailNotification($data));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }

            }

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

    public function instructor_content_update(Request $request)
    {
        $user = User::find($this->user->id);
        $user->instructor_content  = $request->instructor_content ?? NULL;
        $user->save();
        return redirect()->route('teaching-materials')->with('success', 'Content updated successfully.');
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
		// $actualCompetitionPaperSubted = CompetitionPaperSubmitted::where('user_id', $userId)->where('paper_type', 'actual')->groupBy('category_id')->groupBy('competition_id')->get();
		//dd($actualCompetitionPaperSubted);
        $actualCompetitionPaperSubted = CompetitionStudentResult::where('user_id', $userId)->orderBy('total_marks', 'desc')->get();
        //dd($actualCompetitionPaperSubted);
        $gradingExamResult = GradingStudentResults::where('user_id', $userId)->orderBy('total_marks', 'desc')->get();

        $achievementsOther = AchievementOther::where('user_id', $userId)->orderBy('total_marks', 'desc')->get();

        $collection = collect([$actualCompetitionPaperSubted, $gradingExamResult, $achievementsOther]);

        $merged = $collection->collapse();
        
        //$merged->paginate(10);

        //$merged = $actualCompetitionPaperSubted->merge($gradingExamResult)->sortByDesc('total_marks')->paginate(100);

        //$merged = $merged->merge($achievementsOther)->sortByDesc('total_marks')->paginate(10);
        //dd($merged);


        $merged = $merged->paginate(10);

        // $merged = $actualCompetitionPaperSubted->merge($gradingExamResult)->sortByDesc('total_marks')->get();

        // $merged = $merged->merge($achievementsOther)->sortByDesc('total_marks')->paginate(10);
        //dd($merged);


        //$result = $merged->all()->get()->paginate(1);

		return view("account.achievements", compact('actualCompetitionPaperSubted', 'gradingExamResult', 'merged'));
		//$competitionId =
	}

    public function my_achievements($id){
		$userId = $id;
		// $actualCompetitionPaperSubted = CompetitionPaperSubmitted::where('user_id', $userId)->where('paper_type', 'actual')->groupBy('category_id')->groupBy('competition_id')->get();
		//dd($actualCompetitionPaperSubted);
        $actualCompetitionPaperSubted = CompetitionStudentResult::where('user_id', $userId)->orderBy('id', 'desc')->get();
        //dd($actualCompetitionPaperSubted);
        $gradingExamResult = GradingStudentResults::where('user_id', $userId)->orderBy('id', 'desc')->get();

        $collection = collect([$actualCompetitionPaperSubted, $gradingExamResult, $achievementsOther]);

        $merged = $collection->collapse();
        $merged = $merged->paginate(10);

        // $merged = $actualCompetitionPaperSubted->merge($gradingExamResult)->sortByDesc('created_at')->paginate(10);
        //dd($merged);
        $user=User::find($id);

        //$result = $merged->all()->get()->paginate(1);

		return view("account.achievements", compact('actualCompetitionPaperSubted', 'gradingExamResult', 'merged','user'));
		//$competitionId =
	}


    public function view_grading($id){
		$userId = $id;
		// $actualCompetitionPaperSubted = CompetitionPaperSubmitted::where('user_id', $userId)->where('paper_type', 'actual')->groupBy('category_id')->groupBy('competition_id')->get();
		//dd($actualCompetitionPaperSubted);
        $actualCompetitionPaperSubted = CompetitionStudentResult::where('user_id', $userId)->orderBy('id', 'desc')->get();
        //dd($actualCompetitionPaperSubted);
        $gradingExamResult = GradingStudentResults::where('user_id', $userId)->orderBy('id', 'desc')->get();

        $merged = $actualCompetitionPaperSubted->merge($gradingExamResult)->sortByDesc('created_at')->paginate(10);
		return view("account.achievements", compact('actualCompetitionPaperSubted', 'merged'));
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
            $paper = GradingPaper::where('id', $request->paper)->first();
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
    elseif($request->type == 'physicalgrading'){
        foreach($request->paper as $value){
            $paper = GradingPaper::where('id', $value)->first();
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

		//return view('account.cart', compact("cartDetails"));
        return redirect()->back();
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

    public function downloadPass($id = null, $user_id = null){
        $pass = ExaminationPass::where('type', 1)->first();
        $competition = Competition::where('id', $id)->first();
        $user = User::where('id', $user_id)->first();
        $weekDat = date('l', strtotime($competition->date_of_competition));
        $dateFor = date('d F Y', strtotime($competition->date_of_competition));
        $competitionDate = $dateFor . ', '.$weekDat;
        $examPass = CompetitionPassUpload::where('competition_id', $id)->where('student_id', $user->account_id)->first();
        // if($competition->start_time_of_competition <= 12){
        //     $compTime = $competition->start_time_of_competition . ' AM';
        // }else{
        //     $compTime = $competition->start_time_of_competition . ' PM';
        // }
        $logo='<img style="width: 120px;" src="http://abacus.verz1.com/storage/site_logo/20230522101759_3g-abacus-logo.png" alt="abacus" />';
        $key = ['{{competition_name}}','{{student_name}}','{{exam_date}}','{{logo}}', '{{competition_venue}}','{{student_id}}','{{dob}}','{{seat_no}}','{{reporting_time}}','{{competition_time}}','{{venue_arrangement}}'];
        $value = [$competition->title, $user->name, $competitionDate, $logo, $examPass->competition_venue, $examPass->student_id,$examPass->dob,$examPass->seat_no,$examPass->reporting_time,$examPass->competition_time,$examPass->venue_arrangement];
        $newContents = str_replace($key, $value, $pass->content);
        $pdf = PDF::loadView('account.competition_pass', compact('newContents'))->setPaper('a4', 'landscape');
        return $pdf->download('competition-pass.pdf');
    }

    public function downloadPass2($id = null, $user_id = null){
        $pass = ExaminationPass::where('type', 2)->first();
        $grading = GradingExam::where('id', $id)->first();
        $user = User::where('id', $user_id)->first();
        $examPass = GradingPassUpload::where('competition_id', $id)->where('student_id', $user->account_id)->first();

        

        //dd($examPass);
        // if($grading->start_time_of_competition <= 12){
        //     $start_time_of_competition = $grading->start_time_of_competition . ' AM';
        // }else{
        //     $start_time_of_competition = $grading->start_time_of_competition-12 . ' PM';
        // }

        // if($grading->end_time_of_competition <= 12){
        //     $end_time_of_competition = $grading->end_time_of_competition . ' AM';
        // }else{
        //     $end_time_of_competition = $grading->end_time_of_competition-12 . ' PM';
        // }
        if(isset($examPass))
        {
            $weekDat = date('l', strtotime($examPass->competition_date));
            $dateFor = date('d F Y', strtotime($examPass->competition_date));
            $competitionDate = $dateFor . ', '.$weekDat;
            // $compTime=$start_time_of_competition.' - '.$end_time_of_competition;
            $logo='<img style="width: 120px;" src="http://abacus.verz1.com/storage/site_logo/20230522101759_3g-abacus-logo.png" alt="abacus" />';
            // $key = ['{{grading_name}}','{{student_name}}','{{exam_date}}','{{exam_venue}}','{{exam_time}}','{{logo}}'];
            // $value = [$grading->title, $user->name, date('j F Y, l',strtotime($grading->date_of_competition)), $grading->exam_venue, $compTime,$logo];

            $key = ['{{grading_name}}','{{student_name}}','{{exam_date}}','{{logo}}', '{{competition_venue}}','{{student_id}}','{{dob}}','{{mental_seat_no}}','{{abacus_seat_no}}','{{reporting_time}}','{{competition_time}}','{{venue_arrangement}}'];
            $value = [$grading->title, $user->name, $competitionDate, $logo, $examPass->competition_venue, $examPass->student_id,$examPass->dob,$examPass->mental_seat_no,$examPass->abacus_seat_no,$examPass->reporting_time,$examPass->competition_time,$examPass->venue_arrangement];

            $newContents = str_replace($key, $value, $pass->content);
            $pdf = PDF::loadView('account.grading_pass', compact('newContents'))->setPaper('a4', 'landscape');
            return $pdf->download('grading-pass.pdf');
        }
        else{
            return redirect()->back()->with('error', 'Examination Pass not found');
        }
    }
}
