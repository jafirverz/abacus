@extends('layouts.app')
@section('content')
    <main class="main-wrap">
        <div class="row sp-col-0 tempt-2">
            <div class="col-lg-3 sp-col tempt-2-aside">
                <div class="menu-aside">
                    <h3>My Dashboard</h3>
                    <ul>
                        <li>
                            <a href="be-overview.html">
                                <span><img src="images/tempt/ico-overview.png" alt="Overview icon" /></span>
                                <strong>Overview</strong>
                            </a>
                        </li>
                        <li>
                            <a href="be-achievements.html">
                                <span><img src="images/tempt/ico-achievements.png" alt="Achievements icon" /></span>
                                <strong>My Achievements</strong>
                            </a>
                        </li>
                        <li class="active">
                            <a href="{{url('my-profile')}}">
                                <span><img src="images/tempt/ico-profile.png" alt="Profile icon" /></span>
                                <strong>My Profile</strong>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 sp-col tempt-2-inner">
                <div class="tempt-2-content">
                    <h1 class="title-3">My Profile</h1>
                    <div class="box-1">
                        <div class="row align-items-center title-type">
                            <div class="col-md">
                                <h2 class="title-2">Personal Information</h2>
                            </div>
                            <div class="col-md-auto mt-767-10">
                                <a class="link-1" href="javascript::void(0);" id="editinformation">Edit My Information</a>
                            </div>
                        </div>

                        <form method="post" name="profile" id="profileform" enctype="multipart/form-data" action="{{route('my-profile.update')}}">
                            @csrf
                            <input type="hidden" name="updateimage" value="1">
                            <input type="hidden" name="updateprofile" id="updateprofile" value="0">
                            <div class="upload-image row break-424">
                            <div class="col-auto sp-col">
                                <div class="image fitimg">
                                    <img class="img" id="preview" src="{{$user->profile_picture ?? asset('images/tempt/img-user.jpg')}}" alt="" />
                                </div>
                            </div>
                            <div class="col sp-col">
                                <div class="btnwrap">
                                    <div class="uploadbtn">
                                        <input type="file" name="profile_picture" class="custom-file-input" id="uploadphoto">
                                        <label class="btn-1 custom-file-label" id="chooseimage" for="uploadphoto">Choose an Image</label>
                                    </div>
                                    <button class="btn-2 removeimg" id="removeimage" type="button">Remove Image</button>
                                </div>
                                <div class="note-1">*Select an image on your computer (5mb max)</div>
                            </div>
                        </div>
                        <div class="mt-20"><label>Account ID:</label> {{$user->account_id}}</div>
                        <div class="row sp-col-xl-30">
                            <div class="col-xl-4 sp-col">
                                <label class="lb-1">Full Name <span class="required">*</span></label>
                                <input class="form-control" name="name" type="text" value="{{old('name', $user->name) ?? ''}}" disabled />
                                @if ($errors->has('name'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="col-xl-4 sp-col">
                                <label class="lb-1">Email <span class="required">*</span></label>
                                <input class="form-control" type="text" name="email" value="{{old('email', $user->email) ?? ''}}" disabled />
                                @if ($errors->has('email'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="col-xl-4 sp-col">
                                <label class="lb-1">Password <span class="required">*</span></label>
                                <input class="form-control" name="password" value="" type="password" placeholder="*****" disabled />
                            </div>
                        </div>
                        <div class="row sp-col-xl-30">
                            <div class="col-xl-4 sp-col">
                                <label class="lb-1">Date of Birth <span class="required">*</span></label>
                                <div class="date-wrap disabled">
                                    <i class="fa-solid fa-calendar-days ico"></i>
                                    <input class="form-control" type="text" name="dob" value="{{old('dob', date('d/m/Y', strtotime($user->dob))) ?? ''}}" disabled />
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


                        <div class="row sp-col-xl-30" >
                            <div class="col-xl-4 sp-col" id="disableinstructor">
                                <label class="lb-1">Instructor <span class="required">*</span></label>
                                <select class="selectpicker" disabled >
                                    <option value="" selected>Please Select</option>
                                    @foreach($instructors as $instructor)
                                    <option value="{{$instructor->id}}" @if($instructor->id == $user->instructor_id) selected @endif>{{$instructor->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                            @php
                                $instructor_id = $user->instructor_id;
                                if(old("instructor")){
                                    $instructor_id = old("instructor");
                                }
                            @endphp
                            <div class="col-xl-4 sp-col" id="enableinstructor" style="display: none">
                                <label class="lb-1">Instructor <span class="required">*</span></label>
                                <select class="selectpicker" name="instructor">
                                    <option value="" >Please Select</option>
                                    @foreach($instructors as $instructor)
                                        <option value="{{$instructor->id}}" @if($instructor->id == $instructor_id && !$errors->has('instructor')) selected @endif>{{$instructor->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('instructor'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('instructor') }}</span>
                                @endif
                            </div>


                            <div class="col-xl-3 sp-col" id="disablecountry">
                                <label class="lb-1">Country <span class="required">*</span></label>
                                <select class="selectpicker"  disabled>
                                    <option>Please Select</option>
                                    <option value="+65" @if($user->country_code == '+65') selected @endif>Singapore</option>
                                    <option value="+63" @if($user->country_code == '+63') selected @endif>Vietnam</option>
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
                                    <option value="+65" @if($country_code == '+65' && !$errors->has('country_code')) selected @endif>Singapore</option>
                                    <option value="+63" @if($country_code == '+63' && !$errors->has('country_code')) selected @endif>Vietnam</option>
                                </select>
                                @if ($errors->has('country_code'))
                                    <span class="text-danger">&nbsp;{{ $errors->first('country_code') }}</span>
                                @endif
                            </div>



                            <div class="col-xl-5 sp-col">
                                <label class="lb-1">Address</label>
                                <input class="form-control" type="text" name="address" value="{{$user->address}}" disabled />
                            </div>
                        </div>
                        <div class="output-2">
                            <button class="btn-1" type="submit">Save <i class="fa-solid fa-arrow-right-long"></i></button>
                        </div>
                        </form>


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
                $('#disableinstructor').hide();
                $('#enableinstructor').show();
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
        $('#disablephone').hide();
        $('#enablephone').show();
        $('#disablegender').hide();
        $('#enablegender').show();
        $('#disablecountry').hide();
        $('#enablecountry').show();
        $('#disableinstructor').hide();
        $('#enableinstructor').show();
        $('#updateprofile').val(1);
        // $('#profileform').hide();
        // $('#profileformedit').show();

    });
</script>
@endsection
