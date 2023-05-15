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
						<a class="btn-1" href="{{ url('advertise-my-car-form') }}">Add new car listing <i
								class="fas fa-arrow-right"></i></a>
						<h1>My Car Listing</h1>
					</div>
					<div class="table-responsive">
						<table class="tb-1 type">
							<thead>
								<tr>
									<th class="text-center">No.</th>
									<th>Vehicle No.</th>
									<th>Vehicle Make</th>
									<th>Vehicle Model</th>
									<th>Price</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@if($my_cars)
								@php $i=0;@endphp
								@foreach($my_cars as $car)
								@php $i++;@endphp
								<tr>
									<td class="text-center">{{ $i }}</td>
									<td>{{ $car->vehicle_number }}</td>
									<td>{{ $car->vehicle_make }}</td>
									<td>{{ $car->vehicle_model }}</td>
									<td>${{ number_format($car->price) }}</td>
									<td>{{ getVehicleStatus( $car->status) ?? '' }}</td>
								</tr>
								@endforeach
								<tr>
									<td colspan="8">{{$my_cars->links()}}</td>
								</tr>
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