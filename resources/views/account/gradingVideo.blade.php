@extends('layouts.app')
@section('content')

<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      @if(Auth::user()->user_type_id == 1)
        @include('inc.account-sidebar')
      @endif
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <div class="mb-20">
          <a class="link-1 lico" href="be-overview-preparatory.html"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <ul class="breadcrumb bctype">
          <li><a href="{{ url('home') }}">Overview</a></li>
          <li><strong>{{ $gradingExam->title }}</strong></li>
        </ul>
        <div class="box-1">
            {!! $gradingExam->important_note !!}
        </div>
        <div class="shuffle-wrap">
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i class="icon-info"></i></button> <strong><a href="?s=1">Shuffle the Questions <i class="icon-shuffle"></i></a></strong></div>
        </div>
        <form method="post" action="{{ route('grading_answer.submit') }}">
          @csrf
        <div class="row grid-5">
            <input type="hidden" name="grading_exam_id" value="{{ $grading_exam_id }}">
            <input type="hidden" name="listing_id" value="{{ $listing_id }}">
            <input type="hidden" name="paper_id" value="{{ $paper->listing_paper_id }}">
            <input type="hidden" name="question_type" value="{{ $paper->question_type }}">
          @php

          $k=0;
          $i = 1;
          foreach($paper->questionsGrade as $question){
          @endphp
          <div class="col-lg-4 col-md-6">
            <div class="inner">
              <strong class="number">Q{{ $i }}</strong>
              <div class="vdwrap">
                <video width="400">
                  <source src="{{ url('/upload-file/'.$question->input_1) }}" type="video/mp4">
                  Your browser does not support HTML video.
                </video>
                <a class="link-fix" data-fancybox href="{{ url('/upload-file/'.$question->input_1) }}"><i class="fa-solid fa-play"></i></a>
              </div>
              <textarea class="form-control" rows="3" cols="30" name="answer[{{ $question->id }}]" placeholder="Answer"></textarea>
            </div>
          </div>
          @php
          $i++;
          $k++;
          }
          @endphp


        </div>
        <div class="output-1">
          <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
        </div>
      </form>

      </div>
    </div>
  </div>
</main>
@endsection
