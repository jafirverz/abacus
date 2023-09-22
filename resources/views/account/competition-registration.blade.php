@extends('layouts.app')
@section('content')
    <main class="main-wrap">
        <div class="row sp-col-0 tempt-2">
            <div class="col-lg-3 sp-col tempt-2-aside">
                @if(Auth::user()->user_type_id == 6)
                <div class="menu-aside">@include('inc.account-sidebar-external')</div>
                @else
                <div class="menu-aside">@include('inc.intructor-account-sidebar')</div>
                @endif
            </div>
            <div class="col-lg-9 sp-col tempt-2-inner">
                <div class="tempt-2-content">
                    <div class="mb-20">
                        <a class="link-1 lico" onclick="history.back()" href="javascript::void();"><i
                                class="fa-solid fa-arrow-left"></i> Go Back</a>
                    </div>
                    <h1 class="title-3">Competition</h1>
                    <form method="post" name="competition_register" id="competition_register" enctype="multipart/form-data"
                        action="{{ route('competition.instructor.register.submit', $competition->id) }}">
                        @csrf
                        <div class="box-1">
                            <h2 class="title-4">Title: {{ $competition->title }}</h2>
                            <div class="row sp-col-xl-30">
                                <div class="col-xl-4 sp-col">
                                    <label class="lb-1">Student Name <span class="required">*</span></label>
                                    <select class="selectpicker"
                                        onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                        <option value=''>--Select--</option>
                                        @foreach ($students as $key => $value)
                                            <option @if (isset($_GET['student_id']) && $_GET['student_id'] == $value->id) selected @endif
                                                value="?student_id={{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user_id'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('user_id') }}</strong>
                                        </span>
                                    @endif
                                    <input type="hidden" name="user_id"
                                        value="@if (isset($_GET['student_id']) && $_GET['student_id'] != '') {{ $_GET['student_id'] }} @endif">
                                </div>
                                <div class="col-xl-4 sp-col">
                                    <label class="lb-1">Date of Birth <span class="required">*</span></label>
                                    <div class="date-wrap disabled">
                                        <i class="fa-solid fa-calendar-days ico"></i>
                                        <input class="form-control" type="text"
                                            value="@if (isset($_GET['student_id']) && get_user_detail($_GET['student_id'])) {{ get_user_detail($_GET['student_id'])->dob }} @endif">
                                    </div>
                                </div>
                                <div class="col-xl-4 sp-col">
                                    <label class="lb-1">Contact No <span class="required">*</span></label>
                                    <div class="row sp-col-10">
                                        <div class="col-auto sp-col">
                                            <select class="selectpicker" disabled>
                                                <option selected>
                                                    @if (isset($_GET['student_id']) && get_user_detail($_GET['student_id']))
                                                        {{ get_user_detail($_GET['student_id'])->country_code_phone }}
                                                    @endif
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col sp-col">
                                            <input class="form-control" type="text"
                                                value="@if (isset($_GET['student_id']) && get_user_detail($_GET['student_id'])) {{ get_user_detail($_GET['student_id'])->mobile }} @endif"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row sp-col-xl-30">
                                <div class="col-xl-4 sp-col">
                                    <label class="lb-1">Email <span class="required">*</span></label>
                                    <input class="form-control" type="text"
                                        value="@if (isset($_GET['student_id']) && get_user_detail($_GET['student_id'])) {{ get_user_detail($_GET['student_id'])->email }} @endif"
                                        disabled>
                                </div>
                                <div class="col-xl-4 sp-col">
                                    <label class="lb-1">Competition Category <span class="required">*</span></label>
                                    <select class="selectpicker" name="category_id" data-title="Select">
                                        @foreach ($categories as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-xl-4 sp-col">
                                    <label class="lb-1">Learning Location </label>
                                    <select name="learning_locations" class="selectpicker" data-title="Select Option">
                                        @if($locations)
                                        @foreach($locations as $item)
                                        <option @if(isset($_GET['student_id']) && get_user_detail($_GET['student_id'])->learning_locations==$item->id) selected @endif  value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('learning_location'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('learning_location') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <label class="lb-1">Remarks</label>
                            <textarea name="remarks" cols="30" rows="5" class="form-control" placeholder="Your Remarks"></textarea>
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
