<?php

namespace App\Imports;

use App\CompetitionStudent;
use App\CompetitionStudentResult;
use App\TempStudentCompetitionResult;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TempImportCompetitionResult implements ToCollection, WithHeadingRow
{
    private $category;
    private $competition;
    private $uploadId;
    public function __construct(int $competition, int $category, int $uploadId) 
    {
        $this->category = $category;
        $this->competition = $competition;
        $this->uploadId = $uploadId;
    }
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach($rows->all() as $row) {
            $studentName = $row['candidate_name'];
            $instructorName = $row['instructor'];
            $checkInstructorName = User::where('name', $instructorName)->where('user_type_id', 5)->first();
            if($checkInstructorName){
                $checkUserName = User::where('name', $studentName)->where('instructor_id', $checkInstructorName->id)->first();
                if($checkUserName){
                    $compStudentResult = new TempStudentCompetitionResult();
                    $compStudentResult->cru_id =  $this->uploadId;
                    $compStudentResult->competition_id =  $this->competition;
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