<?php

namespace App\Http\Controllers;

use App\GradingExam;
use App\GradingPaper;
use App\GradingExamList;
use App\GradingSubmitted;
use App\Certificate;
use App\GradingCategory;
use PDF;
use App\GradingQuestionSubmitted;
use App\GradingPaperQuestion;
use App\GradingStudent;
use App\GradingStudentResults;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class GradingSubmitController extends Controller
{
    //
    public function index(){

    }

    public function resultpage(Request $request){
        $grading_exam_id = $request->grading_exam_id;
        $listing_id = $request->listing_id;
        $paper_id = $request->paper_id;
        $questionTypeId = $request->question_type;
        $userId = Auth::user()->id;
        $questTem = array(1,2,3,4,5,6,7,8);
        $resultpage = array(1,2,3,4,5,6,7,8);
        if(in_array($questionTypeId, $questTem)){
            $gradeSub = new GradingSubmitted();
            $gradeSub->grading_exam_id  = $grading_exam_id;
            $gradeSub->paper_id = $paper_id;
            $gradeSub->question_template_id = $questionTypeId;
            $gradeSub->user_id = $userId;
            $gradeSub->certificate_id = __('constant.CERTIFICATE_GRADING_ID');
            $gradeSub->save();
            $totalMarks = 0;
            $userMarks = 0;

            foreach($request->answer as $key=>$value){
                $quesSub = new GradingQuestionSubmitted();
                $gradingPaperQuestion = GradingPaperQuestion::where('id', $key)->first();
                $quesSub->grading_submitted_id  = $gradeSub->id;
                $quesSub->question_id = $key;
                $quesSub->question_answer = $gradingPaperQuestion->answer;
                //dd($gradingPaperQuestion);
                $quesSub->user_answer = $value;
                $quesSub->marks = $gradingPaperQuestion->marks;
                if($value == $gradingPaperQuestion->answer){
                    $quesSub->user_marks = $gradingPaperQuestion->marks;
                    $userMarks+= $gradingPaperQuestion->marks;
                }else{
                    $quesSub->user_marks = null;
                }
                $totalMarks+= $gradingPaperQuestion->marks;
                $quesSub->save();
            }
            $saveResult = GradingSubmitted::where('id', $gradeSub->id)->first();
            $saveResult->total_marks = $totalMarks;
            $saveResult->user_marks = $userMarks;
            $saveResult->save();
        }
        if(in_array($questionTypeId, $resultpage)){
            return view('result-grade', compact('totalMarks', 'userMarks'));
        }


    }

    public function downloadCertificate( $id = null){
        $gradingStudentResult = GradingStudentResults::where('id', $id)->first();
        $gradingExamId = GradingExam::where('id', $gradingStudentResult->grading_id)->first();
        
        //dd($gradingExamId);
        if($gradingExamId->competition_type=='physical'){
            $gradingStudent = GradingStudent::where('user_id', $gradingStudentResult->user_id)->where('grading_exam_id', $gradingStudentResult->grading_id)->first();
            $mentalGrade = $gradingStudent->mental_grade;
            $abacusGrade = $gradingStudent->abacus_grade;
            $mentalCagtegory = GradingCategory::where('id', $mentalGrade)->first();
            $abacusCagtegory = GradingCategory::where('id', $abacusGrade)->first();
            $cat = array();
            array_push($cat, $mentalCagtegory->category_name);
            array_push($cat, $abacusCagtegory->category_name);
            $category = implode(', ', $cat);
            //$category = $mentalCagtegory->category_name ?? '' . "," . $abacusCagtegory->category_name ?? '';
            //$GradingSubmitted = GradingSubmitted::where('id', $id)->first();
            $date_of_issue=date('j F Y',strtotime($gradingExamId->created_at));
            $certificate = Certificate::where('id', 4)->first();
            $logo='<img style="width: 320px;" src="http://abacus.verz1.com/storage/site_logo/20230522101759_3g-abacus-logo.png" alt="abacus" />';
            $logoFoot='<img style="width: 250px"  src="http://abacus.verz1.com/storage/images/1702371736__65782198b8449__3g-abacus-foot.png" alt="abacus" />';
            $bg1 = 'http://abacus.verz1.com/images/bg-certificate-4.jpg';
            $bg = '<div style="background: url('.$bg1.') no-repeat center center; background-size: contain; color: #000; font-family: NotoSans, Arial; font-size: 16px; line-height: 1.4; margin: 0 auto; max-width: 100%">';
    
            $key = ['{{grading_name}}','{{full_name}}','{{dob}}','{{category}}','{{date_of_issue}}','{{logo}}','{{logofoot}}', '{{$bg}}'];
            $value = [$gradingExamId->title, Auth::user()->name,  Auth::user()->dob, $category, $date_of_issue, $logo, $logoFoot,$bg];
            $newContents = str_replace($key, $value, $certificate->content);
        }else{
            $GradingSubmitted = GradingSubmitted::where('id', $id)->first();
            $date_of_issue=date('j F Y',strtotime($GradingSubmitted->created_at));
            $certificate = Certificate::where('id', $GradingSubmitted->certificate_id)->first();
            $logo='<img style="width: 320px;" src="http://abacus.verz1.com/storage/site_logo/20230522101759_3g-abacus-logo.png" alt="abacus" />';
            $logoFoot='<img style="width: 250px"  src="http://abacus.verz1.com/storage/images/1702371736__65782198b8449__3g-abacus-foot.png" alt="abacus" />';
            $bg1 = 'http://abacus.verz1.com/images/bg-certificate-4.jpg';
            $bg = '<div style="background: url('.$bg1.') no-repeat center center; background-size: contain; color: #000; font-family: NotoSans, Arial; font-size: 16px; line-height: 1.4; margin: 0 auto; max-width: 100%">';
    
            $key = ['{{grading_name}}','{{full_name}}','{{dob}}','{{category}}','{{date_of_issue}}','{{logo}}','{{logofoot}}', '{{$bg}}'];
            $value = [$GradingSubmitted->grade->title, Auth::user()->name,  Auth::user()->dob, $GradingSubmitted->gcategory->category_name, $date_of_issue, $logo, $logoFoot,$bg];
            $newContents = str_replace($key, $value, $certificate->content);
        }
        
        $pdf = PDF::loadView('account.certificate_pdf', compact('newContents'))->setPaper('a4', 'landscape');
        return $pdf->download('certificate.pdf');
    }
}
