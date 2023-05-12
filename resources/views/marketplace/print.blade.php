<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DIY Cars</title>
	<style>
		@font-face {
			font-family: 'Poppins';
			src: url('fonts/poppins-regular-webfont.eot');
			src: url('fonts/poppins-regular-webfont.eot?#iefix') format('embedded-opentype'),
				 url('fonts/poppins-regular-webfont.woff2') format('woff2'),
				 url('fonts/poppins-regular-webfont.woff') format('woff'),
				 url('fonts/poppins-regular-webfont.ttf') format('truetype'),
				 url('fonts/poppins-regular-webfont.svg#Poppins') format('svg');
			font-weight: 400;
			font-style: normal;

		}
		@font-face {
			font-family: 'Poppins';
			src: url('fonts/poppins-bold-webfont.eot');
			src: url('fonts/poppins-bold-webfont.eot?#iefix') format('embedded-opentype'),
				 url('fonts/poppins-bold-webfont.woff2') format('woff2'),
				 url('fonts/poppins-bold-webfont.woff') format('woff'),
				 url('fonts/poppins-bold-webfont.ttf') format('truetype'),
				 url('fonts/poppins-bold-webfont.svg#Poppins') format('svg');
			font-weight: 700;
			font-style: normal;

		}
	</style>
</head>

<body width="100%" style="margin: 0; padding: 0; background-color: #fff;">
    <table align="center" border="0" cellspacing="0" cellpadding="0" style="font-family: 'Poppins', Arial, 'sans-serif'; font-size: 16px; line-height: 1.4; margin: auto;width: 1000px;margin: 0 auto;">
		<tbody>
			<tr>
				<td valign="top" style="padding-top: 20px;">
                    @php
                        $files = [];
                        if(isset($vehicle->detail['upload_file'])){
                            $files = json_decode($vehicle->detail['upload_file']);
                        }
                    @endphp
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tbody>
							<tr>
								<td style="padding-right: 15px;width: 400px;" valign="top">
									<table>
										<tbody>
											<tr>
												<td style="">
                                                    @if(isset($files[0]))
													<img src="{{ asset($files[0]) }}" alt="" style="width: 400px;" />
                                                    @endif
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<td style="padding-left: 15px;" valign="top">
									<h1 style="border-bottom: #eee solid 3px; color: #3A3A3A; font-size: 40px; font-weight: 700; margin: 0 0 25px; padding-bottom: 10px;">{{ $vehicle->detail['vehicle_make'].' '.$vehicle->detail['vehicle_model'] }}</h1>
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tbody>
											<tr>
												<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 10px 15px;"><strong>Price</strong></td>
												<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 10px 15px; text-align: right;"><strong>${{ number_format($vehicle->detail['price']) }}</strong></td>
											</tr>
											<tr>
												<td style="border: 1px solid #F2F2F2; padding: 10px 15px;"><strong>Depreciation</strong></td>
												<td style="border: 1px solid #F2F2F2; padding: 10px 15px; text-align: right;">@if($vehicle->detail['depreciation_price']) {{ '$'.number_format($vehicle->detail['depreciation_price']).'/year' }} @endif </td>
											</tr>
											<tr>
												<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 10px 15px;"><strong>Mileage</strong></td>
												<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 10px 15px; text-align: right;">{{ number_format($vehicle->detail['mileage']) }} km</td>
											</tr>
											<tr>
												<td style="border: 1px solid #F2F2F2; padding: 10px 15px;"><strong>Road Tax</strong></td>
                                                @php $road_tax_formula = calculateRoadTax(strtolower($vehicle->detail['propellant']), $vehicle->detail['engine_cc'], $vehicle->detail['orig_reg_date'], $vehicle->detail['price']); @endphp
												<td style="border: 1px solid #F2F2F2; padding: 10px 15px; text-align: right;">{{ '$'.number_format($road_tax_formula).'/year' }}</td>
											</tr>
											<tr>
												<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 10px 15px;"><strong>Remaining COE</strong></td>
                                                @php $remainingCoe = calculateRemainingCoe($vehicle->detail['coe_expiry_date']); @endphp
												<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 10px 15px; text-align: right;">{{ $remainingCoe }} Left</td>
											</tr>
											<tr>
											@php
                                            $cur_date1=date('Y-m-d');
                                            $dateDiff = dateDiff(date('Y-m-d', strtotime($vehicle->detail['coe_expiry_date'])), $cur_date1);
                                            $noofmonths = $dateDiff / 30;
                                            if($noofmonths > 84){
                                                $noofmonths = 84;
                                            }else{
                                                $noofmonths = $noofmonths;
                                            }
                                            $omv = $vehicle->detail['open_market_value'];
                                            if($omv > 20000){
                                                $aaa = 0.6;
                                            }else{
                                                $aaa = 0.7;
                                            }
                                            $interestRate = $lowestInt->interest / 100;
                                            @endphp
												<td style="border: 1px solid #F2F2F2; padding: 10px 15px;"><strong>Monthly Installment From</strong></td>
                                                @php $monthlyInstallment = calculateMonthlyInstallmentNew($vehicle->detail['price'], $interestRate, $noofmonths, $aaa); @endphp
												<td style="border: 1px solid #F2F2F2; padding: 10px 15px; text-align: right;">{{ '$'.number_format($monthlyInstallment) }}</td>
											</tr>
											@php
                                            $cur_date=strtotime(date('Y-m-d'));
                                            $cur_date1=date('Y-m-d');
                                            $orig_reg_date=strtotime($vehicle->detail['orig_reg_date']);
                                            $deregistarionValue = 0;
                                            $dateDiff = dateDiff(date('Y-m-d', strtotime($vehicle->detail['orig_reg_date']. ' + 3652 days')), $cur_date1);
                                            if($dateDiff >= 1 && $dateDiff < 366){
                                                $calPercent = 50;
                                                $coeRebate = 0;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 366 && $dateDiff < 731){
                                                $calPercent = 55;
                                                $coeRebate = 10;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 731 && $dateDiff < 1096){
                                                $calPercent = 60;
                                                $coeRebate = 20;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 1096 && $dateDiff < 1461){
                                                $calPercent = 65;
                                                $coeRebate = 30;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 1461 && $dateDiff < 1826){
                                                $calPercent = 70;
                                                $coeRebate = 40;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 1826 && $dateDiff < 2191){
                                                $calPercent = 75;
                                                $coeRebate = 50;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 2191 && $dateDiff < 2556){
                                                $calPercent = 75;
                                                $coeRebate = 60;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 2556 && $dateDiff < 2921){
                                                $calPercent = 75;
                                                $coeRebate = 70;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 2921 && $dateDiff < 3286){
                                                $calPercent = 75;
                                                $coeRebate = 80;
                                                $under10 = 1;
                                            }elseif($dateDiff >= 3286 && $dateDiff < 3650){
                                                $calPercent = 75;
                                                $coeRebate = 80;
                                                $under10 = 1;
                                            }else{
                                                $under10 = 2;
                                                $calPercent = 0;
                                                $coeRebate = 0;
                                                if($dateDiff <=  5478){
                                                    $cattt = 15;
                                                    $noOfDaysLefe = $dateDiff - 5478;
                                                    $deregistarionValue = $vehicle->detail['quota_premium'] / 1826 * $noOfDaysLefe;
                                                }elseif($dateDiff > 5478 && $dateDiff < 7305){
                                                    $cantt = 20;
                                                    $noOfDaysLefe = $dateDiff - 7304;
                                                    $deregistarionValue = $vehicle->detail['quota_premium'] / 3652 * $noOfDaysLefe;
                                                }elseif($dateDiff > 7305 && $dateDiff < 9131){
                                                    $cantt = 25;
                                                    $noOfDaysLefe = $dateDiff - 8809;
                                                    $deregistarionValue = $vehicle->detail['quota_premium'] / 1826 * $noOfDaysLefe;
                                                }else{
                                                    $cantt = 30;
                                                    $noOfDaysLefe = $dateDiff - 10956;
                                                    $deregistarionValue = $vehicle->detail['quota_premium'] / 3652 * $noOfDaysLefe;
                                                    
                                                }
                                            }
                                            if($under10 == 1){
                                                $actualARFPaid = $vehicle->detail['min_parf_benefit'] * 2;
                                                $prfdd = ($actualARFPaid*$calPercent)/100;

                                                if($coeRebate != 80){
                                                    $quu = $vehicle->detail['quota_premium']/3652;
                                                    $quu1 = $dateDiff * $quu;
                                                }else{
                                                    $quu1 = ($vehicle->detail['quota_premium'] * $coeRebate) / 100;
                                                }

                                                $deregistarionValue = $prfdd + $quu1;
                                                $deregistarionValue = '$'. number_format($deregistarionValue);
                                            }else{
                                                $deregistarionValue = '-';
                                            }
                                            @endphp
                                            <tr>
												<td style="border: 1px solid #F2F2F2; padding: 10px 15px;"><strong>Estimated Deregistration Value</strong></td>
                                                @php
                                                $cur_date=strtotime(date('Y-m-d'));
                                                $orig_reg_date=strtotime($vehicle->detail['orig_reg_date']);
                                                @endphp
												{{--<td style="border: 1px solid #F2F2F2; padding: 10px 15px; text-align: right;">${{ number_format((($cur_date-$orig_reg_date)/ (60 * 60 * 24))*$vehicle->detail['quota_premium']) }}</td>--}}
												<td style="border: 1px solid #F2F2F2; padding: 10px 15px; text-align: right;">{{ $deregistarionValue }}</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom: 10px; padding-top: 20px;">
					<h2 style="color: #3A3A3A; font-size: 32px; font-weight: 700; margin: 0;">Vehicle Details</h2>
				</td>
			</tr>
			<tr>
				<td style="padding-top: 0px;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tbody>
							<tr>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Vehicle Make</strong></td>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>COE Category</strong></td>
							</tr>
							<tr>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ ucwords($vehicle->detail['vehicle_make']) }}</td>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ ucwords($vehicle->detail['coe_category']) }}</td>
							</tr>
							<tr>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Year of Manufacture</strong></td>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Propellent</strong></td>
							</tr>
							<tr>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ $vehicle->detail['year_of_mfg'] }}</td>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ ucwords($vehicle->detail['propellant']) }}</td>
							</tr>
							<tr>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>First Registration Date</strong></td>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Max Unladen Weight</strong></td>
							</tr>
							<tr>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ date('j M Y',strtotime($vehicle->detail['first_reg_date'])) }}</td>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ number_format($vehicle->detail['max_unladden_weight']).' Kg' }}</td>
							</tr>
							<tr>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>COE Expiry Date</strong></td>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Road Tax Expiry Date</strong></td>
							</tr>
							<tr>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ date('j M Y',strtotime($vehicle->detail['coe_expiry_date'])) }}</td>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ date('j M Y',strtotime($vehicle->detail['road_tax_expiry_date'])) }}</td>
							</tr>
							<tr>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Vehicle Type</strong></td>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Primary Color</strong></td>
							</tr>
							<tr>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ ucwords($vehicle->detail['vehicle_type']) }}</td>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ ucwords($vehicle->detail['primary_color']) }}</td>
							</tr>
							<tr>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Vehicle CO2 Emission Rate</strong></td>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Original Registration Date</strong></td>
							</tr>
							<tr>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ $vehicle->detail['co2_emission_rate'] }}</td>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ date('j M Y',strtotime($vehicle->detail['orig_reg_date'])) }}</td>
							</tr>
							<tr>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Engine Capacity</strong></td>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Minimum PARF Benefit</strong></td>
							</tr>
							<tr>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ number_format($vehicle->detail['engine_cc']).' CC' }}</td>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ '$'.number_format($vehicle->detail['min_parf_benefit']) }}</td>
							</tr>
							<tr>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Vehicle Model</strong></td>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Quota Premium</strong></td>
							</tr>
							<tr>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ ucwords($vehicle->detail['vehicle_model']) }}</td>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ '$'.number_format($vehicle->detail['quota_premium']) }}</td>
							</tr>
							<tr>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Open Market Value</strong></td>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Power Rate</strong></td>
							</tr>
							<tr>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ '$'.number_format($vehicle->detail['open_market_value']) }}</td>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ $vehicle->detail['power_rate'] }}</td>
							</tr>
							<tr>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>No. of Transfers</strong></td>
								<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Vehicle Scheme</strong></td>
							</tr>
							<tr>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ $vehicle->detail['no_of_transfers'] }}</td>
								<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{ ucwords($vehicle->detail['vehicle_scheme']) }}</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom: 10px; padding-top: 30px;">
					<h2 style="color: #3A3A3A; font-size: 32px; font-weight: 700; margin: 0;">Features</h2>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom: 10px;">
					<table border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								@if(isset($vehicle->specification) && $vehicle->specification != 'null')
								@php 
								$specificationn = json_decode($vehicle->specification);
								@endphp
								@foreach ($specificationn as $item)
								<td style="padding-right: 10px;">
									<div style="background: #F2F2F2; padding: 9px 20px;">{{ $item }}</div>
								</td>
								@endforeach
                @endif
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom: 10px; padding-top: 30px;">
					<h2 style="color: #3A3A3A; font-size: 32px; font-weight: 700; margin: 0;">Additional Accessories</h2>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom: 10px;">
					<table border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								@if(isset($vehicle->additional_accessories) && $vehicle->additional_accessories != 'null')
								@php 
								$addiaccess = json_decode($vehicle->additional_accessories);
								@endphp
								@foreach ($addiaccess as $item)
								<td style="padding-right: 10px;">
									<div style="background: #F2F2F2; padding: 9px 20px;">{{ $item }}</div>
								</td>
								@endforeach
                @endif
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom: 10px; padding-top: 30px;">
					<h2 style="color: #3A3A3A; font-size: 32px; font-weight: 700; margin: 0;">Seller's Comment</h2>
				</td>
			</tr>
			<tr>
				<td>
                    {{ $vehicle->seller_comment }}
                </td>
			</tr>
			<tr>
				<td style="padding-bottom: 10px; padding-top: 30px;">
					<h2 style="color: #3A3A3A; font-size: 32px; font-weight: 700; margin: 0;">Financial</h2>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom: 20px;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tbody>
							<td style="padding-right: 15px;">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tbody>
										<tr>
											<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Purchase Price</strong></td>
										</tr>
										<tr>
											<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">${{ number_format($vehicle->detail['price']) }}</td>
										</tr>
										<tr>
											<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Minimum Down Payment</strong></td>
										</tr>
                                        @php
                                    $ovm = $vehicle->detail['open_market_value'];
                                    if($ovm <= 20000){
                                        $downPayment = $vehicle->detail['price'] * 0.3;
                                    }else{
                                        $downPayment = $vehicle->detail['price'] * 0.4;
                                    }
                                    @endphp
										<tr>
											<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">${{ number_format($downPayment) }}</td>
										</tr>
										<tr>
											<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Maximum Loan Amount</strong></td>
										</tr>
                                        @php
                                    $ovm = $vehicle->detail['open_market_value'];
                                    if($ovm <= 20000){
                                        $loanAmount = $vehicle->detail['price'] * 0.7;
                                    }else{
                                        $loanAmount = $vehicle->detail['price'] * 0.6;
                                    }
                                    @endphp
										<tr>
											<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">${{ number_format($loanAmount) }}</td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="padding-left: 15px;">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tbody>
										<tr>
											<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Lowest Interest Rate</strong></td>
										</tr>
										<tr>
											<td style="border: 1px solid #F2F2F2; padding: 9px 20px;"><div style="color: #E63D30;">{{$lowestInt->title}} - {{$lowestInt->interest}}%</div></td>
										</tr>
										<tr>
											<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Maximum Loan Tenor (Months)</strong></td>
										</tr>
										<tr>
										    @php
                                
                                            $dateDiff = dateDiff(date('Y-m-d', strtotime($vehicle->detail['coe_expiry_date'])), $cur_date1);
                                            $noofmonths = $dateDiff / 30;
                                            if($noofmonths > 84){
                                                $noofmonths = 84;
                                            }else{
                                                $noofmonths = $noofmonths;
                                            }
                                            @endphp
											<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">{{round($noofmonths)}}</td>
										</tr>
										<tr>
											<td style="background: #f2f2f2; border: 1px solid #F2F2F2; padding: 9px 20px;"><strong>Monthly Installment</strong></td>
										</tr>
										<tr>
											<td style="border: 1px solid #F2F2F2; padding: 9px 20px;">${{ number_format($monthlyInstallment) }}</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">

    $(document).ready(function () {
        window.print();
    });

    </script>

</body>
</html>
