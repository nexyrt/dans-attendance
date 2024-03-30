<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name') }}</title>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        {{-- CKEditor --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>

        {{-- Quill Editor --}}
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />
        <style>
            .ql-toolbar.ql-snow {
                background-color: #F3F4F6; 
            }
        </style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>

        <form class="max-w-[940px] mx-auto mt-10" method="POST"
            action="{{ route('activity-logs.patch', $attendanceData[0]['employee_id']) }}">
            @csrf
            @method('PATCH')
            <textarea id="description" name="content" class="hidden"></textarea>
            <div id="content">{!! $attendanceData[0]['activity_log'] !!}</div>
            <button type="submit">Save Changes</button>





            {{-- CKEditor --}}
            {{-- <textarea name="content" id="editor" class="rounded-lg">{{$attendanceData[0]['activity_log']}}</textarea>
            <button type="submit">Submit</button> --}}
        </form>






        {{-- Quill Editors --}}
        <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
        <script>
            const quill = new Quill('#content', {
                theme: 'snow'
            });
            quill.on('text-change', function() {
                document.getElementById("description").value = quill.root.innerHTML;
            });
        </script>
        {{-- CKEditor --}}
        {{-- <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
        </script> --}}
    </body>

</html>
