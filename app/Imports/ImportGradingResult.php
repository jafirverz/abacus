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
    {       dd($rows->all());
        foreach($rows->all() as $row)
        {

            $studentName = $row['candidate_name'];
            $instructorName = $row['instructor'];
            $checkInstructorName = User::where('name', $instructorName)->where('user_type_id', 5)->first();
            if($checkInstructorName)
            {
                $checkUserName = User::where('name', $studentName)->where('instructor_id', $checkInstructorName->id)->first();
                if($checkUserName)
                {
                    $gradingStudentResults = new GradingStudentResults();
                    $gradingStudentResults->grading_id  =  $this->grading_id;
                    $gradingStudentResults->user_id =  $checkUserName->id;
                    $gradingStudentResults->total_marks =  $row['total_marks'];
                    $gradingStudentResults->rank =  $row['rank'];
                    $gradingStudentResults->save();
                }
            }
        }
    }
}
