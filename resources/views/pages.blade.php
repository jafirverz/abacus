@extends('layouts.app')

@section('content')
@if(strpos(url()->current(), 'thank-you-loan-enquiry') || strpos(url()->current(), 'thank-you') || strpos(url()->current(), 'thank-you-quote-my-car') || strpos(url()->current(), 'insurance-form-thank-you') || strpos(url()->current(), 'advertise-my-car-thank-you'))
@else
@include('inc.banner')
@endif
@if(strpos(url()->current(), 'thank-you-loan-enquiry') || strpos(url()->current(), 'thank-you') || strpos(url()->current(), 'thank-you-quote-my-car') || strpos(url()->current(), 'insurance-form-thank-you') || strpos(url()->current(), 'advertise-my-car-thank-you'))
{!! $page->content !!}
@else
<div class="main-wrap">
				<div class="container main-inner">
					<h1 class="title-1 text-center">{{ $page->title ?? '' }}</h1>
                    @include('inc.breadcrumb')
					<div class="document">
						{!! $page->content !!}

					</div>
				</div>
			</div>
            @endif
@endsection
