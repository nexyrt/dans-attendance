<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Camera Access</title>
        @vite('resources/css/app.css')
    </head>

    <body>
        <label for="camera-input" class="custom-camera-button">
            <span>Take Photo</span>
        </label>
        <input type="file" id="camera-input" accept="image/*" capture="camera" style="display: none;" />
    </body>

</html>
