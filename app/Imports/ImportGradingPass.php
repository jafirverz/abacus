<?php

namespace App\Imports;

use App\Competition;
use App\CompetitionPassUpload;
use App\CompetitionStudent;
use App\CompetitionStudentResult;
use App\GradingExam;
use App\GradingPassUpload;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportGradingPass implements ToCollection, WithHeadingRow
{
    private $category;
    private $competition;
    public function __construct(int $competition) 
    {
        //$this->category = $category;
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
          $competitionn = GradingExam::where('id', $this->competition)->first();
          $CompetitionPassUpload = new GradingPassUpload();
          $user = User::where('account_id', $row['student_id'])->first();
          $CompetitionPassUpload->competition_id =  $this->competition;
          //$CompetitionPassUpload->category_id =  $this->category;
          $CompetitionPassUpload->competition_date =  $competitionn->date_of_competition;
          $CompetitionPassUpload->competition_venue =  $row['exam_venue'];
          $CompetitionPassUpload->student_name =  $row['student_name'];
          $CompetitionPassUpload->student_id =  $row['student_id'];
          $CompetitionPassUpload->dob =  $user->dob;
          $CompetitionPassUpload->mental_seat_no =  $row['mental_seat_no'];
          $CompetitionPassUpload->abacus_seat_no =  $row['abacus_seat_no'];
          $CompetitionPassUpload->reporting_time =  $row['reporting_time'];
          $CompetitionPassUpload->competition_time =  $row['exam_time'];
          $CompetitionPassUpload->venue_arrangement =  $row['venue_arrangement'];
          $CompetitionPassUpload->save();
        }
    }
}
