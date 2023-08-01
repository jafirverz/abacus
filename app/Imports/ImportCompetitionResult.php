<?php

namespace App\Imports;

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
            //dd($row);
            $studentName = $row['candidate_name'];
            $instructorName = $row['instructor'];
            $checkInstructorName = User::where('name', $instructorName)->where('user_type_id', 5)->first();
            if($checkInstructorName){
                $checkUserName = User::where('name', $studentName)->where('instructor_id', $checkInstructorName->id)->first();
                if($checkUserName){
                    $compStudentResult = new CompetitionStudentResult();
                    $compStudentResult->competition_id =  $this->competition;
                    $compStudentResult->category_id =  $this->category;
                    $compStudentResult->user_id =  $checkUserName->id;
                    $compStudentResult->total_marks =  $row['total_marks'];
                    $compStudentResult->rank =  $row['rank'];
                    $compStudentResult->save();
                }
            }
        }
    }
}
