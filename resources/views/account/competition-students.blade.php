@extends('layouts.app')
@section('content')

<main class="main-wrap">	
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      <div class="menu-aside">
        <h3>My Dashboard</h3>
        @include('inc.intructor-account-sidebar')
      </div>
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">	
        <div class="row title-wrap-1">
          <div class="col-md-6 order-md-last mt-0 lastcol">
            <a class="btn-1" href="#">Register for Competition <i class="fa-solid fa-arrow-right-long"></i></a>
          </div>
          <div class="col-md-6 order-md-first mt-767-20">
            <h1 class="title-3">Competitions</h1>
          </div>
        </div>
        <div class="box-1">
          <h2 class="title-4">Registered Student's List</h2>
          <div><strong>Exam Title: {{ $competition->title }}</strong></div>
          <div class="xscrollbar mt-30">
            <table class="tb-2 tbtype-4">
              <thead>
                <tr class="text-uppercase">
                  <th>NO.</th>
                  <th>Student Name</th>
                  <th>Registered <br/>CATEGORY</th>
                  <th>Status <button type="button" class="btn-tooltip ml-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="For Pending instructor cal still change the grade. Once Approved, instructor cannot chanage grade, only superadmin can change."><i class="icon-info"></i></button></th>
                  <th>Remark <button type="button" class="btn-tooltip ml-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Lorem ipsum dolor sit amet consetetur"><i class="icon-info"></i></button></th>
                  <th>Result</th>
                </tr>
              </thead>
              <tbody>
                @foreach($compStudents as $student)
                <tr>
                  <td><em>001</em></td>
                  <td>
                    <em>{{ $student->userlist->name }}</em>
                    <div class="tbactions"><a href="#">Edit</a> <a href="be-teacher-dashboard-competitions-details.html">View</a> <a href="#">Competition Pass</a></div>
                  </td>
                  <td><em>Super Degree</em></td>
                  <td><em class="status-2">@if($student->approve_status == 1) Approved @else Not Apporved @endif</em></td>
                  <td><em>Lorem ipsum </em></td>
                  <td><em>Lorem ipsum </em></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <ul class="page-numbers mt-30">
            {{ $compStudents->links() }}
          </ul>
        </div>
      </div>
    </div>
  </div>	
</main>




@endsection
