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

      @if(isset($insurance->insurance_vehicle))
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
									<strong>Vehicle Number:</strong> {{$insurance->insurance_vehicle->vehicles_car_plate_no ?? ''}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Vehicle Scheme:</strong> {{$insurance->insurance_vehicle->vehicle_schme ?? ''}}</td>
							</tr>
							<tr>
								<td style=" padding: 5px 20px; width: 50%">
									<strong>Vehicle Type:</strong> {{$insurance->insurance_vehicle->vehicle_type ?? ''}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Make/Model:</strong> {{$insurance->insurance_vehicle->make_model ?? ''}}</td>
							</tr>
							<tr>
								@php 
								if(!empty($insurance->insurance_vehicle->date_of_registration)){
									$dor1 = date('d-m-Y', strtotime($insurance->insurance_vehicle->date_of_registration));
								}else{
									$dor1 = '';
								}
								@endphp
								<td style=" padding: 5px 20px; width: 50%">
									<strong>Original Registration Date:</strong> {{$dor1}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Primary Color:</strong> {{$insurance->insurance_vehicle->vehicle_primary_color ?? ''}}</td>
							</tr>
							<tr>
								<td style=" padding: 5px 20px; width: 50%">
									<strong>Year of Manufacture:</strong> {{$insurance->insurance_vehicle->year_of_manufacture ?? ''}}</td>
							<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
								@php
								if(!empty($insurance->insurance_vehicle->engine_capacity)){
									$engineC = number_format($insurance->insurance_vehicle->engine_capacity);
								}else{
									$engineC = '';
								}
								@endphp
									<strong>Engine Capacity:</strong> {{$engineC ?? ''}}</td>
							</tr>
							<tr>
							    <td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Engine Number:</strong> {{$insurance->insurance_vehicle->vehicle_engine_number ?? ''}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Chassis Number:</strong> {{$insurance->insurance_vehicle->vechile_chasis_number ?? ''}}</td>
								
							</tr>
							<tr>
							    
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 50%">
									<strong>Propellant:</strong> {{$insurance->insurance_vehicle->vechile_propellant ?? ''}}</td>
							</tr>
							
						</tbody>
					</table>
				</td>
			</tr>
      @endif
			
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
									{{$insurance->insurance_information->type_of_quote ?? ''}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 20%">
									{{$insurance->insurance_information->ncd ?? ''}}</td>
								<td style="font-family: 'Opensans', Arial, sans-serif; padding: 5px 20px; width: 40%">
									{{$insurance->insurance_information->previous_vehicle_number ?? ''}}</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
						

			

		</tbody>
	</table>

</body>

</html>
