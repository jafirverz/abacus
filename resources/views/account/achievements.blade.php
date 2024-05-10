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

            <div class="mb-20">
                <a class="link-1 lico" onclick="window.history.go(-1); return false;" href="javascript:void();"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
            </div>

            <h1 class="title-3">@if(isset($user->name)) {{ $user->name }} > My Achievements @else My Achievements @endif </h1>
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
                    @if(isset($merged) && count($merged)>0)
                    @foreach($merged as $paperSubmited)
                    <tr>
                      <td class="tbico-1"><img src="{{ asset('images/tempt/ico-award.png') }}" alt="awrad" /></td>
                      <td><strong class="type-1">@if(isset($paperSubmited->grading_id)) {{ $paperSubmited->grading->date_of_competition }} @elseif(isset($paperSubmited->title)) {{ $paperSubmited->competition_date ?? '' }} @else {{ $paperSubmited->competition->date_of_competition ?? '' }} @endif

                      </strong></td>
                      <td>@if(isset($paperSubmited->grading_id)) {{ $paperSubmited->grading->title ?? '' }} @elseif(isset($paperSubmited->title)) {{ $paperSubmited->title ?? '' }} @else {{ $paperSubmited->competition->title ?? '' }} @endif</td>
                      <td>
                        @if(isset($paperSubmited->grading_id))
                          @if(!empty($paperSubmited->abacus_grade || $paperSubmited->mental_grade))
                          {{ $paperSubmited->mental_grade }}:  <strong class="type-1">{{ $paperSubmited->mental_results ?? '' }} ({{ $paperSubmited->mental_result_passfail ?? '' }})</strong><br/>
                          {{ $paperSubmited->abacus_grade }}:  <strong class="type-1">{{ $paperSubmited->abacus_results ?? '' }} ({{ $paperSubmited->abacus_result_passfail ?? '' }})</strong></td>
                          @endif
                        @elseif(isset($paperSubmited->title)) {!! $paperSubmited->result ?? '' !!}
                        @else
                        {{ $paperSubmited->category->category_name ?? '' }} : {{ $paperSubmited->rank ?? '' }}
                          @if(!empty($paperSubmited->abacus_grade && $paperSubmited->mental_grade))
                          {{--Mental Grade 70:  <strong class="type-1">{{ $paperSubmited->mental_grade }}</strong><br/>
                          Abacus Grade 80:  <strong class="type-1">{{ $paperSubmited->abacus_grade }}</strong></td>--}}
                          {{ $paperSubmited->mental_grade }}:  <strong class="type-1">{{ $paperSubmited->mental_results ?? '' }} ({{ $paperSubmited->mental_result_passfail ?? '' }})</strong><br/>
                          {{ $paperSubmited->abacus_grade }}:  <strong class="type-1">{{ $paperSubmited->abacus_results ?? '' }} ({{ $paperSubmited->abacus_result_passfail ?? '' }})</strong></td>
                          @endif
                        @endif

                    </tr>
                    @endforeach
                    @endif


                  </tbody>
                </table>
              </div>
              @if(isset($merged) && count($merged)>0)
              <ul class="page-numbers mt-30">
               {{ $merged->links() ?? '' }}
              </ul>
              @endif
            </div>
          </div>
        </div>
    </div>
</main>
@endsection
