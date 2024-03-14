
<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<style type="text/css">
			@font-face {
				font-family: 'NotoSans';
				src: url('webfonts/notosans-regular.woff2') format('woff2'),
					url('webfonts/notosans-regular.woff') format('woff');
				font-weight: 400;
				font-style: normal;
				font-display: swap;
			}
			@font-face {
				font-family: 'NotoSans';
				src: url('webfonts/notosans-bold.woff2') format('woff2'),
					url('webfonts/notosans-bold.woff') format('woff');
				font-weight: 700;
				font-style: normal;
				font-display: swap;
			}

			* { margin: 0; padding: 0; }
		</style>

    </head>

    <body>

		<div style="padding: 50px 15px;" >
			<div style="background: url('{{ url("/") }}/images/bg-certificate-2.jpg') repeat 0 0; border: #333 solid 1px; color: #000; font-family: NotoSans, Arial; font-size: 16px; line-height: 1.4; margin: 0 auto; max-width: 840px;">
				{!! $newContents !!}
			</div>
		</div>

    </body>
</html>

