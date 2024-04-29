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

                <div class="mb-20">
                    <a class="link-1 lico" href="{{ url('allocation') }}"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
                </div>
                @include('inc.messages')
                <h1 class="title-3">Test and Survey Allocation</h1>
                <div class="box-1">
                    <div class="row title-wrap-1">
                        <div class="col-sm">
                            <h2 class="title-4">{{ $test->title ?? '' }}</h2>
                        </div>
                        <div class="col-sm-auto mt-574-15">
                            <a class="link-1 rico" href="#">View Test <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                    <form method="post" name="allocation" id="allocation" enctype="multipart/form-data" action="{{route('allocation.update',$test_id)}}">
                    @csrf
                    <div class="row sp-col-30 mb-40">
                        <div class="col-xl-7 sp-col">
                            <label class="lb-1">Student Name <span class="required">*</span></label>
                            <div class="row">
                                <div class="col-sm">
                                    <select data-live-search="true" name="student_id[]" class="selectpicker" multiple>
                                        @if($students->count())
                                        @foreach ($students as $key => $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-auto hide-574">
                                    <button class="btn-1 btntype" type="submit">Allocate <i class="fa-solid fa-arrow-right-long"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 sp-col">
                            <label class="lb-1">Date &amp; Time <span class="required">*</span></label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="date-wrap">
                                        <i class="fa-solid fa-calendar-days ico"></i>
                                        <input required name="start_date" class="form-control" type="text" placeholder="Start Date">
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-574-15">
                                    <div class="date-wrap">
                                        <i class="fa-solid fa-calendar-days ico"></i>
                                        <input required name="end_date" class="form-control" type="text" placeholder="End Date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-574-30 show-574">
                            <button class="btn-1 btn-block" type="submit">Allocate <i class="fa-solid fa-arrow-right-long"></i></button>
                        </div>
                    </div>
                    </form>
                    <div class="xscrollbar mCustomScrollbar _mCS_1" style="width: 959px;"><div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_horizontal mCSB_inside" style="max-height: none;" tabindex="0"><div id="mCSB_1_container" class="mCSB_container mCS_x_hidden mCS_no_scrollbar_x" style="position: relative; top: 0px; left: 0px; width: 100%;" dir="ltr">
                        <table class="tb-2 tbtype-4">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>Student Name</th>
                                    <th>Date Allocated</th>
                                    <th>Date Completed</th>
                                    <th>Time Taken</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($list->count())
                                @foreach ($list as $key => $item)
                                <tr>
                                    <td>
                                        <em>{{ $item->student->name }}</em>
                                        <div class="tbactions"><a href="{{route('view.test.result', [$item->student->id,$test_id])}}">View</a> <a onclick="return confirm('Are you sure to delete this record?')" href="{{ url('allocation/test/delete/'.$item->id) }}">Delete</a></div>
                                    </td>
                                    <td><em>{{ date('d/m/Y',strtotime($item->start_date)) }}</em></td>
                                    <td><em>{{ date('d/m/Y',strtotime($item->end_date)) }}</em></td>
                                    <td><em>{{ diff_between_dates($item->start_date,$item->end_date) }}</em></td>
                                    <td>@if(isset($item->submission->user_marks) && $item->submission->user_marks>0)<em class="status-5"> {{ $item->submission->user_marks  }} out of {{ $item->submission->total_marks  }}</em>@endif</td>
                                </tr>
                                @endforeach
                                @else
                                {{ __('constant.NO_DATA_FOUND') }}
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <ul class="page-numbers mt-30">
                        {{ $list->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
