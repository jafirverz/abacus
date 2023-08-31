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
                    
                    @foreach($merged as $paperSubmited)
                    <tr>
                      <td class="tbico-1"><img src="images/tempt/ico-award.png" alt="awrad" /></td>
                      <td><strong class="type-1">@if(isset($paperSubmited->grading_id)) {{ $paperSubmited->grading->exam_date }} @else {{ $paperSubmited->competition->date_of_competition }} @endif

                      </strong></td>
                      <td>@if(isset($paperSubmited->grading_id)) {{ $paperSubmited->grading->title }} @else {{ $paperSubmited->competition->title }} @endif</td>
                      <td>
                        @if(isset($paperSubmited->grading_id)) 
                          @if(!empty($paperSubmited->abacus_grade && $paperSubmited->mental_grade))
                          Mental Grade 70:  <strong class="type-1"></strong><br/>
                          Abacus Grade 80:  <strong class="type-1"></strong></td>
                          @endif
                        @else 
                        {{ $paperSubmited->category->category_name }} : {{ $paperSubmited->rank ?? '' }}
                          @if(!empty($paperSubmited->abacus_grade && $paperSubmited->mental_grade))
                          Mental Grade 70:  <strong class="type-1"></strong><br/>
                          Abacus Grade 80:  <strong class="type-1"></strong></td>
                          @endif
                        @endif

                    </tr>
                    @endforeach

                    
                    
                  </tbody>
                </table>
              </div>
              <ul class="page-numbers mt-30">
               {{ $merged->links() }}
              </ul>
            </div>
          </div>
        </div>
    </div>
</main>
@endsection
