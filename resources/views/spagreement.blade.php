<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>DIY Cars</title>

	<style>	

		th {

			text-align: left;

		}

	</style>

</head>



<body>

	<header>

		<img src="images/diy-cars-logo.png" alt="DIY Cars" style="width:250px;" />

	</header>

	<h1 style="font-family: Arial, 'sans-serif';font-size: 24px; margin: 20px 0 10px;">Sales and Purchase Agreement</h1>

	<hr>			

	<table cellpadding="0" cellspacing="0" width="100%" style="font-family: Arial, 'sans-serif';font-size: 12px;page-break-after: always;">

		<tr>

			<td style="padding: 10px 0;" valign="top">

				<table cellpadding="0" cellspacing="0" width="100%">						

					<tbody>

						<tr>

							<td style="background: #f6f6f6; border: #ddd solid 1px; font-size: 18px; font-weight: bold; padding: 5px 10px;">Seller's Particulars</td>

						</tr>

						<tr>

							<td style="border: #ddd solid 1px; padding: 0 10px 10px;">

								<table cellpadding="0" cellspacing="0" width="100%">

									{{--<tr>

										<td colspan="2" style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;">Company's Information</td>

									</tr>

									<tr>

										<th style="width:150px;padding: 10px 10px 5px;">Company Name:</th>

										<td style="padding:4px 10px;">{{ $seller_particular->company_name ?? '' }}</td>

									</tr>

									<tr>

										<th style="width:150px;padding: 4px 10px;">UEN:</th>

										<td style="padding:4px 10px;">{{ $seller_particular->uen ?? '' }}</td>

									</tr>

									<tr>

										<th style="width:150px;padding: 4px 10px;">Registered Address:</th>

										<td style="padding:4px 10px;"></td>

									</tr> --}}

									<tr>

										<td colspan="2" style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;">Personal Information</td>

									</tr>

									<tr>

										<th style="width:150px;padding: 10px 10px 4px;">Full Name:</th>

										<td style="padding:4px 10px;">{{ $seller_particular->seller_name ?? '' }}</td>

									</tr>

                  <tr>

										<th style="width:150px;padding: 4px 10px;">NRIC:</th>

										<td style="padding:5px 10px;">{{ $seller_particular->nric ?? '' }}</td>

									</tr>

                  <tr>

										<th style="width:150px;padding: 4px 10px;">Passport:</th>

										<td style="padding:5px 10px;">{{ $seller_particular->passport ?? '' }}</td>

									</tr>

									<tr>

										<th style="width:150px;padding: 4px 10px;">Gender:</th>

										<td style="padding:5px 10px;">{{ $seller_particular->seller_gender ?? '' }}</td>

									</tr>

                  <tr>

										<th style="width:150px;padding: 4px 10px;">Contact No.:</th>

										<td style="padding:5px 10px;">{{$seller_particular->seller_country_code ?? ''}} {{ $seller_particular->seller_mobile ?? '' }}</td>

									</tr>

									<tr>

										<th style="width:150px;padding: 4px 10px;">Address:</th>

										<td style="padding:5px 10px;">{{ $seller_particular->address ?? '' }}</td>

									</tr>

									<tr>

										<th style="width:150px;padding: 4px 10px;">Email:</th>

										<td style="padding:5px 10px;">{{ $seller_particular->seller_email ?? '' }}</td>

									</tr>

									

									

									

								</table>

							</td>

						</tr>

					</tbody>

				</table>

			</td>

		</tr>

		<tr>

			<td style="padding: 10px 0;" valign="top">

				<table cellpadding="0" cellspacing="0" width="100%">						

					<tbody>

						<tr>

							<td style="background: #f6f6f6; border: #ddd solid 1px; font-size: 18px; font-weight: bold; padding: 5px 10px;">Buyer's Particulars</td>

						</tr>

						<tr>

							<td style="border: #ddd solid 1px; padding: 0 10px 10px;">

								<table cellpadding="0" cellspacing="0" width="100%">

									{{--<tr>

										<td colspan="2" style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;">Company's Information</td>

									</tr>

									<tr>

										<th style="width:170px;padding: 5px 10px 3px;">Company Name:</th>

										<td style="padding:4px 10px;">{{ $buyer_particular->company_name ?? '' }}</td>

									</tr>

									<tr>

										<th style="width:170px;padding: 3px 10px;">UEN:</th>

										<td style="padding:4px 10px;">{{ $buyer_particular->uen ?? '' }}</td>

									</tr>

									<tr>

										<th style="width:170px;padding: 3px 10px;">Registered Address:</th>

										<td style="padding:4px 10px;"></td>

									</tr>--}}

									<tr>

										<td colspan="2" style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;">Personal Information</td>

									</tr>

									<tr>

										<th style="width:170px;padding: 4px 10px;">Full Name:</th>

										<td style="padding:4px 10px;">{{ $buyer_particular->buyer_name ?? '' }}</td>

									</tr>

									<tr>

										<th style="width:170px;padding: 4px 10px;">NRIC:</th>

										<td style="padding:4px 10px;">{{ $buyer_particular->nric ?? '' }}</td>

									</tr>

									<tr>

										<th style="width:170px;padding: 4px 10px;">Passport:</th>

										<td style="padding:4px 10px;">{{ $buyer_particular->passport ?? '' }}</td>

									</tr>

									<tr>

										<th style="width:170px;padding: 4px 10px;">Gender:</th>

										<td style="padding:4px 10px;">{{ $buyer_particular->buyer_gender ?? '' }}</td>

									</tr>

								

									<tr>

										<th style="width:170px;padding: 4px 10px;">Contact No.:</th>

										<td style="padding:4px 10px;">{{ $buyer_particular->country_code ?? '' }} {{ $buyer_particular->phone ?? '' }}</td>

									</tr>

									<tr>

										<th style="width:170px;padding: 4px 10px;">Address:</th>

										<td style="padding:4px 10px;">{{ $buyer_particular->address ?? '' }}</td>

									</tr>

                  <tr>

										<th style="width:170px;padding: 4px 10px;">Email:</th>

										<td style="padding:4px 10px;">{{ $seller_particular->buyer_email ?? '' }}</td>

									</tr>

								</table>	

							</td>

						</tr>

					</tbody>

				</table>

			</td>

		</tr>
		<tr>

			<td style="padding: 10px 0;" valign="top">

				<table cellpadding="0" cellspacing="0" width="100%">

					<tr>

						<td style="background: #f6f6f6; border: #ddd solid 1px; font-size: 18px; font-weight: bold; padding: 5px 10px;">Vehicle Details</td>

					</tr>
					<tr>

						<td style="border: #ddd solid 1px;">
							<table cellpadding="0" cellspacing="0" width="100%">

								<tr>

									<td style="padding: 5px 10px;width: 50%" valign="top">

										<table cellpadding="0" cellspacing="0" width="100%">

											<tr>

												<th style="width:170px;padding: 4px 10px;">Vehicle No.:</th>

												<td style="padding: 4px 10px;">{{ $seller_particular->vehicleparticular->registration_no ?? '' }}</td>

											</tr>

											<tr style="background: #f6f6f6;">

												<th style="width:170px;padding: 4px 10px;">Vehicle Make:</th>

												<td style="padding: 4px 10px;">{{ $seller_particular->vehicleparticular->make ?? '' }}</td>

											</tr>

											<tr>

												<th style="width:170px;padding: 4px 10px;">Vehicle Model:</th>

												<td style="padding: 4px 10px;">{{ $seller_particular->vehicleparticular->model ?? '' }}</td>

											</tr>

											<tr style="background: #f6f6f6;">

												<th style="width:170px;padding: 4px 10px;">Original Registration Date:</th>

												<td style="padding: 4px 10px;">{{ date('d-m-Y', strtotime($seller_particular->vehicleparticular->registration_date)) ?? '' }}</td>

											</tr>

											<tr>

												<th style="width:170px;padding: 4px 10px;">First Registration Date:</th>

												<td style="padding: 4px 10px;">{{ date('d-m-Y', strtotime($seller_particular->first_registration_Date)) ?? '' }}</td>

											</tr>

											<tr style="background: #f6f6f6;">

												<th style="width:170px;padding: 4px 10px;">Manufacturing Year:</th>

												<td style="padding: 4px 10px;">{{ $seller_particular->vehicleparticular->year_of_manufacturer ?? '' }}</td>

											</tr>

											<tr>

												<th style="width:170px;padding: 4px 10px;">Engine No.:</th>

												<td style="padding: 4px 10px;">{{ $seller_particular->vehicleparticular->engine_no ?? '' }}</td>

											</tr>

											<tr style="background: #f6f6f6;">

												<th style="width:170px;padding: 4px 10px;">Chassis No.:</th>

												<td style="padding: 4px 10px;">{{ $seller_particular->vehicleparticular->chassis_no ?? '' }}</td>

											</tr>

											<tr>

												<th style="padding: 4px 10px;">Transfer Count:</th>

												<td style="padding: 4px 10px;">{{ $seller_particular->vehicleparticular->no_of_transfer ?? '' }}</td>

											</tr>



										</table>

									</td>

									<td style="padding: 5px 10px;width: 50%" valign="top">

										<table cellpadding="0" cellspacing="0" width="100%">

											<tr>

												<th style="width:170px;padding: 4px 10px;">Primary Colour:</th>

												<td style="padding: 4px 10px;">{{ $seller_particular->vehicleparticular->color ?? '' }}</td>

											</tr>

											<tr style="background: #f6f6f6;">

												<th style="padding: 4px 10px;">COE Expiry Date:</th>

												<td style="padding: 4px 10px;">{{ date('d-m-Y', strtotime($seller_particular->vehicleparticular->coe_expiry_date)) ?? '' }}</td>

											</tr>

											<tr>

												<th style="padding: 4px 10px;">Road Tax Expiry Date:</th>

												<td style="padding: 4px 10px;">{{ date('d-m-Y', strtotime($seller_particular->vehicleparticular->road_tax_expiry_date)) ?? '' }}</td>

											</tr>

											@php

											if(!empty($seller_particular->vehicleparticular->engine_output)){

												$engineCapacity = number_format($seller_particular->vehicleparticular->engine_output);

											}else{

												$engineCapacity = '';

											}

											@endphp

											<tr style="background: #f6f6f6;">

												<th style="padding: 4px 10px;">Engine Capacity (CC):</th>

												<td style="padding: 4px 10px;">{{ $engineCapacity ?? '' }}</td>

											</tr>

											<tr>

												<th style="padding: 4px 10px;">Open Market Value:</th>

												<td style="padding: 4px 10px;">${{ number_format($seller_particular->vehicleparticular->open_market_value) ?? '' }}</td>

											</tr>





											<tr style="background: #f6f6f6;">

												<th style="padding: 4px 10px;">Minimum PARF Benefit:</th>

												<td style="padding: 4px 10px;">${{ number_format($seller_particular->vehicleparticular->arf_paid) ?? '' }}</td>

											</tr>





											<tr>

												<th style="padding: 4px 10px;">Vehicle Type:</th>

												<td style="padding: 4px 10px;">{{ $seller_particular->vehicleparticular->vehicle_type ?? '' }}</td>

											</tr>

											<tr style="background: #f6f6f6;">

												<th style="padding: 4px 10px;">Vehicle Scheme:</th>

												<td style="padding: 4px 10px;">{{ $seller_particular->vehicleparticular->vehicle_scheme ?? '' }}</td>

											</tr>



											<tr>

												<th style="padding: 4px 10px;">IU Number:</th>

												<td style="padding: 4px 10px;">{{ $seller_particular->vehicleparticular->iu_label_number ?? '' }}</td>

											</tr>

										</table>

									</td>

								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>

	</table>


	<table cellpadding="0" cellspacing="0" width="100%" style="border: #ddd solid 1px;font-family: Arial, 'sans-serif';font-size: 12px;">

		<tr>

			<td style="background: #f6f6f6; font-size: 18px; font-weight: bold; padding: 5px 10px;">Terms and Conditions</td>

		</tr>

	@php 

	$sellerrr = \App\SpContractTerm::where('seller_particular_id', $seller_particular->id)->first();

	$termsseller = json_decode($sellerrr->terms_and_condition);

	$buyerrr = \App\BuyerPaymentTermCondition::where('buyer_particular_id', $buyer_particular->id)->first();

	$termsbuyer = json_decode($buyerrr->terms_and_condition);

	@endphp

	@foreach($termsseller as $terms)

	<tr><td style="padding: 5px 10px;font-family: Arial, 'sans-serif';font-size: 12px;">--{{ $terms }}</td></tr>

	@endforeach

	@foreach($termsbuyer as $terms)

	<tr><td style="padding: 5px 10px;font-family: Arial, 'sans-serif';font-size: 12px;">--{{ $terms }}</td></tr>

	@endforeach

</table>

	<table cellpadding="0" cellspacing="0" width="100%" style="font-family: Arial, 'sans-serif';font-size: 14px;">

		<tr>

			<td style="height: 20px;" colspan="2">&nbsp;</td>

		</tr>

		<tr>

			<td style="font-weight: bold; padding:5px 10px;">Agreed Price</td>

			<td style="padding:5px 10px;text-align: right;">${{ number_format($buyer_particular->agreed_price) ?? '' }}</td>

		</tr>

		@php

		if(isset($buyer_particular->buyerpaymenttermcondition)){

			if(!empty($buyer_particular->buyerpaymenttermcondition->payment_details)){

				$detailss = json_decode($buyer_particular->buyerpaymenttermcondition->payment_details);

				$depostAmount = $detailss->payment_amount[0];

				$paymentDate = $detailss->payment_date[0];

				$searchForValue = ',';

				$stringValue = $depostAmount;



				if( strpos($stringValue, $searchForValue) !== false ) {

						$paymentAmount = $depostAmount;

				}else{

						$paymentAmount = number_format($depostAmount);

				}

			}else{

				$paymentDate = '';

				$depostAmount = number_format($buyer_particular->deposit_amount);

			}

			

		}else{

			$paymentDate = '';

			$depostAmount = number_format($buyer_particular->deposit_amount);

		}

		@endphp

		<tr>

			<td style="font-weight: bold; padding:5px 10px;">Deposit <div style="font-size: 12px; font-weight: normal;">(* <em>Deposit received by Autolink Holdings Pte. Ltd. on <strong>Date: {{$paymentDate}}</strong></em>)</div></td>

			<td style="padding:5px 10px;text-align: right;">${{ $depostAmount ?? '' }}</td>

		</tr>

		<tr>

			<td style="font-weight: bold; padding:5px 10px;">Balance Payment <span style="font-weight: normal;">(Before Loan Amount)</span></td>

			<td style="padding:5px 10px;text-align: right;">${{ number_format($buyer_particular->balance_payment) ?? '' }}</td>

		</tr>

		<tr>

			<td style="font-weight: bold; padding:5px 10px;">Less: <span style="font-weight: normal;">Required Loan Amount</span></td>
			@php
			if(isset($buyer_particular->buyerloandetail)){
					if(!empty($buyer_particular->buyerloandetail->loan_amount)){
							$loanAmount = number_format($buyer_particular->buyerloandetail->loan_amount);
					}else{
							$loanAmount = '';
					}
			}else{
					$loanAmount = '';
			}
			
			@endphp
			<td style="padding:5px 10px;text-align: right;">${{ $loanAmount ?? '' }}</td>

		</tr>

		<tr>

			<td style="font-weight: bold; padding:5px 10px 5px 30px;">Bank and Interest Rate:</td>
			@php
			if(isset($buyer_particular->buyerloandetail)){
					if(!empty($buyer_particular->buyerloandetail->bank)){
							$bank = $buyer_particular->buyerloandetail->bank;
					}else{
							$bank = '';
					}
			}else{
					$bank = '';
			}

			if(isset($buyer_particular->buyerloandetail)){
				if(!empty($buyer_particular->buyerloandetail->interest)){
						$interest = $buyer_particular->buyerloandetail->interest;
				}else{
						$interest = '';
				}
			}else{
					$interest = '';
			}
			
			@endphp
			<td style="padding:5px 10px;text-align: right;">{{ $bank ?? '' }} {{ $interest ?? '' }}%</td>

		</tr>

		<tr>

			<td style="font-weight: bold; padding:5px 10px;">Final Balance Payment</td>
			@php
			if(isset($buyer_particular->buyerloandetail)){
					if(!empty($buyer_particular->buyerloandetail->balance)){
							$balance = number_format($buyer_particular->buyerloandetail->balance);
					}else{
							$balance = '';
					}
			}else{
					$balance = number_format($buyer_particular->balance_payment);
			}

			
			@endphp
			<td style="padding:5px 10px;text-align: right;">${{ $balance ?? '' }}</td>

		</tr>

		<tr>

			<td style="height: 30px;" colspan="2">&nbsp;</td>

		</tr>

	</table>

	

	<table cellpadding="0" cellspacing="0" width="100%" style="border: #ddd solid 1px;font-family: Arial, 'sans-serif';font-size: 14px;page-break-after: always;">

		<tr>

			<td style="font-size: 18px; font-weight: bold;padding: 5px 10px;text-align: center;">Agreed by Seller:</td>

			<td style="border-left: #ddd solid 1px;font-size: 18px; font-weight: bold;padding: 5px 10px;text-align: center;">Agreed by Buyer:</td>

		</tr>

		<tr>

			<td style="height:80px;padding: 5px 10px;text-align: center;">&nbsp;</td>

			<td style="border-left: #ddd solid 1px;height:80px;padding: 5px 10px;text-align: center;">&nbsp;</td>

		</tr>

		<tr>

			<td style="font-size:12px;padding: 5px 10px;text-align: center;">Seller Sign Here</td>

			<td style="border-left: #ddd solid 1px;font-size:12px;padding: 5px 10px;text-align: center;">Buyer Sign Here</td>

		</tr>

	</table>

 

		<h1 style="font-family: Arial, 'sans-serif';font-size: 24px; margin: 20px 0 5px;">DIY Cars Contract Terms and Policy</h1>

		<hr>
<div style="font-family: Arial, 'sans-serif';font-size: 12px;">
<p style="font-size:10px;">1. All documentation and payment transactions will be carried out by AUTOLINK HOLDINGS PTE LTD (Case Trust Accredited). It is noted that DIY Cars Pte Ltd is a wholly-owned subsidiary of Autolink Holdings Pte Ltd.</p>



<p style="font-size:10px;">2. Any fees and levies imposed by the Land Transport Authority of Singapore (LTA) directly associated with the transfer of the vehicle stated in this agreement are to be borne by the BUYER.</p>



<p style="font-size:10px;">3. Autolink Holdings Pte Ltd will be acting as an Escrow for all financial payments and receipts i.e., Deposit for the vehicle, balance payment to the seller and any other payments related to the Sales and Purchase for the said vehicle in this Agreement.</p>



<p style="font-size:10px;">4. All payments are to be paid to Autolink Holdings Pte Ltd only, otherwise, Buyer and Seller will be responsible for any financial losses due to their own actions.</p>



<p style="font-size:10px;">5. Final payment will be made to Seller once all documentations i.e., Buyer’s loan application, Motor Vehicle insurance coverage etc. are complete and effective.</p>



<p style="font-size:10px;">6. Autolink Holdings Pte Ltd will carry out the transfer of the vehicle as LTA’s Electronic Service Agent via the Onemotoring.com.sg platform.</p>



<p style="font-size:10px;">7. Any finance settlement on behalf of Seller is chargeable with a service fee of 0.5% (before GST) of the outstanding amount to the Bank/Finance Institution. E.g., Finance settlement amount is $30000. Service fee = $30000 x 5% x 1.07 = $150 plus $10.50 = $160.50 (inclusive of GST)</p>



<p style="font-size:10px;">8. In the event Seller is to make full settlement of vehicle himself/herself, handover of the vehicle can only be carried out upon clearance of Form B1. Autolink Holdings Pte Ltd will ensure that Form B1 is cleared before making the balance payment to the Seller.</p>



<p style="font-size:10px;">9. Buyer will purchase a motor insurance policy which is valid for the purpose of the transfer of vehicle as of the date of ownership transfer. The period of insurance should be at least 1 year or until the next road tax renewal date for vehicles less than 1 year to C.O.E Expiration.</p>



<p style="font-size:10px;">10.	In the event of a breach of this Agreement by the Seller, the Buyer will be compensated with an amount equal to twice the value of the Deposit.</p>



<p style="font-size:10px;">11.	In the event of a breach of this Agreement by the Buyer, the Seller will keep the Deposit.</p>



<p style="font-size:10px;">12.	In the event of an unsuccessful loan application by Buyer within the agreed period in this Agreement, this Agreement will be void and Seller is to refund the deposit to Buyer.</p>



<p style="font-size:10px;">13.	In case of unresolved disputes relating to this Agreement, Buyer and Seller will bring forth to Small Claims Tribunal for further negotiation of claims.</p>



<p style="font-size:10px;">14.	The Seller is to hand over the keys and any other documents i.e., Owner’s Manual, Warranty Booklet etc. belonging to the Vehicle in this Agreement.</p>



<p style="font-size:10px;">15.	Autolink Holdings Pte Ltd is only acting as an Escrow agent for the Sales and Purchase of the vehicle in this Agreement and will not be liable for any claims under The Consumer Protection (Fair Trading) Act (CPFTA).</p>



<p style="font-size:10px;">16.	The Seller is to preserve the condition of the vehicle in accordance with the Agreed Terms and Conditions between Buyer and Seller stipulated in this Agreement.</p>



<p style="font-size:10px;">17.	The Buyer and Seller acknowledge that each has read and understood the terms of this Agreement and executes this Agreement with a full understanding of the Terms and Conditions in this Agreement.</p>



<p style="font-size:10px;">18.	This Agreement constitutes supersedes all prior communications, contracts or agreements between the parties with respect to the subject matter addressed in this Agreement, whether in writing or oral.</p>



<p style="font-size:10px;">19.	This Agreement shall be governed by the laws of Republic of Singapore.</p>
</div>
	<footer style="font-family: Arial, 'sans-serif';font-size: 12px; padding-top:10px;text-align: center;">© 2022 DIY Cars Pte Ltd. All rights reserved.</footer>

</body>

</html>