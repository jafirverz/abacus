<?php

namespace App\Imports;

use App\GradingListingDetail;
use App\GradingSubmitted;
use App\GradingStudentResults;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportGradingResult implements ToCollection, WithHeadingRow
{
    private $grading_id;
    public function __construct(int $grading_id)
    {
        $this->grading_id = $grading_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {   //dd($rows->all());
        foreach($rows->all() as $row)
        {

            $studentName = $row['name'];
            $account_id = $row['account_id'];
            $checkUserName = User::where('account_id', $account_id)->first();
            if($checkUserName)
            {
                    //dd($row);
                    $gradingStudentResults = new GradingStudentResults();
                    $gradingStudentResults->grading_id  =  $this->grading_id;
                    //$gradingStudentResults->category_id  =  $category;
                    $gradingStudentResults->user_id =  $checkUserName->id;
                    //$gradingStudentResults->total_marks =  $row['marks'];
                    //$gradingStudentResults->rank =  $row['rank'];
                    $gradingStudentResults->result =  $row['result_instructorfe'];
                   // $gradingStudentResults->remark_grade =  $row['passfail'];
                    $gradingStudentResults->abacus_grade =  $row['abacus_grade'];
                    $gradingStudentResults->mental_results =  $row['mental_results'];
                    $gradingStudentResults->abacus_results =  $row['abacus_results'];
                    $gradingStudentResults->mental_result_passfail =  $row['mental_result_passfail'];
                    $gradingStudentResults->abacus_result_passfail =  $row['abacus_result_passfail'];
                    $gradingStudentResults->mental_grade =  $row['mental_grade'];
                    $gradingStudentResults->certificate_id =isset($row['certificate_id']) ?? NULL;

                    if(isset($row['certificate_id']) && $row['certificate_id']!='')
                    {
                    //dd($row['certificate_id']);
                    $gradingSub = GradingSubmitted::where('grading_exam_id',$this->grading_id)->where('user_id',$checkUserName->id)->first();
                    //dd($this->paper_id);
                        if(isset($gradingSub))
                        {
                            $gradingSub->certificate_id =  $row['certificate_id'];
                            $gradingSub->save();
                        }

                    }

                    $gradingStudentResults->save();

            }
        }
    }
}
