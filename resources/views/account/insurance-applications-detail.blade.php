@extends('layouts.app')
@section('content')
<style>
    .signature-pad--body { }
    .signature-pad--footer { margin-top: 5px; }
    .signature-pad--actions .button { background: #ddd; border: none; border-radius: 5px; display; inline-block; margin: 5px 5px 0 0; padding: 3px 15px; }
    .signature-pad--actions .button:hover { background: #333; color: #fff; }
    .signature-pad--body canvas { border: #E1E1E1 solid 1px; width: 100%; height: 200px; }
</style>
<?php
	$content = [];
    if($page2->json_content){
        $content = json_decode($page2->json_content, true);
    }

?>
<div class="main-wrap">
				@include('inc.banner')
				<div class="container main-inner">
					<h1 class="title-1 text-center">Insurance</h1>
                    @include('inc.breadcrumb')
                    @include('inc.messages')

										@if(isset($partners) && $partners->count()>0)
			<h2 class="title-2 mt-50 mt-991-30">Quotation Details</h2>
			<form method="post" class="form-ani" action="{{url('quotation-submit')}}">
				@csrf
				@php
				$k=0;
				$i=0;
				@endphp
				@foreach($partners as $key=>$val)
				@php
				$k++;
				$quotations=getQuotationByPartner($val->partner_id,$insurance->id);
				$admin=getUserAdmin($val->partner_id);
				@endphp
				@if($insurance->quotation_id==null)
				@if(isset($admin)) <div class="title-3 mt-30">{{$admin->firstname.' '.$admin->lastname}}</div> @endif
				@endif
				<div class="table-responsive">
					<table class="tb-1 detail text-center">
						<thead>
							<tr>
								<th rowspan="2">Select one</th>
								<th rowspan="2">Quotation</th>
								<th rowspan="2">Insurer</th>
								<th rowspan="2">Premium</th>
								<th rowspan="2">@if(isset($insurance->discount)) {{$insurance->discount}} @else
									{{systemSetting()->insurance_discount}}@endif% <br>Discount</th>
								<th rowspan="2">Premium after <br>Discount</th>
								<th colspan="2">Excess</th>
								<th rowspan="2">Remark</th>
							</tr>
							<tr>
								<th><small>Own <br>Damage</small></th>
								<th><small>3rd <br>Party</small></th>
							</tr>
						</thead>
						<tbody>


							@foreach($quotations as $quotation)
							@php $i++; @endphp
							<tr>
								<td>
									<div class="radio">
										<input @if(isset($insurance->quotation_id)) disabled @endif @if(isset($insurance->quotation_id) &&
										$insurance->quotation_id==$quotation->id)checked="checked" @endif type="radio" value="
										<?=$quotation->id?>" name="quotation" id="check-{{$i}}">
										<label for="check-{{$i}}"></label>
									</div>
								</td>
								<td>
									<?=$quotation->quotation_number?>
								</td>
								<td>
									<?=$quotation->insurer_name?>
								</td>
								@php 
								if(!empty($quotation->premium)){
								    $quotaPremiumF = str_replace('$', '', $quotation->premium);
									$quotaPremium = '$'.number_format($quotaPremiumF, 2);
								}else{
									$quotaPremium = '';
								}
								@endphp
								<td>
									{{$quotaPremium ?? ''}}
								</td>
								<td>
									<?php
										if(isset($insurance->discount))
										{
										  //  dd($discountt);
										    $removeDis = (int)$insurance->discount;
										    $discountt = $discount=$removeDis*$quotaPremiumF/100 ;
											$discountt = '$'.number_format($discountt,2);
										}
										else
										{
										    $removeDis = (int)systemSetting()->insurance_discount;
											$discountt =  $discount=(int)$removeDis*$quotaPremiumF/100 ;
											$discountt = '$'.number_format($discountt,2);
										}
										?>
										{{$discountt??''}}
								</td>
								@php
								$diffquot = $quotaPremiumF - $discount;
								$diffquot = '$'.number_format($diffquot, 2);
								@endphp
								<td>
									{{$diffquot ?? ''}}
								</td>
								<td>
									@php 
									if(!empty($quotation->excess_own_damage)){
									    $ownD = str_replace('$', '', $quotation->excess_own_damage);
										$ownD = '$'.number_format($quotation->excess_own_damage);
									}else{
										$ownD = '';
									}
									@endphp
									{{$ownD ?? ''}}
								</td>
								<td>
									@php 
									if(!empty($quotation->excess_party)){
									    $exparty = str_replace('$', '', $quotation->excess_party);
										$exparty = '$'.number_format($quotation->excess_party);
									}else{
										$exparty = '';
									}
									@endphp
									{{$exparty??''}}
								</td>
								<td>{{$quotation->remark ?? '-'}}</td>
							</tr>
							@endforeach

						</tbody>
					</table>
				</div>
				@endforeach
				@if(!isset($insurance->quotation_id))
				<div class="mt-30 text-center">
					<button class="btn-1 minw-190 accept" type="submit">ACCEPT <i class="fas fa-arrow-right"></i></button>
				</div>
				@endif
				<input type="hidden" value="{{$insurance->id??''}}" name="insurance_id" />
			</form>
			@endif
										<form method="post" class="form-ani" action="{{ route('insurance.store') }}" enctype="multipart/form-data">
											@csrf
											<h2 class="title-2 mb-0 mt-30">Section 1: Main Driver's Particulars</h2>		 
										
											<div class="row">
												<div class="col-lg-4">
													<div class="inrow">
														<label>Full name</label>
														<input type="text" class="form-control" readonly name="main_driver_full_name" id="main_driver_full_name"
															value="{{$insurance->main_driver_full_name??""}}" />
														
													</div>
												</div>
												<div class="col-lg-4">
													<div class="inrow">
														<label>NRIC/FIN</label>
														<input type="text" class="form-control" readonly name="main_driver_nric" id="main_driver_nric"
															value="{{$insurance->main_driver_nric??''}}" />
													</div>
													
												</div>
												<div class="col-lg-4">
													<div class="inrow">
														<label>Passport Number (Optional) </label>
														<input type="text" name="main_driver_passport" readonly class="form-control"
															value="{{$insurance->main_driver_passport??''}}" />
													</div>
													
												</div>
											</div>		
											<div class="row">
												<div class="col-xl-6">
													<div class="row sp-col-10 break-425">
														<div class="col-xl-5 col-lg-6 col-sm-4 col-5 sp-col">
															<div class="mt-20">
																<div class="inrow">
																	<label>Country Code </label>
																	<input type="text" name="main_driver_country_code" readonly class="form-control"
																		value="{{$insurance->main_driver_country_code??''}}" />
																</div>
															</div>
														</div>
														<div class="col-xl-7 col-lg-6 col-sm-8 col-7 sp-col">
															<div class="inrow">
																<label>Mobile Number</label>
																<input type="text" class="form-control positive-integer" readonly
																	name="main_driver_contact_number"
																	id="main_driver_contact_number" value="{{$insurance->main_driver_contact_number??''}}" />
															</div>
															
														</div>
													</div>
												</div>
												<div class="col-xl-6">
													<div class="inrow">
														<label>Email Address</label>
														<input type="text" class="form-control"  name="main_driver_email" readonly id="main_driver_email"
															value="{{$insurance->main_driver_email??''}}" />
													</div>
													
												</div>
											</div>
											<div class="row">
												<div class="col-lg-3">
													<div class="inrow">
														<label>Nationality</label>
														<input type="text" class="form-control"  name="main_driver_nationality" readonly id="main_driver_email"
															value="{{$insurance->main_driver_nationality??''}}" />
													</div>
													
												</div>
												<div class="col-lg-9">	
													<div class="inrow">
														<label>Registered address</label>
														<input type="text" class="form-control" readonly
																	name="main_driver_address"
																	id="main_driver_address" value="{{$insurance->main_driver_address??''}}" />
													</div>
													
												</div>
											</div>
											<div class="row">
												<div class="col-xl-4">
													<div class="inrow">
														<label>Gender</label>
														<input type="text" class="form-control" readonly
																name="main_driver_gender"
																	id="main_driver_gender" value="{{$insurance->main_driver_gender??''}}" />
													</div>
												</div>
												<div class="col-xl-4">	
													<div class="inrow">
														<label>Marital Status</label>
														<input type="text" class="form-control" readonly
																name="main_driver_marital_status"
																	id="main_driver_marital_status" value="{{$insurance->main_driver_marital_status??''}}" />
													</div>	
													
												</div>
												<div class="col-md-4 sp-col">													
													<div class="inrow date-wrap datepicker-wrap">
														<label>Date Of Birth</label>
														<input type="text" class="form-control" readonly  name="main_driver_date_of_birth" value="{{date('d-m-Y', strtotime($insurance->main_driver_date_of_birth))??''}}" />
													</div>
													
												</div>
											</div>		
											<div class="row">
												<div class="col-lg-5">
													<div class="inrow">
														<label>Occupation</label>
														<input type="text" class="form-control" readonly  name="main_driver_occupation" id="main_driver_occupation"
															value="{{$insurance->main_driver_occupation??''}}" />
													</div>
												
												</div>
												<div class="col-lg-7">
													<div class="inrow">
														<label>Name of employer</label>
														<input type="text" class="form-control" readonly  name="main_driver_employer" id="main_driver_employer"
															value="{{$insurance->main_driver_employer??''}}" />
													</div>
												</div>
												
											</div>
											<div class="row">
													<div class="col-lg-4">
													<div class="inrow">
														<label>Qualified driving License class (Ex: 3, YYYY-MM-DD) </label>
														<input type="text" class="form-control" readonly name="main_driver_licence_class" value="{{$insurance->main_driver_licence_class??''}}" />
													</div>
													
												</div>
												<div class="col-xl-4">	
													<div class="inrow">
														<label>Qualified Driving License Validity</label>
														<input type="text" class="form-control" readonly name="main_driver_licence_validity" value="{{$insurance->main_driver_licence_validity??''}}" />
													</div>	
													
												</div>
												<div class="col-xl-4">
													<div class="inrow">
														<label>Certificate of merit Status</label>
														<input type="text" class="form-control" readonly name="main_driver_merit_status" value="{{$insurance->main_driver_merit_status??''}}" />
													</div>		
													
												</div>
											</div>
										
											
											<h2 class="title-2 mb-0 mt-30">Section 2:</h2>	
											<!-- <div class="grtype mt-20">							
												<h3 class="title-6 item"><span><strong>Named Driver: </strong></span></h3>
												<div class="check-inline check-control item">
													<div class="radio">
														<input type="radio" id="yes" name="use" value="yesdriver" />
														<label for="yes">Yes</label>
													</div>
													<div class="radio">
														<input type="radio" name="use" id="no" value="nodriver" checked />
														<label for="no">No</label>
													</div>
												</div>
											</div> -->
											<div class="grtype mt-20">
												<h3 class="title-6 item"><span><strong>Named Driver: </strong></span></h3>
												<div class="check-inline item">
													<div class="radio">
														<input type="radio" id="yes" name="nameddriver" disabled value="1" @if($insurance->named_driver == 1) checked @endif />
														<label for="yes">Yes</label>
													</div>
													<div class="radio">
														<input type="radio" name="nameddriver" id="no" disabled @if($insurance->named_driver == 2 || $insurance->named_driver == 0) checked @endif value="2" />
														<label for="no">No</label>
													</div>
												</div>
											</div>
										
											<div id="nodriver" class="check-content">	
											</div>
										
											@if($insurance->named_driver == 1)
											<div id="namedDriver" class="">							
												<div class="row">
													<div class="col-lg-4">
														<div class="inrow">
															<label>Full name</label>
															<input type="text" class="form-control" readonly name="driver_full_name" value="{{$insurance->driver_full_name??''}}" />
														</div>
													
													</div>
													<div class="col-lg-4">
														<div class="inrow">
															<label>NRIC/FIN <span class="required">*</span></label>
															<input type="text" class="form-control" readonly name="driver_nric" value="{{$insurance->driver_nric??''}}" />
														</div>
														
													</div>	
													<div class="col-lg-4">
														<div class="inrow">
															<label>Passport Number (Optional)</label>
															<input type="text" class="form-control" readonly name="driver_passport" value="{{$insurance->driver_passport??''}}" />
														</div>
														
													</div>	
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="inrow">
															<label>Driver Gender</label>
															<input type="text" class="form-control" readonly name="driver_passport" value="{{$insurance->driver_gender??''}}" />
														</div>
													</div>
													<div class="col-lg-4">
														<div class="inrow">
															<label>Date Of Birth</label>
															<input type="text" class="form-control" readonly name="driver_date_of_birth" value="{{date('d-m-Y', strtotime($insurance->driver_date_of_birth))??''}}" />
														</div>
														
													</div>
													<div class="col-lg-4">
														<div class="inrow">
															<label>Driver Nationality</label>
															<input type="text" class="form-control" readonly name="driver_date_of_birth" value="{{$insurance->driver_nationality??''}}" />
														</div>
													</div>
													
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="inrow">
															<label>Occupation</label>
															<input type="text" class="form-control" readonly name="driver_occupation" value="{{$insurance->driver_occupation??''}}" />
														</div>
														
													</div>
													<div class="col-lg-4">	
														<div class="mt-20">
															<div class="inrow">
																<label>Relation</label>
																<input type="text" class="form-control" readonly name="driver_occupation" value="{{$insurance->relationship_main_driver??''}}" />
															</div>
														</div>
													</div>
													<div class="col-lg-4">
														<div class="inrow">
															<label>Driver Marital Status</label>
															<input type="text" class="form-control" readonly name="driver_date_of_birth" value="{{$insurance->driver_marital_status??''}}" />
														</div>
													</div>
													
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="inrow">
															<label>Qualified Driving license Class (Example: 3, YYYY-MM-DD) </label>
															<input type="text" class="form-control" readonly name="driver_license_class" value="{{$insurance->driver_license_class??''}}" />
														</div>
													
													</div>
													<div class="col-lg-4">
														<div class="inrow">
															<label>Qualified Driving License Validity</label>
															<input type="text" class="form-control" readonly name="driver_license_class" value="{{$insurance->driver_license_validity??''}}" />
															
															
														</div>
														
													</div>
										
													<div class="col-lg-4">
														<div class="inrow">
															<label>Certificate of Merit Status</label>
															<input type="text" class="form-control" readonly name="driver_license_class" value="{{$insurance->driver_merit_status??''}}" />
														</div>
														
													</div>
													
												</div>
											</div>
											@endif


										
										
										
										@php 
										$selectedVehicle = old('vehicle') ?? '';
										if(empty($selectedVehicle)){
											if(!empty($nric)){
												$selectedVehicle = 1;
												$classVehicle1 = '';
												$classVehicle2 = 'hide';
											}else{
												$selectedVehicle = 2;
												$classVehicle1 = 'hide';
												$classVehicle2 = '';
											}
										}else{
											if($selectedVehicle == 1){
												$selectedVehicle = 1;
												$classVehicle1 = '';
												$classVehicle2 = 'hide';
											}else{
												$selectedVehicle = 2;
												$classVehicle1 = 'hide';
												$classVehicle2 = '';
											}
											
										}
										@endphp
											<h2 class="title-2 mt-30">Vehicle Details for Insurance Quotation</h2>	
											{{-- <div class="check-inline">
												<div class="radio">
													<input type="radio" id="myinfo" name="vehicle" value="1" @if($selectedVehicle == 1) checked @endif />
													<label for="myinfo">Vehicle Information using MyInfo</label>
												</div>
												<div class="radio">
													<input type="radio" name="vehicle" id="othervehicle" @if($selectedVehicle == 2) checked @endif value="2" />
													<label for="othervehicle">Get Quotation for Other Vehicle</label>
												</div>
											</div>
											--}}

											<div id="myinfoForm">
											<div class="row">
												<div class="col-lg-4">	
													<div class="inrow">
														<label>Vehicle Number</label>
														<input type="text" class="form-control" readonly name="car_plate_no1" value="{{$insurance->insurance_vehicle->vehicles_car_plate_no??''}}" />
													</div>
													
												</div>
												<div class="col-lg-4">	
													<div class="inrow">
														<label>Vehicle Scheme</label>
														<input type="text" class="form-control" readonly name="vehicle_schme1" value="{{$insurance->insurance_vehicle->vehicle_schme??''}}" />
													</div>	
												</div>
												<div class="col-lg-4">	
													<div class="inrow">
														<label>Vehicle Type</label>
														<input type="text" class="form-control" readonly name="vehicle_type1" value="{{$insurance->insurance_vehicle->vehicle_type??''}}" />
													</div>	
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">	
													<div class="inrow">
														<label>Vehicle Make / Model</label>
														<input type="text" class="form-control" readonly name="vehicle_make1" value="{{$insurance->insurance_vehicle->make_model??''}}" />
													</div>
													
												</div>
												
												<div class="col-lg-4">	
													<div class="inrow">
														<label>Original Registration Date</label>
														<input type="text" class="form-control" readonly value="{{date('d-m-Y', strtotime($insurance->insurance_vehicle->date_of_registration))??''}}" name="date_of_registration1" />
													</div>
												
												</div>
												<div class="col-lg-4">	
													<div class="inrow">
														<label>Primary Color</label>
														<input type="text" class="form-control" readonly name="vehicle_primary_color1" value="{{$insurance->insurance_vehicle->vehicle_primary_color??''}}" />
													</div>
													
											</div>
											</div>
											<div class="row">
												
												<div class="col-lg-4">	
													<div class="inrow">
														<label>Year of Manufacture</label>
														<input type="text" class="form-control" readonly name="year_of_manufacture1" value="{{$insurance->insurance_vehicle->year_of_manufacture??''}}" />
													</div>
												
												</div>
												@php
												if($insurance->insurance_vehicle){
													if(!empty($insurance->insurance_vehicle->engine_capacity)){
														$engineCapacity = number_format($insurance->insurance_vehicle->engine_capacity);
													}else{
														$engineCapacity = '';
													}
												}else{
													$engineCapacity = '';
												}
												@endphp
												<div class="col-lg-4">	
													<div class="inrow">
														<label>Engine Capacity (CC)</label>
														<input type="text" class="form-control" readonly name="engine_capacity1" value="{{$engineCapacity??''}}" />
													</div>
													@if ($errors->has('engine_capacity1'))
													<span class="text-danger">&nbsp;{{ $errors->first('engine_capacity1') }}</span>
													@endif
												</div>
												<div class="col-lg-4">		
													<div class="inrow">
														<label>Engine Number</label>
														<input type="text" class="form-control" readonly name="vehicle_engine_number1" value="{{$insurance->insurance_vehicle->vehicle_engine_number??''}}" />
													</div>
												</div>
											</div>
											<div class="row">
												
												<div class="col-lg-4">		
													<div class="inrow">
														<label>Chassis Number</label>
														<input type="text" class="form-control" readonly name="vechile_chasis_number1" value="{{$insurance->insurance_vehicle->vechile_chasis_number??''}}" />
													</div>
												</div>
												<div class="col-lg-4">		
													<div class="inrow">
														<label>Propellant</label>
														<input type="text" class="form-control" readonly name="vechile_propellant1" value="{{$insurance->insurance_vehicle->vechile_propellant??''}}" />
													</div>
												</div>
											</div>
										</div>
										
										
										
										
										
										
										
										
											<hr class="mt-40"/>
											<h2 class="title-2 mt-30">No Claim Discount (NCD)</h2>
											<div class="row">
												<div class="col-lg-4">	
													<div class="inrow">
														<label>Type of Quote</label>
														<input type="text" class="form-control" readonly name="type_of_quote" value="{{$insurance->insurance_information->type_of_quote ??''}}" />
													</div>
													
												</div>
												<div class="col-lg-4">	
													<div class="inrow">
														<label>NCD (%)</label>
														<input type="text" class="form-control" readonly name="vechile_propellant1" value="{{$insurance->ncd_percentage??''}}" />
													</div>
												</div>
												<div class="col-lg-4">	
													<div class="inrow">
														<label>Previous Vehicle No.</label>
														<input type="text" class="form-control" readonly name="previous_vehicle_no" value="{{$insurance->previous_vehicle_no??''}}" />
													</div>
												</div>
											</div>
										
										</form>

									@if(!empty($insurance->document1) || !empty($insurance->document2))
									<h2 class="title-2 mt-50 mt-991-30">Uploded Documents</h2>
									@if(!empty($insurance->document1))
									<p><a href="{{asset('images/'.$insurance->document1)}}" target="_blank">LTA</a></p>
									@endif
									@if(!empty($insurance->document2))
									<p><a href="{{asset('images/'.$insurance->document2)}}" target="_blank">Vehicle Registration Document</a></p>
									@endif
									@endif


			
				</div>
			</div>

            <script type="text/javascript">
			$(".accept").click(function() {
			   if ($('input[name="quotation"]:checked').length == 0) {
				 alert('Please choose quotation.');
				 return false;
				 }
			   return true;
    		});

    $(function() {
        $(".seller, .buyer").find("input, select, textarea").attr("disabled", true);
        $("input[name='customer_sign']").attr("disabled", false);
        $('.positive-integer').numeric(
            {negative: false}
        );

        var canvas = document.querySelector("canvas");


        var signaturePad = new SignaturePad(canvas, {
            onEnd: function () {
                $("input[name='customer_sign']").val(signaturePad.toDataURL("image/jpeg"));
            },
            backgroundColor: "white",
        });
    });
</script>
@endsection