@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
              @if(Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2)
                @include('inc.account-sidebar')
              @endif

        </div>
        <div class="col-lg-9 sp-col tempt-2-inner">
          <div class="tempt-2-content">
            <h1 class="title-3">My Achievements</h1>
            <div class="box-1">
              <div class="xscrollbar">
                <table class="tb-1">
                  <thead>
                    <tr>
                      <th>&nbsp;</th>
                      <th>Year</th>
                      <th>Events</th>
                      <th>Results</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($actualCompetitionPaperSubted as $paperSubmited)
                    <tr>
                      <td class="tbico-1"><img src="images/tempt/ico-award.png" alt="awrad" /></td>
                      <td><strong class="type-1">{{ $paperSubmited->competition->date_of_competition }}</strong></td>
                      <td>{{ $paperSubmited->competition->title }}</td>
                      <td>
                        {{ $paperSubmited->category->category_name }} : {{ $paperSubmited->rank ?? '' }}
                        @if(!empty($paperSubmited->abacus_grade && $paperSubmited->mental_grade))
                        Mental Grade 70:  <strong class="type-1"></strong><br/>
                        Abacus Grade 80:  <strong class="type-1"></strong></td>
                        @endif

                    </tr>
                    @endforeach

                    @foreach($gradingExamResult as $grading)
                    <tr>
                      <td class="tbico-1"><img src="images/tempt/ico-award.png" alt="awrad" /></td>
                      @php 
                      $aa = explode(" ", $grading->grading->exam_date);
                      @endphp
                      <td><strong class="type-1">{{ $aa[0] }}</strong></td>
                      <td>{{ $grading->grading->title }}</td>
                      <td>
                        
                        @if(!empty($grading->abacus_grade && $grading->mental_grade))
                        Mental Grade 70:  <strong class="type-1">{{ $grading->mental_grade }}</strong><br/>
                        Abacus Grade 80:  <strong class="type-1">{{ $grading->abacus_grade }}</strong></td>
                        @else
                        {{ $grading->category->category_name ?? '' }} : {{ $grading->rank ?? '' }}
                        @endif

                    </tr>
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
              <!-- <ul class="page-numbers mt-30">
                <li><a class="prev" href="#">prev</a></li>
                <li><a href="#">1</a></li>
                <li><a class="current" href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a class="next" href="#">next</a></li>
              </ul> -->
            </div>
          </div>
        </div>
    </div>
</main>
@endsection
