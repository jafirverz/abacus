<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signature Document</title>


    <link rel="stylesheet" href="{{ asset('js/signature_pad/signature-pad.css') }}">
    <style>
        .d-none {
            display: none;
        }

    </style>
</head>

<body onselectstart="return false">
    <div id="signature-pad" class="signature-pad">
        <div class="signature-pad--body">
            <canvas></canvas>
        </div>
        <div class="signature-pad--footer">
            <div class="description">Sign above</div>

            <div class="signature-pad--actions">
                <div>
                    <button type="button" class="button clear" data-action="clear">Clear</button>
                    <button type="button" class="button d-none" data-action="change-color">Change color</button>
                    <button type="button" class="button" data-action="undo">Undo</button>

                </div>
                <div>
                    <button type="button" class="button save" data-action="save-png">Save as PNG</button>
                    <button type="button" class="button save d-none" data-action="save-jpg">Save as JPG</button>
                    <button type="button" class="button save d-none" data-action="save-svg">Save as SVG</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/signature_pad/signature_pad.umd.js') }}"></script>
    <script src="{{ asset('js/signature_pad/app.js') }}"></script>
</body>

</html>
