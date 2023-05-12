@extends('layouts.app')
@section('content')
<div class="main-wrap" style="padding-bottom: 305.8px; padding-top: 118.8px;">
	<div class="bn-inner bg-get-image">
		<img class="bgimg" src="images/tempt/bn-loan.jpg" alt="Loan Applications">
	</div>

		<div class="container main-inner">
			<div class="row">
				<div class="col-lg-3 mb-991-30">
					@include('inc.account-profile-image')
					@include('inc.account-sidebar')

				</div>
				<form id="destroy" action="{{ url('insurance-applications/archived') }}" method="post">
					@csrf
					<input type="hidden" name="multiple_archive" id="multiple_archive" value="">
				</form>
				<div class="col-lg-9">
					<div class="title-5">
						<h1>Insurance Applications</h1>
					</div>
					<a href="javascript::void(0);" onclick="confirmDeleteData();" class="btn-3 archive-sum destroy" title="Archive" disabled="">  Archive</a>
					
					@include('inc.messages')
                
					<div class="table-responsive">
						<table class="tb-1 type">
							<thead>
								<tr>
									<th>
										<div class="custom-checkbox custom-control">
												<input type="checkbox" data-checkboxes="mygroup"
														class="custom-control-input chk_boxes" id="checkbox-all">
												<label for="checkbox-all" class="custom-control-label">&nbsp;</label>
										</div>
								</th>
									<th class="text-center">Sr. No.</th>
									<th>Car Place No.</th>
									<th>Make/Model</th>
									<th>Name</th>
									<th>NRIC</th>
									<th>Contact No.</th>
									<th>Status</th>
									<th width="22%">Action</th>
								</tr>
							</thead>
							<tbody>
								@if($insurance)
								@php $i=0;@endphp
								@foreach($insurance as $ins)
								@php $i++;@endphp
								<tr>
									<td><input type="checkbox" class="checkbox" name="seletedarchive" value="{{ $ins->id }}" data-id="{{ $ins->id }}"></td>
									<td class="text-center">{{$i}}</td>
									<td>{{$ins->insurance_information->car_plate_no}}</td>
									<td>{{$ins->insurance_vehicle->make_model}}</td>
									<td>{{$ins->main_driver_full_name}}</td>
									<td>{{$ins->main_driver_nric}}</td>
									<td>{{$ins->main_driver_country_code.$ins->main_driver_contact_number}}</td>
									<td>@if($ins->status==1) Completed @else Processing @endif</td>
									<td>

										@if(isset($ins->insurance_pdf) && !empty($ins->quotation_id))
										<a class="lnk-1 hasico" target="_blank" href="{{asset('insurance_form/'.$ins->insurance_pdf)}}"><i
												class="fas fa-file-download mr-1"></i>View Agreement</a>
										@else
										<a class="lnk-1 hasico" href="{{url('insurance-applications/'.$ins->id)}}"><i
												class="fas fa-eye mr-1"></i>View Application</a>
										@endif
										
										@php
										$inssQ = App\InsuranceQuotation::where('id', $ins->quotation_id)->first();
										@endphp
										@if(isset($inssQ->insurance_proposal_form) && !empty($inssQ->insurance_proposal_form))
                                           <a href="{{ asset($inssQ->insurance_proposal_form) }}" target="_blank">Insurance Proposal Form</a>
                                        @endif
									</td>
								</tr>
								@endforeach
								<tr>
									<td colspan="8">{{$insurance->links()}}</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
			$('#checkbox-all').on('click',function(){
					if(this.checked){
							$('.checkbox').each(function(){
									this.checked = true;
							});
							// $('.destroy').removeClass('d-none');
							$('.badge-transparent').text('5');
					}else{
							 $('.checkbox').each(function(){
									this.checked = false;
							});
							// $('.destroy').addClass('d-none');
					}
			});
			$('.checkbox').on('click',function(){
					if($('.checkbox:checked').length == $('.checkbox').length){
							$('#select_all').prop('checked',true);
					}else{
							$('#select_all').prop('checked',false);
					}
			});
	});

	function confirmDeleteData(event){
			var employee = [];  
			$(".checkbox:checked").each(function() {  
					employee.push($(this).data('id'));
			});	
			if(employee.length <=0)  {  
					alert("Please select records.");  
			}else{
					if (confirm("Are you sure you want to archive the form?")) {
							$('#multiple_archive').val(employee);
							$('#destroy').submit();
					}
					return false;
					
			}
	}
	</script>
@endsection