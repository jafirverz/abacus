<?php

namespace App\Exports;

use App\User;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CompetetitionStudentExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $allItems;

    public function __construct($allItems)
    {
        $this->allItems = $allItems;
    }
    public function view(): View
    {
        // $training_request = AppTrainingRequest::join('users', 'users.id', '=', 'training_requests.staff_id')->whereIn('training_requests.id', $this->allUsers)->orderBy('training_requests.updated_at', 'desc')->select('training_requests.created_at as training_requests_created_at', 'training_requests.id as training_request_id', 'training_requests.*', 'users.*')->get();
        $allItems = $this->allItems;

        return view('admin.excel.competition-students', compact('allItems'));
    }


    // public function collection()
    // {
    //     return User::all();
    // }
}
