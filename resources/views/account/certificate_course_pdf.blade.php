<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
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
        <div style="background: url('https://abacus.verz1.com/images/bg-certificate-3.jpg') no-repeat 0 0; color: #000; font-family: NotoSans, Arial; font-size: 16px; line-height: 1.4; margin: 0 auto; max-width: 817px;">
            {!! $newContents !!}
        </div>
    </div>
</body>

</html>

