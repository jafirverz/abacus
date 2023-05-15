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
			<h1>Notice Of Assessment (Detailed)</h1>
			<hr>
      @if(!empty($noahistory))
      <table >
        <tr>
            <th style="width:500px;"><strong>Year of Assessment:</strong> {{ $noahistory[0]->year_of_assessment }}</th>
            <th style="width:500px;"><strong>Year of Assessment:</strong> {{ $noahistory[1]->year_of_assessment }}</th>

        </tr>

        <tr>
            <td style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;"><strong>Type:</strong> {{ $noahistory[0]->type }}</td>
            <td style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;"><strong>Type:</strong> {{ $noahistory[1]->type }}</td>

        </tr>

        <tr>
            <td style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;"><strong>Assesable Income:</strong> ${{ $noahistory[0]->amount }}</td>
            <td style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;"><strong>Assesable Income:</strong> ${{ $noahistory[1]->amount }}</td>

        </tr>

        <tr>
            <td style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;">
                <strong>Income Breakdown:</strong>
                <ul>
                    <li>Employment: ${{ number_format( $noahistory[0]->employment, 2 ) }}</li>
                    <li>Trade: ${{ $noahistory[0]->trade ?? 0 }}</li>
                    <li>Rent: ${{ $noahistory[0]->rent ?? 0 }}</li>
                    <li>Interest: ${{ $noahistory[0]->interest ?? 0 }}</li>
                </ul>
            </td>
            <td style="border-bottom: #ddd solid 1px; font-size: 14px; font-weight: bold; padding: 10px 0 5px;">
                <strong>Income Breakdown:</strong>
                <ul>
                    <li>Employment: ${{ number_format( $noahistory[1]->employment, 2 ) }}</li>
                    <li>Trade: ${{ $noahistory[1]->trade ?? 0 }}</li>
                    <li>Rent: ${{ $noahistory[1]->rent ?? 0 }}</li>
                    <li>Interest: ${{ $noahistory[1]->interest ?? 0 }}</li>
                </ul>
            </td>
        </tr>

    </table>
    @endif

		</div>
		<footer style="font-family: Arial, 'sans-serif';font-size: 12px; padding-top:10px;text-align: center;">© 2022 DIY Cars Pte Ltd. All rights reserved.</footer>
</body>

</html>