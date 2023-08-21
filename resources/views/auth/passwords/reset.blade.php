@extends('layouts.appLogin')

@section('content')
<div class="main-wrap">
    <div class="bn-inner bg-get-image">
        <img class="bgimg" src="/images/tempt/bn-sign-up.jpg" alt="Sign Up" />
    </div>
    <div class="container main-inner">
        <h1 class="title-1 text-center">{{ __('Reset Password') }}</h1>
        <ul class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active">{{ __('Reset Password') }}</li>
        </ul>
        <div class="maxw-750 ml-auto mr-auto">
            @include('inc.messages')
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            @include('inc.messages')
            <form method="POST" action="{{ route('password.update') }}" class="form-log">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group row">
                    <div class="col-md-12">
                        <label>Email:</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ $email }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label>{{ __('Password') }}:</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label>{{ __('Confirm Password') }}:</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">

                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn-1 minw-190"> {{ __('Reset Password') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection