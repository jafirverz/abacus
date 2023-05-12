@extends('layouts.app')

@section('content')
<div class="main-wrap">				
				<div class="bn-inner bg-get-image">
					<img class="bgimg" src="/images/tempt/bn-sign-up.jpg" alt="Sign Up" />
				</div>  
				<div class="container main-inner">
					<h1 class="title-1 text-center">Password Reset</h1>
                    <ul class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active">Password Reset</li>
                    </ul>
					<div class="maxw-750 ml-auto mr-auto">
                    @include('inc.messages')
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
					@include('inc.messages')      
                   <form method="POST" action="{{ url('password/email') }}"  class="form-ani">
                        @csrf
                         <div class="form-group row">
                            <div class="col-md-12">
                            <div class="inrow mt-0">
                                 <label>Email:</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                           </div>
                                @error('email')
                                <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn-1 minw-190"> {{ __('Request') }}</button>
                            </div>
                        </div>
                    </form>
					</div>
				</div>
			</div>
@endsection
