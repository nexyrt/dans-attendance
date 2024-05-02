<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name') }}</title>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <style>
            .trix-editor {
                @apply w-full;
            }

            .trix-editor h1 {
                font-size: 1.25rem !important;
                line-height: 1.25rem !important;
                @apply leading-5 font-semibold mb-4;
            }

            .trix-editor a:not(.no-underline) {
                @apply underline;
            }

            .trix-editor a:visited {
                color: green;
            }

            .trix-editor ul {
                list-style-type: disc;
                padding-left: 1rem;
            }

            .trix-editor ol {
                list-style-type: decimal;
                padding-left: 1rem;
            }

            .trix-editor pre {
                display: inline-block;
                width: 100%;
                vertical-align: top;
                font-family: monospace;
                font-size: 1.5em;
                padding: 0.5em;
                white-space: pre;
                background-color: #eee;
                overflow-x: auto;
            }

            .trix-editor blockquote {
                border: 0 solid #ccc;
                border-left-width: 0px;
                border-left-width: 0.3em;
                margin-left: 0.3em;
                padding-left: 0.6em;
            }
        </style>

        <!-- Scripts -->
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
        @include('notify::components.notify')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>

        <div class="h-[100%] flex justify-center items-center">
            <form class="max-w-5xl" action="{{ route('activity-logs.update', $attendanceData->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Add this line to specify the PATCH method -->
                <input id="x" type="hidden" name="content" value='{{ $attendanceData->activity_log }}'>
                <trix-editor class="trix-editor" input="x"></trix-editor>
                <button type="submit">Save</button>
            </form>
        </div>

    </body>

</html>
