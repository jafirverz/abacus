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
						<h1>My Invoices</h1>
					</div>
					<div class="table-responsive">
						<table class="tb-1 type">
							<thead>
								<tr>
									<th class="text-center">Nos.</th>
									<th>Invoice No.</th>
									<th>Invoice Date</th>
									<th>Invoice Type</th>
									<th>Vehicle No.</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($my_invoices))
								@php $i=0; @endphp
								@foreach($my_invoices as $key=>$invoice)
								@php $i++; @endphp
								<tr>
									<td class="text-center">{{ $i }}</td>
									<td>{{ $invoice->invoice_no }}</td>
									<td>{{ date( 'd-m-Y', strtotime($invoice->created_at) ) }}</td>
									<td>{{ getInvoiceTypes($invoice->invoice_type) }}</td>
									<td>{{ $invoice->vehicle_number }}</td>
									<td>{{ getInvoiceStatus($invoice->status) ?? '' }}<br><a href="{{ url('view-invoice/'.$invoice->id) }}">View Invoice</a></td>
								</tr>
								@endforeach
								<tr><td colspan="6">{{$my_invoices->links()}}</td></tr>
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