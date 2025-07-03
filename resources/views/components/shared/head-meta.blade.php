{{-- resources/views/components/shared/head-meta.blade.php --}}

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

{{-- Favicon --}}
<link rel="icon" href="{{ asset('images/jkb.png') }}">

{{-- Fonts --}}
<link rel="preconnect" href="https://fonts.bunny.net">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />


{{-- Styles --}}
@notifyCss
@livewireStyles
@filamentStyles
@vite(['resources/css/app.css', 'resources/js/app.js','resources/js/face-attendance.js'])

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@laravelPWA
