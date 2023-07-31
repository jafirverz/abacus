@extends('layouts.app')
@section('content')
    <main class="main-wrap">
        <div class="row sp-col-0 tempt-2">
            <div class="col-lg-3 sp-col tempt-2-aside">
                @include('inc.account-sidebar')
            </div>
            <div class="col-lg-9 sp-col tempt-2-inner">
                <div class="tempt-2-content">
                    <div class="mb-20">
                        <a class="link-1 lico" href="be-teacher-dashboard-competitions.html"><i
                                class="fa-solid fa-arrow-left"></i> Go Back</a>
                    </div>
                    <h1 class="title-3">Competition</h1>
                    <form method="post" name="competition_register" id="competition_register" enctype="multipart/form-data"
                        action="{{ route('competition.instructor.register.update', $competition_student->id) }}">
                        @csrf
                        <div class="box-1">
                            <h2 class="title-4">Title: {{ $competition->title }}</h2>
                            <div class="row sp-col-xl-30">
                                <div class="col-xl-4 sp-col">
                                    <label class="lb-1">Student Name <span class="required">*</span></label>
                                    <select disabled="disabled" class="selectpicker"
                                        onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                        <option value=''>--Select--</option>
                                        @foreach ($students as $key => $value)
                                            <option @if ($user->id == $value->id) selected @endif
                                                value="?student_id={{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user_id'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('user_id') }}</strong>
                                        </span>
                                    @endif
                                    <input type="hidden" name="user_id"
                                        value="{{ $user->id }}">
                                </div>
                                <div class="col-xl-4 sp-col">
                                    <label class="lb-1">Date of Birth <span class="required">*</span></label>
                                    <div class="date-wrap disabled">
                                        <i class="fa-solid fa-calendar-days ico"></i>
                                        <input disabled class="form-control" type="text"
                                            value="@if (get_user_detail($user->id)) {{ get_user_detail($user->id)->dob }} @endif">
                                    </div>
                                </div>
                                <div class="col-xl-4 sp-col">
                                    <label class="lb-1">Contact No <span class="required">*</span></label>
                                    <div class="row sp-col-10">
                                        <div class="col-auto sp-col">
                                            <select class="selectpicker" disabled>
                                                <option selected>
                                                    @if (get_user_detail($user->id))
                                                        {{ get_user_detail($user->id)->country_code_phone }}
                                                    @endif
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col sp-col">
                                            <input class="form-control" type="text"
                                                value="@if (get_user_detail($user->id)) {{ get_user_detail($user->id)->mobile }} @endif"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row sp-col-xl-30">
                                <div class="col-xl-4 sp-col">
                                    <label class="lb-1">Email <span class="required">*</span></label>
                                    <input class="form-control" type="text"
                                        value="@if (get_user_detail($user->id)) {{ get_user_detail($user->id)->email }} @endif"
                                        disabled>
                                </div>
                                <div class="col-xl-4 sp-col">
                                    <label class="lb-1">Competition Category <span class="required">*</span></label>
                                    <select class="selectpicker" name="category_id" data-title="Select">
                                        @foreach ($categories as $key => $value)
                                            <option @if ($competition_student->category_id== $value->id) selected @endif value="{{ $value->id }}">{{ $value->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-xl-4 sp-col">
                                    <label class="lb-1">Learning Location <span class="required">*</span></label>
                                    <select name="learning_location" class="selectpicker" data-title="Select">
                                        @foreach ($locations as $key => $value)
                                            <option @if ($competition_student->learning_location == $value->id) selected @endif value="{{ $value->id }}">{{ $value->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('learning_location'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('learning_location') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <label class="lb-1">Remarks</label>
                            <textarea name="remarks" cols="30" rows="5" class="form-control" placeholder="Your Remarks">{{ $competition_student->remarks ?? '' }}</textarea>
                            <div class="output-2">
                                <button class="btn-1" type="submit">Submit <i
                                        class="fa-solid fa-arrow-right-long"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
