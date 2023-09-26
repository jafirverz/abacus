@extends('layouts.appAccountID')

@section('content')

    <main class="main-wrap">
        <div class="row sp-col-0 tempt-1">
            <div class="col-lg-6 col-md-7 col-sm-9 sp-col order-sm-last">
                <div class="tempt-1-content">
                    @include('inc.messages')
                    <div class="intro-1">
                        <h1 class="title-1">Forgot Account ID</h1>
                        <p>Please enter the details to get Account ID</p>
                    </div>
                    <hr/>
                    <form action="{{route('forgetaccountid')}}" method="post">
                        @csrf
                        <label class="lb-1">Full Name <span class="required">*</span></label>
                        <input class="form-control" type="text" value="{{old('name')}}" name="name" placeholder="Enter Full Name" />
                        @if ($errors->has('name'))
                            <span class="text-danger d-block">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                        <label class="lb-1">Email Address <span class="required">*</span></label>
                        <input class="form-control" type="text" value="{{old('email')}}" name="email" placeholder="Enter Email Address" />
                        @if ($errors->has('email'))
                            <span class="text-danger d-block">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                        <label class="lb-1">Date of Birth <span class="required">*</span></label>
                        <div class="date-wrap">
                            <i class="fa-solid fa-calendar-days ico"></i>
                            <input class="form-control" name="dob" value="{{old('dob')}}" type="text" placeholder="dd/mm/yyyy" />
                            @if ($errors->has('dob'))
                                <span class="text-danger d-block">
                                {{ $errors->first('dob') }}
                            </span>
                            @endif
                        </div>
                        <div class="output-1">
                            <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-md-5 col-sm-3 sp-col order-sm-first bg image">
                <img class="bgimg" src="{{asset('images/tempt/forgot-password.jpg')}}" alt="Forgot Password" />
            </div>
        </div>
    </main>

@endsection
