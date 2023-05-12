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
			<h1>CPF Contribution History</h1>
			<hr>
      @if(!empty($cpfhistory))
      <table class="tb-1 mt-3">
        
        <tr>
            <th style="width:170px;padding: 3px 10px;">Month</th>
            <th style="width:170px;padding: 3px 10px;">Paid On</th>
            <th style="width:170px;padding: 3px 10px;">Amount</th>
            <th style="width:170px;padding: 3px 10px;">Employer</th>
        </tr>

        @foreach($cpfhistory as $histroy)
        <tr>
          <td style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;"><strong>{{ strtoupper( date('M Y', strtotime( $histroy->month ) ) ) }}</strong></td>
          <td style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;">{{ date('d M Y', strtotime( $histroy->paidon ) ) }}</td>
          <td style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;">${{ $histroy->amount }}</td>
          <td style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;">{{ $histroy->employer }}</td>
      </tr>
        @endforeach
    </table>
    @endif

		</div>
		<footer style="font-family: Arial, 'sans-serif';font-size: 12px; padding-top:10px;text-align: center;">© 2022 DIY Cars Pte Ltd. All rights reserved.</footer>
</body>

</html>