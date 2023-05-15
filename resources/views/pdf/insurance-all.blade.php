<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body width="100%" style="margin: 0; padding: 0; background-color: #fff;">
	<table align="center" cellspacing="0" cellpadding="0" border="0"
		style="width: 1000px;font-family: 'Opensans', Arial, sans-serif; font-size:16px;margin: 30px auto; page-break-after: always;">
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
									{{$insurance->main_driver_full_name}}</td>

							</tr>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>NRIC:</strong>
									{{$insurance->main_driver_nric}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Marital Status:</strong>
									{{$insurance->main_driver_marital_status}}</td>
							</tr>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>Date of Birth:</strong>
									{{$insurance->main_driver_date_of_birth}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Occupation:</strong>
									{{$insurance->main_driver_occupation}}</td>
							</tr>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>License Passed Date:</strong>
									{{$insurance->main_driver_license_pass_date}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Contact Number:</strong>
									{{$insurance->main_driver_country_code.$insurance->main_driver_contact_number}}</td>
							</tr>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>Gender:</strong>
									{{$insurance->main_driver_gender}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Email Address:</strong>
									{{$insurance->main_driver_email}}</td>
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
									{{$insurance->driver_full_name}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Gender:</strong>
									{{$insurance->driver_gender}}</td>

							</tr>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>NRIC:</strong>
									{{$insurance->driver_nric}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Marital Status:</strong>
									{{$insurance->driver_marital_status}}</td>

							</tr>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>Date of Birth:</strong>
									{{$insurance->driver_date_of_birth}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Occupation:</strong>
									{{$insurance->driver_occupation}}</td>

							</tr>
							<tr>
								<td style="padding: 5px 20px; width: 50%;"><strong>License Passed Date:</strong>
									{{$insurance->driver_license_pass_date}}</td>
								<td style="padding: 5px 20px; width: 50%;"><strong>Relationship to Main Driver:</strong>
									{{$insurance->relationship_main_driver}}</td>
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
									<strong>Car Plate Number:</strong> {{$insurance->vehicles_car_plate_no}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Make/Model:</strong> {{$insurance->make_model}}</td>
							</tr>
							<tr>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Engine Capacity:</strong> {{$insurance->engine_capacity}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Date of Registration:</strong> {{$insurance->date_of_registration}}</td>
							</tr>
							<tr>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Year of Manufacture:</strong> {{$insurance->year_of_manufacture}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Is this an OPC Car:</strong> @if($insurance->is_opc_car==1) Yes @else No
									@endif
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
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
			</tr>
			<tr>
				<td style="padding: 10px 0;">
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tbody>
							<tr>
								<td
									style="color: #E63D30; font-family: 'Opensans', Arial, sans-serif; font-size:18px; font-weight: bold;padding: 10px 20px 5px;width: 50%;">
									<strong>NCD (%)</strong></td>
								<td
									style="color: #E63D30; font-family: 'Opensans', Arial, sans-serif; font-size:18px; font-weight: bold;padding: 10px 20px 5px;width: 50%;">
									<strong>From previous vehicle number</strong></td>
							</tr>
							<tr>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									{{$insurance->ncd}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									{{$insurance->previous_vehicle_number}}</td>
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
								<td style="padding: 5px 20px 5px 10px;">
									&nbsp;{!! $termandcondition !!}
								</td>
							</tr>

						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	<table align="center" cellspacing="0" cellpadding="0" border="0"
		style="width: 1000px;font-family: 'Opensans', Arial, sans-serif; font-size:16px;margin: 30px auto; ">
		<tbody>
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
									<img width="17" src="{{url('images/tempt/ico-checked.jpg')}}" alt="check" /> @else
									<img width="17" src="{{url('images/tempt/ico-check.jpg')}}" alt="check" /> @endif
								</td>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									<?=$quotation->quotation_number?></td>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									<?=$quotation->insurer_name?></td>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									<?=$quotation->premium?></td>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									<?php
										if(isset($insurance->discount))
										{
										echo $discount=$insurance->discount*$quotation->premium/100 ;
										}
										else
										{
										echo $discount=systemSetting()->insurance_discount*$quotation->premium/100 ;
										}
										?>
								</td>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									<?=$quotation->premium-$discount?></td>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									<?=$quotation->excess_own_damage?></td>
								<td
									style="border:#ECECEC solid 1px; border-left: none; border-top: none; padding: 10px;">
									<?=$quotation->excess_party?></td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	<table align="center" cellspacing="0" cellpadding="0" border="0"
		style="width: 1000px;font-family: 'Opensans', Arial, sans-serif; font-size:16px;margin: 30px auto; page-break-after: always;">
		<tbody>
			<tr>
				<td
					style="background: #f1f1f1; font-family: 'Opensans', Arial, sans-serif; font-size:20px; font-weight: bold; padding: 10px 20px;">
					Insurance Details</td>
			</tr>
			<tr>
				<td style="padding: 10px 0 20px;">
					<?php $quote=getQuotation($insurance->quotation_id);?>
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tbody>
							<tr>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Address:</strong> {{$quote->address??'-'}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Engine
										Number:</strong> {{$quote->engine_number??'-'}}</td>
							</tr>
							<tr>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Chassis
										Number:</strong> {{$quote->chassis_number??'-'}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Finance
										Company:</strong> {{$quote->finance_company??'-'}}</td>
							</tr>
							<tr>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Start Date of
										Proposal:</strong> {{date('j F Y',strtotime($quote->start_date_of_proposal))}}
								</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>End
										Date:</strong> {{date('j F Y',strtotime($quote->end_date))}}</td>
							</tr>
							<tr>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Seating
										Capacity:</strong> {{$quote->seating_capacity??'-'}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Previous
										Insurer:</strong> {{$quote->previous_insurer??'-'}}</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	<table align="center" cellspacing="0" cellpadding="0" border="0"
		style="width: 1000px;font-family: 'Opensans', Arial, sans-serif; font-size:16px;margin: 30px auto; ">
		<tbody>
			@if(isset($quote->insurance_proposal_form))
			<tr>
				<td style="padding: 10px 0 20px;">
					<img width="700" src="{{url($quote->insurance_proposal_form)}}" alt="" />
				</td>
			</tr>
			@endif
			<tr>
				<td style="padding: 10px 0 20px;">
					<table cellspacing="0" cellpadding="0" border="0"
						style="margin: 0 auto;width: 400px;text-align: center;">
						<tbody>
							<tr>
								<td style="padding: 5px 20px;width: 50%;">
									@if(isset($quote->partner_sign))
									<img height="106" src="{{url($quote->partner_sign)}}" alt="" />
									@endif
								</td>
								<td style="padding: 5px 20px;width: 50%;">&nbsp;</td>
								<td style="padding: 5px 20px;width: 50%;">
									@if(isset($quote->customer_sign))
									<img height="106" src="{{url($quote->customer_sign)}}" alt="" />
									@endif
								</td>
							</tr>
							<tr>
								<td
									style="font-family: 'Opensans', Arial, sans-serif; font-size: 14px;padding: 10px 20px 30px;">
									Insurance Partner's Signature</td>
								<td style="padding: 10px 20px 30px;">&nbsp;</td>
								<td
									style="font-family: 'Opensans', Arial, sans-serif; font-size: 14px;padding: 10px 20px 30px;">
									Applicant's Signature</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>

</body>

</html>
