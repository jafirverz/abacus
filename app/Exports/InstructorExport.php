<?php

namespace App\Exports;

use App\User;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InstructorExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $allUsers;

    public function __construct($allUsers)
    {
        $this->allUsers = $allUsers;
    }
    public function view(): View
    {
        // $training_request = AppTrainingRequest::join('users', 'users.id', '=', 'training_requests.staff_id')->whereIn('training_requests.id', $this->allUsers)->orderBy('training_requests.updated_at', 'desc')->select('training_requests.created_at as training_requests_created_at', 'training_requests.id as training_request_id', 'training_requests.*', 'users.*')->get();
        $allUsers = $this->allUsers;

        return view('admin.excel.instructor', compact('allUsers'));
    }


    // public function collection()
    // {
    //     return User::all();
    // }
}
