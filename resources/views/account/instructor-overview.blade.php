@extends('layouts.app')
@section('content')
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
                <div class="box-1">
                    <h2 class="title-2">Announcements</h2>
                    <div class="accordion acctype mt-20">
                        @if(getAnnouncementsByTeacher(Auth::user()->id))
                        @php $i=0;@endphp
                         @foreach(getAnnouncementsByTeacher(Auth::user()->id) as $item)
                         @php $i++;@endphp
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button @if($i==0)  @else collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#course-{{ $i }}" aria-expanded="false" aria-controls="course-{{ $i }}"><strong>{{ $item->title }}</strong> <span>{!! $item->description !!}...</span><em>{{ Str::limit($item->announcement_date, 50) }}</em></button>
                                </h3>
                                <div id="course-{{ $i }}" class="accordion-collapse collapse @if($i==0) show @else  @endif">
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
                                            <a class="link-3" href="#">Download All Attachements</a>
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
                        <div class="box-1">
                            <h2 class="title-2">My Calendar</h2>
                            <label class="lb-1">Full Name <span class="required">*</span></label>
                            <input class="form-control" type="text" placeholder="e.g. Michelle Tan" />
                            <label class="lb-1">Date &amp; Time <span class="required">*</span></label>
                            <div class="row sp-col-10 break-424">
                                <div class="col-6 sp-col">
                                    <div class="date-wrap">
                                        <i class="fa-solid fa-calendar-days ico"></i>
                                        <input class="form-control" type="text" placeholder="Select Date" />
                                    </div>
                                </div>
                                <div class="col-6 sp-col mt-474-10">
                                    <div class="time-wrap sp-col">
                                        <i class="icon-clock ico"></i>
                                        <input class="form-control" type="text" placeholder="Select Time" />
                                    </div>
                                </div>
                            </div>
                            <label class="lb-1">Note <span class="required">*</span></label>
                            <textarea cols="30" rows="9" class="form-control" placeholder="What is your Note?"></textarea>
                            <div class="row mt-20">
                                <div class="col-auto">Set Reminder ? <span class="required">*</span></div>
                                <div class="col chooselist-1">
                                    <div class="radiotype">
                                        <input id="yes" type="radio" name="reminder" checked />
                                        <label for="yes">Yes</label>
                                    </div>
                                    <div class="radiotype">
                                        <input id="no" type="radio" name="reminder" />
                                        <label for="no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="output-1">
                                <button class="btn-1" type="submit">Add <i class="fa-solid fa-arrow-right-long"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
