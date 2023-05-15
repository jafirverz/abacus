<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>1Auto</title>
	<style>
		.page-break {
			page-break-after: always;
		}
	</style>
</head>


<body width="100%" style="margin: 0; padding: 0; background-color: #fff;">
	<table align="center" cellspacing="0" cellpadding="0" border="0"
		style="width:80%;font-family: 'Opensans', Arial, sans-serif; font-size:16px;margin: 30px auto;">
		<?php $quote=getQuotation($insurance->quotation_id);?>
		<tbody>
			<tr>

				<td style="padding: 5px 0 20px;">
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