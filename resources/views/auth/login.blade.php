@extends('layouts.appLogin')

@section('content')

    <main class="main-wrap">
        <div class="row sp-col-0 tempt-1">
            <div class="col-lg-6 col-md-7 col-sm-9 sp-col order-sm-last">
                <div class="tempt-1-content">
                    <div class="intro-1">
                        @include('inc.messages')
                        <h1 class="title-1">Login</h1>
                        <p>Please enter the details to login</p>
                    </div>
                    <hr/>
                    <form method="post" action="{{ route('login') }}">
                        @csrf
                        <label class="lb-1">Account ID <span class="required">*</span></label>
                        <input class="form-control" value="{{old('account_id')}}" type="text" placeholder="Enter Account ID" name="account_id"/>
                        @if ($errors->has('account_id'))
                            <span class="text-danger d-block">
                                {{ $errors->first('account_id') }}
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
                        <div class="wrap-1">
                            <a href="{{url('forget-account-id')}}">Forgot Account ID?</a><a href="{{url('/password/reset')}}">Forgot Password?</a>
                        </div>
                        <div class="wrap-2">For existing student who does not have an account, please register <a
                                href="{{url('register')}}">here</a>.
                        </div>
                        <div class="output-1">
                            <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @php
            $pageId = 2;
            $bannerImage = \App\Banner::where('page_id', $pageId)->first();
            if($bannerImage){
                $image = asset($bannerImage->banner_image);
            }else{
                $image = asset('images/tempt/login.jpg');
            }
            @endphp
            <div class="col-lg-6 col-md-5 col-sm-3 sp-col order-sm-first bg image">
                <img src="{{$image}}" alt="login"/>
            </div>
        </div>
    </main>

@endsection
