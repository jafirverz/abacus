<?php

namespace App\Imports;

use App\Competition;
use App\CompetitionStudent;
use App\CompetitionStudentResult;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportCompetitionResult implements ToCollection, WithHeadingRow
{
    private $category;
    private $competition;
    public function __construct(int $competition, int $category) 
    {
        $this->category = $category;
        $this->competition = $competition;
    }
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach($rows->all() as $row) {
            $studentName = trim($row['candidate_name']);
            $student_id = trim($row['student_id']);
            $instructor_code = trim($row['instructor_code']);
            $instructorName = trim($row['instructor']);
            $checkInstructorName = User::where('account_id', $instructor_code)->where('user_type_id', 5)->first();
            if($checkInstructorName){
                $checkUserName = User::where('account_id', $student_id)->where('instructor_id', $checkInstructorName->id)->first();
                if($checkUserName){
                    $competitionn = Competition::where('id', $this->competition)->first();
                    $compStudentResult = new CompetitionStudentResult();
                    $compStudentResult->competition_id =  $this->competition;
                    $compStudentResult->competition_date =  $competitionn->date_of_competition;
                    $compStudentResult->category_id =  $this->category;
                    $compStudentResult->user_id =  $checkUserName->id;
                    $compStudentResult->total_marks =  $row['total_marks'];
                    $compStudentResult->rank =  $row['rank'];
                    $compStudentResult->prize =  $row['prize'];
                    $compStudentResult->certificate_id =  $row['certificate_id'];
                    $compStudentResult->save();
                }
            }
        }
    }
}
