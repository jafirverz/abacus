@extends('layouts.app')
@section('content')
@php
$calendars =  \App\InstructorCalendar::where('teacher_id', Auth::user()->id)->get();
@endphp
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            <div class="menu-aside">
                @include('inc.intructor-account-sidebar')
            </div>
        </div>
        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">
                <h1 class="title-3">Good Morning Teacher {{Auth::user()->name}},</h1>
                @include('inc.messages')
                <div class="box-1">
                    <h2 class="title-2">Announcements</h2>

                    <div class="accordion acctype mt-20">
                        @if(getAnnouncementsByTeacher(Auth::user()->id))
                        @php $i=0;@endphp
                         @foreach(getAnnouncementsByTeacher(Auth::user()->id) as $item)
                         @php $i++;@endphp
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button @if($i==1)  @else collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#course-{{ $i }}" aria-expanded="false" aria-controls="course-{{ $i }}"><strong>{{ $item->title }}</strong> <span>{!! Str::limit($item->description, 50) !!}...</span><em>{{ date('d/m/Y',strtotime($item->announcement_date)) }}</em></button>
                                </h3>
                                <div id="course-{{ $i }}" class="accordion-collapse collapse @if($i==1) show @else  @endif">
                                    <div class="accordion-body">
                                        @if(isset($item->image))
                                        <figure class="imgwrap-2">
                                            <img src="{{ url('/') }}/{{ $item->image }}" alt="" />
                                        </figure>
                                        @endif
                                        <article class="document">
                                            <h3>{{ $item->title }}</h3>
                                            {!! $item->description !!}
                                        </article>
                                        @if(isset($item->attachments)  && $item->attachments!='')
                                        <hr/>
                                        <div>Attachments:</div>
                                        <ul class="list-3">
                                            @php
                                            $json=json_decode($item->attachments);
                                            for($i=0;$i<count($json);$i++)
                                            {
                                            @endphp
                                            <li><a href="{{ url('/') }}/upload-file/{{ $json[$i] }}" target="_blank">{{ $json[$i] }}</a></li>
                                            @php } @endphp

                                        </ul>

                                        <div class="mt-15">
                                            <a class="link-3" href="{{ route('instructor.download_all_announcements',$item->id) }}">Download All Attachements</a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                         @endforeach
                        @endif

                    </div>
                </div>
                <div class="row sp-col-20 grid-10">
                    <div class="col-xl-7 sp-col order-xl-last">
                        <div class="box-1">
                            <h3 class="title-7 text-center">Calendar</h3>
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <div class="col-xl-5 sp-col order-xl-first">
                        <form method="post" name="instructor" id="instructor" enctype="multipart/form-data" action="{{route('instructor-profile.cal_update')}}">
                        @csrf
                        <div class="box-1">
                            <h2 class="title-2">My Calendar</h2>
                            <label class="lb-1">Full Name <span class="required">*</span></label>
                            <input name="full_name" class="form-control" value="{{ old('full_name') }}" type="text" placeholder="e.g. Michelle Tan" />
                                    @if ($errors->has('full_name'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('full_name') }}</strong>
                                        </span>
                                    @endif
                            <label class="lb-1">Date &amp; Time <span class="required">*</span></label>
                            <div class="row sp-col-10 break-424">
                                <div class="col-6 sp-col">
                                    <div class="date-wrap">
                                        <i class="fa-solid fa-calendar-days ico"></i>
                                        <input name="start_date" value="{{ old('start_date') }}" class="form-control" type="text" placeholder="Select Date" />
                                    </div>
                                    @if ($errors->has('start_date'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('start_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-6 sp-col mt-474-10">
                                    <div class="time-wrap sp-col">
                                        <i class="icon-clock ico"></i>
                                        <input name="start_time" value="{{ old('start_time') }}" class="form-control" type="text" placeholder="Select Time" />
                                        @if ($errors->has('start_time'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('start_time') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <label class="lb-1">Note <span class="required">*</span></label>
                            <textarea cols="30" rows="9" name="note" class="form-control" placeholder="What is your Note?"></textarea>
                            @if ($errors->has('note'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('note') }}</strong>
                            </span>
                            @endif
                            <div class="row mt-20">
                                <div class="col-auto">Set Reminder ? <span class="required">*</span></div>
                                <div class="col chooselist-1">
                                    <div class="radiotype">
                                        <input id="yes" type="radio" value="1" name="reminder" checked />
                                        <label for="yes">Yes</label>
                                    </div>
                                    <div class="radiotype">
                                        <input id="no" type="radio" value="2" name="reminder" />
                                        <label for="no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="output-1">
                                <button class="btn-1" type="submit">Add <i class="fa-solid fa-arrow-right-long"></i></button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          left: '',
          center: 'prev,title,next',
          right: ''
        },
        events: [
@foreach($calendars as $key=>$value)
          {
            title: '{{ $value->note }}',
            start: '{{ $value->start_date }}T{{ $value->start_time }}',
            end: '{{ $value->start_date }}T{{ $value->start_time }}'
          },
@endforeach
        ]
      });

      calendar.render();
    });

  </script>
@endsection
