<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>	@page  {	  margin: 0;	  size: letter; 	}	</style>
</head>

<body width="100%" style="margin: 0; padding: 0; background-color: #fff;">
	<table align="center" cellspacing="0" cellpadding="0" border="0"
		style="width: 500px;font-family: 'Opensans', Arial, sans-serif; font-size:16px;margin: 30px auto;">
		<thead>
			<tr>
				<th
					style="color:#E63D30;font-size:36px;font-family: 'Opensans', Arial, sans-serif; padding-bottom: 30px">
					Insurance</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td
					style="background: #f1f1f1; font-family: 'Opensans', Arial, sans-serif; font-size:20px; font-weight: bold; padding: 10px 20px;">
					Section 1: Main Driver's Particulars</td>
			</tr>
			<tr>
				<td style="padding: 10px 0 20px;">
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tbody>
							<tr>
								<td colspan="2" style="padding: 5px 20px; width: 100%; "><strong>Name:</strong>
									{{$insurance->main_driver_full_name ?? ''}}</td>

							</tr>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>NRIC:</strong>
									{{$insurance->main_driver_nric ?? ''}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Marital Status:</strong>
									{{$insurance->main_driver_marital_status ?? ''}}</td>
							</tr>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>Passport:</strong>
									{{$insurance->main_driver_passport ?? ''}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Nationality:</strong>
									{{$insurance->main_driver_nationality ?? ''}}</td>
							</tr>
							<tr>
								@php 
								if(!empty($insurance->main_driver_date_of_birth)){
									$dob = date('d-m-Y', strtotime($insurance->main_driver_date_of_birth));
								}else{
									$dob = '';
								}
								@endphp
								<td style="padding: 5px 20px; width: 50%;"><strong>Date of Birth:</strong>
									{{$dob}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Address:</strong>
									{{$insurance->main_driver_address ?? ''}}</td>
							</tr>
							<tr>
								
								<td style="padding: 5px 20px; width: 50%;"><strong>Contact Number:</strong>
									{{$insurance->main_driver_country_code.$insurance->main_driver_contact_number}}</td>
							</tr>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>Gender:</strong>
									{{$insurance->main_driver_gender ?? ''}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Email Address:</strong>
									{{$insurance->main_driver_email ?? ''}}</td>
							</tr>
							
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>Occupation:</strong>
									{{$insurance->main_driver_occupation ?? ''}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Name of Employer:</strong>
									{{$insurance->main_driver_employer ?? ''}}</td>
							</tr>
							
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>Qualified Driving License Class:</strong>
									{{$insurance->main_driver_licence_class ?? ''}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Qualified Driving License Validity:</strong>
									{{$insurance->main_driver_licence_validity ?? ''}}</td>
							</tr>
							
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>Certificate of Merit Status:</strong>
									{{$insurance->main_driver_merit_status ?? ''}}</td>
							
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			@if($insurance->named_driver==1)
			<tr>
				<td
					style="background: #f1f1f1; font-family: 'Opensans', Arial, sans-serif; font-size:20px; font-weight: bold; padding: 10px 20px;">
					Section 2</td>
			</tr>
			<tr>
				<td
					style="color: #E63D30; font-family: 'Opensans', Arial, sans-serif; font-size:18px; font-weight: bold; padding: 15px 20px 0;">
					Named Driver </td>
			</tr>
			<tr>
				<td style="padding: 10px 0 20px;">
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tbody>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>Name:</strong>
									{{$insurance->driver_full_name ?? ''}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Gender:</strong>
									{{$insurance->driver_gender ?? ''}}</td>

							</tr>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>NRIC:</strong>
									{{$insurance->driver_nric ?? ''}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Marital Status:</strong>
									{{$insurance->driver_marital_status ?? ''}}</td>

							</tr>
							<tr>
								@php 
								if(!empty($insurance->driver_date_of_birth)){
									$dob1 = date('d-m-Y', strtotime($insurance->driver_date_of_birth));
								}else{
									$dob1 = '';
								}
								@endphp
								<td style="padding: 5px 20px; width: 50%;"><strong>Date of Birth:</strong>
									{{$dob1}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Occupation:</strong>
									{{$insurance->driver_occupation ?? ''}}</td>

							</tr>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>Nationality:</strong>
									{{$insurance->driver_nationality ?? ''}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Relationship to Main Driver:</strong>
									{{$insurance->relationship_main_driver ?? ''}}</td>
							</tr>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>Qualified Driving License Class:</strong>
									{{$insurance->driver_license_class ?? ''}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Qualified Driving License Validity:</strong>
									{{$insurance->driver_license_validity ?? ''}}</td>
							</tr>
							
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>Certificate of Merit Status:</strong>
									{{$insurance->driver_merit_status ?? ''}}</td>
								
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			@endif
			<tr>
				<td
					style="background: #f1f1f1; font-family: 'Opensans', Arial, sans-serif; font-size:20px; font-weight: bold; padding: 10px 20px;">
					Vehicle Details for Insurance Quotation</td>
			</tr>
			<tr>
				<td style="padding: 10px 0 20px;">
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tbody>
							<tr>
								<td style=" padding: 5px 20px; width: 50%">
									<strong>Vehicle Number:</strong> {{$insurance->vehicles_car_plate_no ?? ''}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Vehicle Scheme:</strong> {{$insurance->vehicle_schme ?? ''}}</td>
							</tr>
							<tr>
								<td style=" padding: 5px 20px; width: 50%">
									<strong>Vehicle Type:</strong> {{$insurance->vehicle_type ?? ''}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Make/Model:</strong> {{$insurance->make_model ?? ''}}</td>
							</tr>
							<tr>
								@php 
								if(!empty($insurance->date_of_registration)){
									$dor1 = date('d-m-Y', strtotime($insurance->date_of_registration));
								}else{
									$dor1 = '';
								}
								@endphp
								<td style=" padding: 5px 20px; width: 50%">
									<strong>Original Registration Date:</strong> {{$dor1}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Primary Color:</strong> {{$insurance->vehicle_primary_color ?? ''}}</td>
							</tr>
							<tr>
								<td style=" padding: 5px 20px; width: 50%">
									<strong>Year of Manufacture:</strong> {{$insurance->year_of_manufacture ?? ''}}</td>
							<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
								@php
								if(!empty($insurance->engine_capacity)){
									$engineC = number_format($insurance->engine_capacity);
								}else{
									$engineC = '';
								}
								@endphp
									<strong>Engine Capacity:</strong> {{$engineC ?? ''}}</td>
							</tr>
							<tr>
							    <td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Engine Number:</strong> {{$insurance->vehicle_engine_number ?? ''}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Chassis Number:</strong> {{$insurance->vechile_chasis_number ?? ''}}</td>
								
							</tr>
							<tr>
							    
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Propellant:</strong> {{$insurance->vechile_propellant ?? ''}}</td>
							</tr>
							
						</tbody>
					</table>
				</td>
			</tr>
			{{--<tr>
				<td
					style="color: #E63D30; font-family: 'Opensans', Arial, sans-serif; font-size:18px; font-weight: bold; padding: 10px 20px 5px;">
					If you don't have the information</td>
			</tr>
			<tr>
				<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%"><strong>Car Plate
						Number:</strong> {{$insurance->car_plate_no}}</td>
			</tr>
			<tr>
				<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
					<strong>NRIC/UEN/Business/Passport Number:</strong> {{$insurance->nric_uen_business_passport}}</td>
			</tr>--}}
			<tr>
				<td style="padding: 10px 0;">
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tbody>
							<tr>
								<td
									style="color: #E63D30; font-family: 'Opensans', Arial, sans-serif; font-size:18px; font-weight: bold;padding: 10px 20px 5px;width: 40%;">
									<strong>Type of Quote</strong></td>
								<td
									style="color: #E63D30; font-family: 'Opensans', Arial, sans-serif; font-size:18px; font-weight: bold;padding: 10px 20px 5px;width: 20%;">
									<strong>NCD (%)</strong></td>
								<td
									style="color: #E63D30; font-family: 'Opensans', Arial, sans-serif; font-size:18px; font-weight: bold;padding: 10px 20px 5px;width: 40%;">
									<strong>From previous vehicle number</strong></td>
							</tr>
							<tr>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 40%">
									{{$insurance->type_of_quote ?? ''}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 20%">
									{{$insurance->ncd ?? ''}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 40%">
									{{$insurance->previous_vehicle_number ?? ''}}</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table cellspacing="0" cellpadding="0" border="0" style="width: 100%;text-align: left;">
						<tbody>
							<tr>
								<td style="padding: 5px 0 5px 20px; width: 30px; vertical-align: top;">
									<img src="{{ asset('images/tempt/ico-checked-2.jpg') }}" alt="" />
								</td>
								<td style="padding: 5px 20px 5px 10px; vertical-align: top;">
									{!! $termandcondition !!}
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>			<tr style="page-break-after: always;">				<td					style="height:30px;">&nbsp;</td>			</tr>

			<tr>
				<td
					style="background: #f1f1f1; font-family: 'Opensans', Arial, sans-serif; font-size:20px; font-weight: bold; padding: 10px 20px;">
					Quotation Details</td>
			</tr>
			<tr>
				<td style="padding: 10px 0 20px;">
					<table cellspacing="0" cellpadding="0" border="0"
						style="border-left:#ECECEC solid 1px;font-family: 'Opensans', Arial, sans-serif; text-align: center;"
						width="100%">
						<thead>
							<tr>
								<th style="background: #1A1C1E; border:#fff solid 1px; border-left: none; border-top: none; color: #fff; padding: 10px;"
									rowspan="2">&nbsp;</th>
								<th style="background: #1A1C1E; border:#fff solid 1px; border-left: none; border-top: none; color: #fff; padding: 10px;"
									rowspan="2">Quotation</th>
								<th style="background: #1A1C1E; border:#fff solid 1px; border-left: none; border-top: none; color: #fff; padding: 10px;"
									rowspan="2">Insurer</th>
								<th style="background: #1A1C1E; border:#fff solid 1px; border-left: none; border-top: none; color: #fff; padding: 10px;"
									rowspan="2">Premium</th>
								<th style="background: #1A1C1E; border:#fff solid 1px; border-left: none; border-top: none; color: #fff; padding: 10px;"
									rowspan="2">@if(isset($insurance->discount)) {{$insurance->discount}} @else
									{{systemSetting()->insurance_discount}}@endif% <br>Discount</th>
								<th style="background: #1A1C1E; border:#fff solid 1px; border-left: none; border-top: none; color: #fff; padding: 10px;"
									rowspan="2">Premium after <br>Discount</th>
								<th style="background: #1A1C1E; border:#fff solid 1px; border-left: none; border-top: none; color: #fff; padding: 10px;"
									colspan="2">Excess</th>
							</tr>
							<tr>
								<th
									style="background: #1A1C1E; border:#fff solid 1px; border-left: none; border-top: none; color: #fff; padding: 10px;">
									<small>Own <br>Damage</small></th>
								<th
									style="background: #1A1C1E; border:#fff solid 1px; border-left: none; border-top: none; color: #fff; padding: 10px;">
									<small>3rd <br>Party</small></th>
							</tr>
						</thead>
						<tbody>
							@if($quotations)
							@php $i=0; @endphp
							@foreach($quotations as $quotation)
							@php $i++; @endphp
							<tr>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									@if(isset($insurance->quotation_id) && $insurance->quotation_id==$quotation->id)
									<img width="17" src="{{url('images/tempt/ico-checked.jpg')}}" alt="check" /> 
                  @else
									<img width="17" src="{{url('images/tempt/ico-check.jpg')}}" alt="check" /> 
                  @endif
								</td>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									{{$quotation->quotation_number ?? ''}}</td>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									{{$quotation->insurer_name ?? ''}}</td>
									@php 
									if(!empty($quotation->premium)){
									    $quotationPremiumF = str_replace('$', '', $quotation->premium);
										$quotationPremium = '$'.number_format($quotationPremiumF, 2);
									}else{
										$quotationPremium = '';
									}
									@endphp
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									{{$quotationPremium ?? ''}}</td>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									<?php
										if(isset($insurance->discount))
										{
										    $disT = (int)$insurance->discount;
											$discountt = $discount=$disT*$quotationPremiumF/100 ;
											$discountt = '$'.number_format($discountt,2);
										}
										else
										{
										    $disT = (int)systemSetting()->insurance_discount;
											$discountt =  $discount=$disT*$quotationPremiumF/100 ;
											$discountt = '$'.number_format($discountt,2);
										}
										?>
										{{$discountt??''}}
								</td>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									${{number_format($quotationPremiumF - $discount, 2) ?? ''}}</td>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									@php 
									if(!empty($quotation->excess_own_damage)){
									    $ownD = str_replace('$', '', $quotation->excess_own_damage);
										$ownD = '$'.number_format($ownD);
									}else{
										$ownD = '';
									}
									@endphp
									{{$ownD ?? ''}}
								</td>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									@php 
									if(!empty($quotation->excess_party)){
									    $exparty = str_replace('$', '', $quotation->excess_party);
										$exparty = '$'.number_format($exparty);
									}else{
										$exparty = '';
									}
									@endphp
									{{$exparty??''}}
									</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</td>
			</tr>			<tr>				<td					style="height:30px;">&nbsp;</td>			</tr>

			

		</tbody>
	</table>

</body>

</html>
