@extends('layouts.appLogin')

@section('content')

    <main class="main-wrap">
        <div class="row sp-col-0 tempt-1">
            <div class="col-lg-6 col-md-7 col-sm-9 sp-col order-sm-last">
                <div class="tempt-1-content">
                    <div class="intro-1">
                        @include('inc.messages')
                        <h1 class="title-1">Student Registration</h1>
                        <p>Please fill up the form as below and submit for approval.<br/>
                            This is only for new 3G Abacus student who does not already have an account.</p>
                    </div>
                    <hr class="bdrtype-3"/>
                    <form action="{{ route('register') }}" name="student_registration" enctype="multipart/form-data"
                          method="post">
                        @csrf
                        <label class="lb-1">Full Name <span class="required">*</span></label>
                        <input class="form-control" name="name" value="{{old('name')}}" type="text"
                               placeholder="e.g. Michelle Tan"/>
                        @if ($errors->has('name'))
                            <span class="text-danger d-block">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                        <label class="lb-1">Email Address <span class="required">*</span></label>
                        <input class="form-control" name="email" value="{{old('email')}}" type="email"
                               placeholder="e.g. michelletan@verzdesign.com"/>
                        @if ($errors->has('email'))
                            <span class="text-danger d-block">
                                {{ $errors->first('email') }}
                            </span>
                        @endif

                        <label class="lb-1">Password <span class="required">*</span></label>
                        <div class="hasicon">
                            <input id="enterpassword" class="form-control" name="password" type="password"
                                   placeholder="Enter Password"/>
                            <i toggle="#enterpassword" class="ico toggle-password"></i>
                            @if ($errors->has('password'))
                                <span class="text-danger d-block">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="lb-1">Date of Birth <span class="required">*</span></label>
                                <div class="date-wrap">
                                    <i class="fa-solid fa-calendar-days ico"></i>
                                    <input class="form-control" name="dob" value="{{old('dob')}}" type="text"
                                           placeholder="dd/mm/yyyy"/>
                                    @if ($errors->has('dob'))
                                        <span class="text-danger d-block">
                                            {{ $errors->first('dob') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="lb-1">Gender <span class="required">*</span></label>
                                <select class="selectpicker" name="gender">
                                    <option value="">Please Select</option>
                                    <option value="1" @if(old('gender') == 1) selected @endif>Male</option>
                                    <option value="2" @if(old('gender') == 2) selected @endif>Female</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="text-danger d-block">
                                        {{ $errors->first('gender') }}
                                    </span>
                                @endif
                            </div>

                        </div>
                        <label class="lb-1">Phone Number <span class="required">*</span></label>
                        <div class="row sp-col-10">
                            <div class="col-auto sp-col">
                                <select class="selectpicker" name="country_code_phone">
                                    <option value="+65" @if(old('country_code_phone') == '+65') selected @endif>+65</option>
                                    <option value="+84" @if(old('country_code_phone') == '+84') selected @endif>+84</option>
                                </select>
                            </div>
                            <div class="col sp-col">
                                <input class="form-control" name="mobile"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       r̥ value="{{old('mobile')}}" type="text" placeholder="e.g. 8765 4321"/>
                                @if ($errors->has('mobile'))
                                    <span class="text-danger d-block">
                                        {{ $errors->first('mobile') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <label class="lb-1">Address</label>
                        <textarea class="form-control" name="address" value="{{old('address')}}" cols="30" rows="3"
                                  placeholder="Enter Address">{{old('address') ?? ''}}</textarea>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="lb-1">Country <span class="required">*</span></label>
                                <select class="selectpicker" name="country_code">
                                    <option value="">Please Select</option>
                                    <option value="+65" @if(old('country_code') == '+65') selected @endif>Singapore</option>
                                    <option value="+63" @if(old('country_code') == '+63') selected @endif>Vietnam</option>
                                </select>
                                @if ($errors->has('country_code'))
                                    <span class="text-danger d-block">
                                        {{ $errors->first('country_code') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label class="lb-1">Instructor <span class="required">*</span></label>
                                <select class="selectpicker" name="instructor">
                                    <option value="">Please Select</option>
                                    @foreach($instructors as $instructor)
                                        <option value="{{$instructor->id}}" @if(old('instructor') == $instructor->id) selected @endif>{{$instructor->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('instructor'))
                                    <span class="text-danger d-block">
                                        {{ $errors->first('instructor') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="output-1">
                            <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-md-5 col-sm-3 sp-col order-sm-first bg image">
                <img class="bgimg" src="images/tempt/student-registration.jpg" alt=""/>
            </div>
        </div>
    </main>


@endsection
