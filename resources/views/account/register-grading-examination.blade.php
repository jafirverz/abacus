@extends('layouts.app')
@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-2">
        <div class="col-lg-3 sp-col tempt-2-aside">
            @if(Auth::user()->user_type_id == 6)
            <div class="menu-aside">
             @include('inc.account-sidebar-external')
            </div>
            @else
             @include('inc.account-sidebar')
            @endif
        </div>
        <div class="col-lg-9 sp-col tempt-2-inner">
            <div class="tempt-2-content">
                <div class="mb-20">
                    <a class="link-1 lico" href="be-teacher-dashboard-grading.html">
                        <i class="fa-solid fa-arrow-left"></i> Go Back
                    </a>
                </div>
                <h1 class="title-3">Grading Examinations</h1>
                <form method="post" name="instructor" id="instructor" enctype="multipart/form-data" action="{{route('register-grading-examination.submit')}}">
                @csrf
                <div class="box-1">
                    <h2 class="title-4">Title: {{ $gradingExam->title ?? '' }}</h2>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Student Name
                                <span class="required">*</span>
                            </label>
                            <select class="selectpicker"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                <option>--Select--</option>
                                @foreach($students as $key => $value)
                                <option @if(isset($_GET['student_id']) && $_GET['student_id']== $value->id) selected @endif value="?student_id={{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="user_id" value="@if(isset($_GET['student_id']) && $_GET['student_id']!= '') {{ $_GET['student_id'] }} @endif">
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Date of Birth
                                <span class="required">*</span>
                            </label>
                            <div class="date-wrap disabled">
                                <i class="fa-solid fa-calendar-days ico"></i>
                                <input
                                    class="form-control"
                                    type="text"
                                    value="@if(isset($_GET['student_id']) && get_user_detail($_GET['student_id'])) {{ get_user_detail($_GET['student_id'])->dob }} @endif"

                                >
                            </div>
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Contact No
                                <span class="required">*</span>
                            </label>
                            <div class="row sp-col-10">
                                <div class="col-auto sp-col">
                                    <select class="selectpicker" disabled>
                                        <option selected> @if(isset($_GET['student_id']) && get_user_detail($_GET['student_id'])) {{ get_user_detail($_GET['student_id'])->country_code_phone }} @endif</option>
                                    </select>
                                </div>
                                <div class="col sp-col">
                                    <input
                                        class="form-control"
                                        type="text"
                                        value="@if(isset($_GET['student_id']) && get_user_detail($_GET['student_id'])) {{ get_user_detail($_GET['student_id'])->mobile }} @endif"
                                        disabled
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-3 sp-col">
                            <label class="lb-1">Email
                                <span class="required">*</span>
                            </label>
                            <input
                                class="form-control"
                                type="text"
                                value="@if(isset($_GET['student_id']) && get_user_detail($_GET['student_id'])) {{ get_user_detail($_GET['student_id'])->email }} @endif"
                                disabled
                            >
                        </div>
                        <div class="col-xl-3 sp-col">
                            <label class="lb-1">Mental Grade
                                <span class="required">*</span>
                            </label>
                            <select name="mental_grade" class="selectpicker" data-title="Select Option">
                                @if($mental_grades)
                                @foreach($mental_grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->title }}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('mental_grade'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('mental_grade') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="col-xl-3 sp-col">
                            <label class="lb-1">Abacus Grade
                                <span class="required">*</span>
                            </label>
                            <select name="abacus_grade" class="selectpicker" data-title="Select Option">
                                @if($abacus_grades)
                                @foreach($abacus_grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->title }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-xl-3 sp-col">
                            <label class="lb-1">Learning Location
                                <span class="required">*</span>
                            </label>
                            <select name="learning_location" class="selectpicker" data-title="Select Option">
                                @if($locations)
                                @foreach($locations as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <label class="lb-1">Remarks</label>
                    <textarea name="remarks"
                        cols="30"
                        rows="5"
                        class="form-control"
                        placeholder="Your Remarks"
                    ></textarea>
                    <input type="hidden" name="grading_exam_id" value="{{ $gradingExam->id ?? '' }}">
                    <div class="output-2">
                        <button class="btn-1" type="submit">Submit
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
