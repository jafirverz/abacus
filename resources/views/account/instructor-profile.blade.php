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
                <h1 class="title-3">My Profile</h1>
                @include('inc.messages')
                <div class="box-1">
                    <div class="row align-items-center title-type">
                        <div class="col-md">
                            <h2 class="title-2">Personal Information</h2>
                        </div>
                        <div class="col-md-auto mt-767-10">
                            <a class="link-1"  href="javascript::void(0);" id="editinformation">Edit My Information</a>
                        </div>
                    </div>
                    <div class="mt-20"><label>Account ID:</label> {{ $user->account_id }}</div>
                    <form method="post" name="profile" id="profileform" enctype="multipart/form-data" action="{{route('instructor-profile.update')}}">
                        @csrf
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Full Name <span class="required">*</span></label>
                            <input class="form-control" name="name" type="text" value="{{ $user->name }}" disabled />
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Email <span class="required">*</span></label>
                            <input class="form-control" name="email" type="text" value="{{ $user->email  }}" disabled />
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Password <span class="required">*</span></label>
                            <input class="form-control" name="password" type="password" placeholder="*****" disabled />
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Date of Birth <span class="required">*</span></label>
                            <div class="date-wrap disabled">
                                <i class="fa-solid fa-calendar-days ico"></i>
                                <input class="form-control" type="text" name="dob" value="{{ $user->dob  }}" disabled />
                            </div>
                        </div>

                        <div class="col-xl-4 sp-col" id="disablephone">
                            <label class="lb-1">Phone <span class="required">*</span></label>
                            <div class="row sp-col-10">
                                <div class="col-auto sp-col">
                                    <select class="selectpicker" disabled>
                                        <option value="+65" @if($user->country_code_phone == '+65') selected @endif>+65</option>
                                        <option value="+84" @if($user->country_code_phone == '+84') selected @endif>+84</option>
                                    </select>
                                </div>
                                <div class="col sp-col">
                                    <input class="form-control" type="text" value="{{$user->mobile}}" disabled />
                                </div>
                            </div>
                        </div>
                        @php
                            $country_code_phone = $user->country_code_phone;
                            if(old("country_code_phone")){
                                $country_code_phone = old("country_code_phone");
                            }
                        @endphp
                        <div class="col-xl-4 sp-col" id="enablephone" style="display: none">
                            <label class="lb-1">Phone <span class="required">*</span></label>
                            <div class="row sp-col-10">
                                <div class="col-auto sp-col">
                                    <select class="selectpicker" name="country_code_phone">
                                        <option value="+65" @if($country_code_phone == '+65') selected @endif>+65</option>
                                        <option value="+84" @if($country_code_phone == '+84') selected @endif>+84</option>
                                    </select>
                                    @if ($errors->has('country_code_phone'))
                                        <span class="text-danger">&nbsp;{{ $errors->first('country_code_phone') }}</span>
                                    @endif
                                </div>
                                <div class="col sp-col">
                                    <input class="form-control" type="text" name="mobile" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{old('mobile', $user->mobile) ?? ''}}" disabled />
                                </div>
                                @if ($errors->has('mobile'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-xl-4 sp-col" id="disablegender">
                            <label class="lb-1">Gender <span class="required">*</span></label>
                            <select class="selectpicker" disabled>
                                <option value="">Please Select</option>
                                <option value="1" @if($user->gender == '1') selected @endif>Male</option>
                                <option value="2" @if($user->gender == '2') selected @endif>Female</option>
                            </select>
                        </div>
                        @php
                            $gender = $user->gender;
                            if(old("gender")){
                                $gender = old("gender");
                            }
                        @endphp
                        <div class="col-xl-4 sp-col" id="enablegender" style="display: none">
                            <label class="lb-1">Gender <span class="required">*</span></label>
                            <select class="selectpicker" name="gender" >
                                <option value="" selected>Please Select</option>
                                <option value="1" @if($gender == '1' && !$errors->has('gender')) selected @endif>Male</option>
                                <option value="2" @if($gender == '2' && !$errors->has('gender')) selected @endif>Female</option>
                            </select>
                            @if ($errors->has('gender'))
                                <span class="text-danger">&nbsp;{{ $errors->first('gender') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-3 sp-col" id="disablecountry">
                            <label class="lb-1">Country <span class="required">*</span></label>
                            <select class="selectpicker"  disabled>
                                <option>Please Select</option>
                                @if(getCountry())
                                @foreach (getCountry() as $key => $item)
                                <option value="{{ $key }}" @if($user->country_code==$key) selected @endif>{{ $item }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @php
                            $country_code = $user->country_code;
                            if(old("country_code")){
                                $country_code = old("country_code");
                            }
                        @endphp
                        <div class="col-xl-3 sp-col" id="enablecountry" style="display: none">
                            <label class="lb-1">Country <span class="required">*</span></label>
                            <select class="selectpicker" name="country_code">
                                <option value="">Please Select</option>
                                @if(getCountry())
                                @foreach (getCountry() as $key => $item)
                                <option value="{{ $key }}" @if($user->country_code==$key && !$errors->has('country_code')) selected @endif>{{ $item }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('country_code'))
                                <span class="text-danger">&nbsp;{{ $errors->first('country_code') }}</span>
                            @endif
                        </div>
                        <div class="col-xl-6 sp-col">
                            <label class="lb-1">Address</label>
                            <input class="form-control" name="address" type="text" value="{{ $user->address  }}" disabled />
                        </div>
                    </div>
                    <h2 class="title-2 mt-50">Academic Information</h2>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Year Attained Qualified Instructor Certification</label>
                            <input class="form-control" type="text" name="year_attained_qualified_instructor" value="{{ $user->year_attained_qualified_instructor  }}" disabled />
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Year Attained Senior Instructor Certification</label>
                            <input class="form-control" type="text" name="year_attained_senior_instructor" value="{{ $user->year_attained_senior_instructor  }}" disabled />
                        </div>
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Highest Abacus Grade Attained</label>
                            <input class="form-control" type="text" name="highest_abacus_grade" value="{{ $user->highest_abacus_grade  }}" disabled />
                        </div>
                    </div>
                    <div class="row sp-col-xl-30">
                        <div class="col-xl-4 sp-col">
                            <label class="lb-1">Highest Mental Grade Attained</label>
                            <input class="form-control" type="text" name="highest_mental_grade" value="{{ $user->highest_mental_grade  }}" disabled />
                        </div>
                    </div>
                    <label class="lb-1">Awards:</label>
                    <div class="txtwrap">
                        <textarea disabled name="awards" class="form-control">{!! $user->awards  !!}</textarea>
                    </div>
                    <div class="output-2">
                        <button class="btn-1" type="submit">Save <i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                    </form>
                </div>
                <div class="row sp-col-20 grid-9">
                    <div class="col-sm-6 sp-col">
                        <div class="inner">
                            <h4>My Students' Best Grading Examination Achievement</h4>
                            <h5>Student Name</h5>
                            <p>{{ get_user_detail($highest_grading_grade->user_id)->name ?? ''}}</p>
                            <h5>Year</h5>
                            <p>{{ date('Y',strtotime($highest_grading_grade->exam_date))}}</p>
                            <h5>Grading Examination</h5>
                            <p>{{ $highest_grading_grade->grade_title ?? ''}}</p>
                            <h5>Highest Grade (mental)</h5>
                            <p>{{ $highest_grading_grade->mental_grade ?? ''}}</p>
                            <h5>Highest Grade (Abacus)</h5>
                            <p>{{ $highest_grading_grade->abacus_grade ?? ''}}</p>
                        </div>
                    </div>
                    <div class="col-sm-6 sp-col">
                        <div class="inner">
                            <h4>My Students' Best Competition Achievement</h4>
                            <h5>Student Name</h5>
                            <p>{{ get_user_detail($highest_competetion_grade->user_id)->name ?? ''}}</p>
                            <h5>Year</h5>
                            <p>{{ date('Y',strtotime($highest_competetion_grade->date_of_competition))}}</p>
                            <h5>Competition</h5>
                            <p>{{ $highest_competetion_grade->comp_title ?? ''}}</p>
                            <h5>Prize</h5>
                            <p>{{ $highest_competetion_grade->prize ?? ''}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@if($errors->any())
        <script>
                $("#profileform").find("input, select, textarea").attr("disabled", false);
                $('#instructor').attr('disabled', true);
                $('#disablephone').hide();
                $('#enablephone').show();
                $('#disablegender').hide();
                $('#enablegender').show();
                $('#disablecountry').hide();
                $('#enablecountry').show();
                $('#updateprofile').val(1);
                // $('#profileform').hide();
                // $('#profileformedit').show();

        </script>
    @endif

    <script>
        function myFunction(id) {
            var x = document.getElementById(id);
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
        $('#removeimage').click(function() {
            $("#preview").hide();
            // $('#preview').removeAttr("src").hide();
        });
        $('#chooseimage').click(function() {
            alert("aa");
            //$("#preview").attr("src", "");
            $('#preview').show();
        });
        $('#removeimage1').click(function() {
            $("#preview1").hide();
            // $('#preview').removeAttr("src").hide();
        });
        $('#chooseimage1').click(function() {
            alert("aa");
            //$("#preview").attr("src", "");
            $('#preview1').show();
        });
        $('#editinformation').click(function () {
            $("#profileform").find("input, select, textarea").attr("disabled", false);
            $('#instructor').attr('disabled', true);
            $('#disablegender').hide();
            $('#enablegender').show();
            $('#disablephone').hide();
            $('#enablephone').show();
            $('#disablecountry').hide();
            $('#enablecountry').show();
            $('#updateprofile').val(1);
            // $('#profileform').hide();
            // $('#profileformedit').show();

        });
    </script>
@endsection
