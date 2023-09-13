<?php

namespace App\Imports;

use App\GradingStudent;
use App\GradingResultsUpload;
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

                    $gradingStudentResults = new GradingStudentResults();
                    $gradingStudentResults->grading_id  =  $this->grading_id;
                    $gradingStudentResults->user_id =  $checkUserName->id;
                    $gradingStudentResults->total_marks =  $row['marks'];
                    $gradingStudentResults->rank =  $row['rank'];
                    $gradingStudentResults->result =  $row['result'];
                    $gradingStudentResults->remark_grade =  $row['passfail'];
                    $gradingStudentResults->abacus_grade =  $row['abacus_grade'];
                    $gradingStudentResults->mental_grade =  $row['mental_grade'];
                    $gradingStudentResults->certificate_id =  $row['certificate_id'];
                    $gradingStudentResults->save();

            }
        }
    }
}
