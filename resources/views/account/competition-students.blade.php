@extends('layouts.app')
@section('content')

<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      <div class="menu-aside">
           @if(Auth::user()->user_type_id == 6)
             @include('inc.account-sidebar-external')
            @else
            @include('inc.intructor-account-sidebar')
            @endif
      </div>
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <div class="row title-wrap-1">
          <div class="col-md-6 order-md-last mt-0 lastcol">
            @if($competition)
            <a class="btn-1" href="{{ route('instructor.register',$competition->id) }}">Register for Competition <i class="fa-solid fa-arrow-right-long"></i></a>
            @endif
        </div>
          <div class="col-md-6 order-md-first mt-767-20">
            <h1 class="title-3">Competitions</h1>
          </div>
        </div>
        @include('inc.messages')
        <div class="box-1">
          <h2 class="title-4">Registered Student's List</h2>
          <div><strong>Exam Title: {{ $competition->title ?? '' }}</strong></div>
          <div class="dateinfo mt-10"><i class="fa-solid fa-calendar-days ico"></i> {{ date('d/m/Y',strtotime( $competition->date_of_competition)) }}</div>
          <div class="xscrollbar mt-30">
            <table class="tb-2 tbtype-4">
              <thead>
                <tr class="text-uppercase">
                  <th>NO.</th>
                  <th>Student Name</th>
                  <th>Registered <br/>CATEGORY</th>
                  <th>Status <button type="button" class="btn-tooltip ml-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="For Pending instructor cal still change the grade. Once Approved, instructor cannot chanage grade, only superadmin can change."><i class="icon-info"></i></button></th>

                  <th>Remark <button type="button" class="btn-tooltip ml-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="This section is for any additional notes or insights you may have for a specific student regarding their grade or any of their course requirements"><i class="icon-info"></i></button></th>

                  <th>Result</th>
                </tr>
              </thead>
              <tbody>
                @php $i=0; @endphp
                @foreach($compStudents as $student)
                @php
                $i++;


                $userCompetition = \App\CompetitionStudentResult::where('user_id',$student->userlist->id)->where('competition_id', $student->competition_controller_id)->first();

                @endphp
                <tr>
                  <td><em>@if(isset($_REQUEST['page'])){{ sprintf('%03d', 15*($_REQUEST['page']-1)+$i) }}@else {{ $i }} @endif</em></td>
                  <td>
                    <em>{{ $student->userlist->name }}</em>
                    <div class="tbactions"><a href="{{ route('competition.instructor.register.edit',$student->id) }}">View</a> @if($student->approve_status != 1) <a onclick="return confirm('Are you sure want to delete this?');" href="{{ route('competition.instructor.register.delete',$student->id) }}">Delete</a>@endif</div>
                  </td>
                  <td><em>{{ $student->category->category_name ?? '' }}</em></td>
                  <td>@if($student->approve_status == 1) <em class="status-2">Approved</em> @else <em class="status-3">Not Apporved</em> @endif</td>
                  <td><em>{{ $student->remarks ?? '' }} </em></td>
                  <td><em>{{ $userCompetition->result ?? '' }}</em></td>
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
