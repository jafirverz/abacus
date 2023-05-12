@extends('layouts.app')
@section('content')
<div class="main-wrap" style="padding-bottom: 305.8px; padding-top: 118.8px;">
	<div class="bn-inner bg-get-image">
		<img class="bgimg" src="images/tempt/bn-loan.jpg" alt="Loan Applications">
	</div>
	@include('inc.messages')
	<form action="{{ route('my-profile.update') }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="container main-inner">
			<div class="row">
				<div class="col-lg-3 mb-991-30">
					@include('inc.account-profile-image')
					@include('inc.account-sidebar')

				</div>
				<div class="col-lg-9">
					<div class="title-5 type">
						<a class="btn-1" href="{{ url('quote-my-car-form') }}">Quote My Car <i class="fas fa-arrow-right"></i></a>
						<h1>My Quote Requests</h1>
					</div>
					<div class="table-responsive">
						<table class="tb-1 type">
							<thead>
								<tr>
									<th class="text-center">No.</th>
									<th>Quote Request Date</th>
									<th>Vehicle No.</th>
									<th>NRIC/FIN</th>
									<th>Mileage Estimated</th>
									<th>Quote Expiry Date</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($my_quote_requests))
								@php $i=0; @endphp
								@foreach($my_quote_requests as $quote_request)
								@php $i++; @endphp

								@php 
								if(!empty($quote_request->mileage)){
									$mill = number_format($quote_request->mileage). ' Km';
								}else{
									$mill = '';
								}
								if(!empty($quote_request->quote_expiry_date)){
									$qExpiry = date('d-m-Y', strtotime($quote_request->quote_expiry_date));
								}else{
									$qExpiry = '';
								}
								@endphp
								<tr>
									<td class="text-center">{{ $i }}</td>
									<td>{{ date( 'd-m-Y', strtotime($quote_request->created_at) ) }}</td>
									<td>{{ $quote_request->vehicle_number }}</td>
									<td>{{ $quote_request->nric }}</td>
									<td>{{ $mill }}</td>
									<td>{{ $qExpiry }}</td>
									@php 
									$quoteRequest = getQuoteRequestStatus( $quote_request->status);
									if($quoteRequest == 'Approved'){
										$link = url('view-quote').'/'.$quote_request->id;
										$content = '<a href="'.$link.'">View Quote</a>';
									}else{
										$content = $quoteRequest;
									}
									@endphp
									<td>{!! $content !!}</td>
								</tr>
								@endforeach
								<tr><td colspan="8">{{$my_quote_requests->links()}}</td></tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection
