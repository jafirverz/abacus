<?php

namespace App\Imports;

use App\Competition;
use App\CompetitionPassUpload;
use App\CompetitionStudent;
use App\CompetitionStudentResult;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportCompetitionPass implements ToCollection, WithHeadingRow
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
          $competitionn = Competition::where('id', $this->competition)->first();
          $CompetitionPassUpload = new CompetitionPassUpload();
          $CompetitionPassUpload->competition_id =  $this->competition;
          $CompetitionPassUpload->category_id =  $this->category;
          $CompetitionPassUpload->competition_date =  $competitionn->date_of_competition;
          $CompetitionPassUpload->competition_venue =  $row['competition_venue'];
          $CompetitionPassUpload->student_name =  $row['student_name'];
          $CompetitionPassUpload->student_id =  $row['student_id'];
          $CompetitionPassUpload->dob =  $row['dob'];
          $CompetitionPassUpload->seat_no =  $row['seat_no'];
          $CompetitionPassUpload->reporting_time =  $row['reporting_time'];
          $CompetitionPassUpload->competition_time =  $row['competition_time'];
          $CompetitionPassUpload->venue_arrangement =  $row['venue_arrangement'];
          $CompetitionPassUpload->save();
        }
    }
}
