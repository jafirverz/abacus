@extends('layouts.appLogin')

@section('content')
<main class="main-wrap">
    <div class="row sp-col-0 tempt-1">
        <div class="col-lg-6 col-md-7 col-sm-9 sp-col order-sm-last">
            <div class="tempt-1-content">
                <div class="intro-1">
                    <h1 class="title-1">Forgot Password</h1>
                    <p>Please enter the details to reset password</p>
                </div>
                <hr />
                @include('inc.messages')
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" action="{{ url('password/email') }}" class="form-ani">
                    @csrf
                    <label class="lb-1">Full Name <span class="required">*</span></label>
                    <input class="form-control" type="text" required name="name" placeholder="Enter Full Name" value="{{ old('name') }}" />
                    <label class="lb-1">Email Address <span class="required">*</span></label>
                    <input class="form-control  @error('email') is-invalid @enderror" type="text"
                        placeholder="Enter Email Address" id="email" type="email" name="email"
                        value="{{ old('email') }}" />
                    @error('email')
                    <span class="text-danger d-block">{{ $message }}</span>
                    @enderror
                    <label class="lb-1">Date of Birth <span class="required">*</span></label>
                    <div class="date-wrap">
                        <i class="fa-solid fa-calendar-days ico"></i>
                        <input class="form-control" name="dob" required type="text" placeholder="dd/mm/yyyy" value="{{ old('dob') }}" />
                    </div>
                    <div class="output-1">
                        <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6 col-md-5 col-sm-3 sp-col order-sm-first bg image">
            <img class="bgimg" src="{{ asset('images/tempt/forgot-password.jpg') }}" alt="Forgot Password" />
        </div>
    </div>
</main>

@endsection