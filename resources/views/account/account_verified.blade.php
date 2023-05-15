@extends('layouts.app')

@section('content')
            <div class="main-wrap thanks-wrap">		
				<div class="container main-inner">
					<div class="content">
						<h1><strong>Thank you</strong> for account verification!</h1>
						<p>You have successfully verified your account, You can now log in to the portal. </p>
						<a class="btn-1" href="{{ route('login') }}">Login <i class="fas fa-arrow-right"></i></a>
					</div>
				</div>
			</div>
@endsection
