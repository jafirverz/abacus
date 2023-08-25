@extends('layouts.app')
@section('content')
<main class="main-wrap">	
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      <div class="menu-aside">
        @include('inc.account-sidebar-online')
      </div>
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">							
        <h1 class="title-3">Feedback/ Contact Us</h1>
        <div>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</div>

        @include('inc.messages')
        
        <div class="box-1">
          <form name="feedback" method="post" action="{{ route('feedback.submit') }}">
            @csrf
          <div class="row sp-col-xl-30">
            <div class="col-xl-6 sp-col">
              <label class="lb-1">Full Name</label>
              <input class="form-control" type="text" value="{{ Auth::user()->name }}" disabled />
              <label class="lb-1">Email</label>
              <input class="form-control" type="text" value="{{ Auth::user()->email }}" disabled />
              <label class="lb-1">Phone</label>
              <div class="row sp-col-10">
                <div class="col-auto sp-col">
                  <select class="selectpicker" disabled>
                    @foreach($country as $phonecode)
                    <option value="{{ $phonecode->phonecode }}" @if($phonecode->phonecode == Auth::user()->country_code_phone) selected @endif>+ {{ $phonecode->phonecode }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" value="{{ Auth::user()->mobile }}" disabled />
                </div>
              </div>
            </div>
            <div class="col-xl-6 sp-col">
              <label class="lb-1">Your Enquiry</label>
              <select class="selectpicker" name="enquiry">
                <option value="">Course Enquiry</option>
                 @foreach($courses as $course)
                <option value="{{ $course->title }}">{{ $course->title }}</option>
                @endforeach
              </select>
              <label class="lb-1">Your Message</label>
              <textarea cols="30" rows="6" name="message" class="form-control" placeholder="Your Enquiry"></textarea>
            </div>
          </div>
          <div class="output-2">
            <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
          </div>
        </form>

        </div>
      </div>
    </div>
  </div>	
</main>
@endsection
