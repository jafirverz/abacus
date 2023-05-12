<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DIY Cars</title>
	<style>
		th {
			text-align: left;
			width: 35%;
		}
	</style>
</head>

<body>
	<div class="main-container">
		<header>
			<a class="logo" href="javascript::void(0);">
				<img src="images/diy-cars-logo.png" alt="DIY Cars" style="width:250px;" />
			</a>
		</header>

		<div class="main-content">
			<h1>Loan</h1>
			<hr>
			<div class="row">
				<div class="col-6">
					<h3>Vehicle Information of The Car You’re Purchasing </h3>
					<table width="100%">
						<tr>
							<th>Vehicle No:</th>
							<td>{{ $loan->vehicle_registration_no ?? '' }}</td>
						</tr>
						<tr>
							<th>Owner ID Type:</th>
							<td>{{ $loan->owner_id_type ?? '' }}</td>
						</tr>
						<tr>
							<th>Owner ID:</th>
							<td>{{ $loan->nric_company_registration_no ?? '' }}</td>
						</tr>
					</table>
					<hr>
					<h3>Applicant’s Information</h3>
					<table width="100%">
						<tr>
							<th>Full Name:</th>
							<td>{{ $loan->applicant_name ?? '' }}</td>
						</tr>
						<tr>
							<th>NRIC:</th>
							<td>{{ $loan->owner_nric ?? '' }}</td>
						</tr>
						<tr>
							<th>Passport:</th>
							<td>{{ $loan->passport ?? '' }}</td>
						</tr>
						<tr>
							<th>Country Code:</th>
							<td>{{ $loan->country_code ?? '' }}</td>
						</tr>
						<tr>
							<th>Contact No:</th>
							<td>{{ $loan->applicant_contact ?? '' }}</td>
						</tr>
						<tr>
							<th>Email:</th>
							<td>{{ $loan->applicant_email ?? '' }}</td>
						</tr>
						<tr>
							<th>Address:</th>
							<td>{{ $loan->address ?? '' }}</td>
						</tr>
						
						<tr>
							<th>Gender:</th>
							<td>{{ $loan->gender ?? '' }}</td>
						</tr>
						<tr>
							<th>Marital status:</th>
							<td>{{ $loan->marital_status ?? '' }}</td>
						</tr>
						<tr>
							<th>DOB:</th>
							<td>{{ date('d-m-Y', strtotime($loan->dob)) ?? '' }}</td>
						</tr>
						<tr>
							<th>Company Name:</th>
							<td>{{ $loan->company_name ?? '' }}</td>
						</tr>
						<tr>
							<th>Company Address:</th>
							<td>{{ $loan->company_address ?? '' }}</td>
						</tr>
						<tr>
							<th>Company Postal Code:</th>
							<td>{{ $loan->company_postal_code ?? '' }}</td>
						</tr>
						<tr>
							<th>Occupation:</th>
							<td>{{ $loan->occupation ?? '' }}</td>
						</tr>
						<tr>
							<th>Period Of Service (Year):</th>
							<td>{{ $loan->service_period_year ?? '' }}</td>
						</tr>

						<tr>
							<th>Period Of Service (Month):</th>
							<td>{{ $loan->service_period_month ?? '' }}</td>
						</tr>
						<tr>
							<th>Monthly Salary:</th>
							@php
							if(!empty($loan->monthly_salary)){
								$monthlySalary = '$'. number_format($loan->monthly_salary);
							}else{
								$monthlySalary = '';
							}
							@endphp
							<td>{{ $monthlySalary ?? '' }}</td>
						</tr>

					</table>
					<hr>

				</div>
				<hr>
				<div class="col-6">
					<h3>Loan Details</h3>
					<table width="100%">
						<tr>
							<th>Purchase Price:</th>
							<td>${{ number_format($loan->loan_purchase_price) ?? '' }}</td>
						</tr>
						<tr>
							<th>Loan Amount:</th>
							<td>${{ number_format($loan->loan_amount) ?? '' }}</td>
						</tr>
						<tr>
							<th>Down Payment:</th>
							<td>${{ number_format($loan->down_payment) ?? '' }}</td>
						</tr>
						<tr>
							<th>Bank and Interest:</th>
							<td>{{ $loan->bank->title ?? '' }} - {{ $loan->bank->interest ?? '' }}%</td>
						</tr>
						<!-- <tr>
							<th>Tenor:</th>
							<td>{{ $loan->address ?? '' }}</td>
						</tr> -->
						@if($loan->tenor == 2)
						<tr>
							<th>Loan Period (Years):</th>
							<td>{{ $loan->year ?? '' }}</td>
						</tr>
						<tr>
							<th>Loan Period (Month):</th>
							<td>{{ $loan->month ?? '' }}</td>
						</tr>
						@endif
						<tr>
							<th>Estimated Monthly Installment:</th>
							@php
							if(!empty($loan->estimated_monthly_installment)){
								$estimated_monthly_installment = '$'. number_format($loan->estimated_monthly_installment);
							}else{
								$estimated_monthly_installment = '';
							}
							@endphp
							<td>{{ $estimated_monthly_installment ?? '' }}</td>
						</tr>

					</table>
					<hr>
					@php
					$tradeDetails = json_decode($loan->trade_details, true);
					@endphp
					<h3>Need a Quote For Your Trade In?</h3>
					<table width="100%">
						<tr>
							<th>Vehicle No:</th>
							<td>{{ $tradeDetails['vehicle_no'] ?? '' }}</td>
						</tr>
						<tr>
							<th>Owner ID Type:</th>
							<td>{{ $tradeDetails['owner_id_typ'] ?? '' }}</td>
						</tr>
						<tr>
							<th>Owner ID:</th>
							<td>{{ $tradeDetails['nric'] ?? '' }}</td>
						</tr>
						<tr>
							<th>Mileage:</th>
							@php
							if(!empty($tradeDetails['estimated_mileage'])){
								$estimated_mileage = number_format($tradeDetails['estimated_mileage']) .' km';
							}else{
								$estimated_mileage = '';
							}
							@endphp
							<td>{{ $estimated_mileage ?? '' }}</td>
						</tr>

					</table>
					<hr>
					<table cellpadding="0" cellspacing="0" width="100%"
						style="border: #ddd solid 1px;font-family: Arial, 'sans-serif';font-size: 14px;">
						<tr>
							<td style="font-size: 20px; font-weight: bold;padding: 10px;text-align: center;">Sign:</td>
						</tr>
						<tr>
							<td style="height:100px;padding: 10px;text-align: center;">&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:12px;padding: 10px;text-align: center;">Sign Here</td>
						</tr>
					</table>
				</div>
			</div>



		</div>
		<footer>© 2022 DIY Cars Pte Ltd. All rights reserved.</footer>
</body>

</html>