@extends('layouts.app')

@section('content')
<div class="bg-get-image bg-cover login-page">  
					<img class="bgimg" src="{{asset('images/img1/login.jpg')}}" alt="">
					<div class="container">
						<div class="row">
							<div class="col-lg-5 offset-lg-7 col-md-6 offset-md-6">
                                @include('inc.messages')
                                @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                                </div>
                                @endif
								<form class="form-log">
									<h3 class="title-2 text-center">Don’t have an Account?</h3>
									<a href="{{url('login/facebook')}}" class="btn-c btn-facebook btn-full"><i class="fab fa-facebook"></i> Continue with Facebook</a>
									<a href="{{url('login/google')}}" class="btn-c btn-google btn-full"><img src="{{asset('images/img1/google.png')}}" alt=""> Continue with Google</a>
									<hr/>
									<a href="{{url('register')}}" class="btn-2 btn-c btn-full">Sign up with email</a>
								</form>
							</div>
						</div>
					</div>
				</div>
@endsection
