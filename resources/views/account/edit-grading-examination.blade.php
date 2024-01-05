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
                <div class="mb-20">
                    <a class="link-1 lico" href="{{ url('grading-examination') }}">
                        <i class="fa-solid fa-arrow-left"></i> Go Back
                    </a>
                </div>
                <h1 class="title-3">Grading Examinations</h1>
                <form method="post" name="instructor" id="instructor" enctype="multipart/form-data" action="{{route('grading-examination.update',$grading->id)}}">
                @csrf
                <div class="box-1">
                    <h2 class="title-4">Title: 15th 3G Abacus Mental-Arithmetic International Grading Exam 2025</h2>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Student Name
                                <span class="required">*</span>
                            </label>
                            <select class="selectpicker" disabled>
                                <option>--Select--</option>
                                @foreach($students as $key => $value)
                                <option @if($grading->user_id== $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="user_id" value="{{ $grading->user_id }}">
                            @if ($errors->has('user_id'))
                            <span class="text-danger d-block">
                                <strong>{{ $errors->first('user_id') }}</strong>
                            </span>
                        @endif
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Date of Birth
                                <span class="required">*</span>
                            </label>
                            <div class="date-wrap">
                                <i class="fa-solid fa-calendar-days ico"></i>
                                <input disabled
                                    class="form-control"
                                    type="text"
                                    value="{{ get_user_detail($grading->user_id)->dob }}"
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
                                        <option selected> {{ get_user_detail($grading->user_id)->country_code_phone }}</option>
                                    </select>
                                </div>
                                <div class="col sp-col">
                                    <input
                                        class="form-control"
                                        type="text"
                                        value="{{ get_user_detail($grading->user_id)->mobile }}"
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
                                value="{{ get_user_detail($grading->user_id)->email }}"
                                disabled
                            >
                        </div>
                        <div class="col-xl-3 sp-col">
                            <label class="lb-1">Mental Grade

                            </label>
                            <select name="mental_grade" class="selectpicker" data-title="Select Option">
                                @if($mental_grades)
                                @foreach($mental_grades as $grade)
                                <option @if($grade->id==$grading->mental_grade) selected @endif value="{{ $grade->id }}">{{ $grade->title }}</option>
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

                            </label>
                            <select name="abacus_grade" class="selectpicker" data-title="Select Option">
                                @if($abacus_grades)
                                @foreach($abacus_grades as $grade)
                                <option  @if($grade->id==$grading->abacus_grade) selected @endif value="{{ $grade->id }}">{{ $grade->title }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-xl-3 sp-col">
                            <label class="lb-1">Grading Examination
                                <span class="required">*</span>
                            </label>
                            <select disabled name="grading_exam_id" class="selectpicker" data-title="Select Option">
                                @if($gradingExam)
                                @foreach($gradingExam as $item)
                                <option  @if($item->id==$grading->grading_exam_id) selected @endif value="{{ $item->id ?? '' }}">{{ $item->title ?? '' }}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('grading_exam_id'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('grading_exam_id') }}</strong>
                                        </span>
                                    @endif
                        </div>
                    </div>
                    <label class="lb-1">Remarks</label>
                    <textarea name="remarks"
                        cols="30"
                        rows="5"
                        class="form-control"
                        placeholder="Your Remarks"
                    >{{ $grading->remarks }}</textarea>
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
