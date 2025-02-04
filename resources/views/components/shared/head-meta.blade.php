{{-- resources/views/components/shared/head-meta.blade.php --}}

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

{{-- Favicon --}}
<link rel="icon" href="{{ asset('images/jkb.png') }}">

{{-- Fonts --}}
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">


{{-- Styles --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
@notifyCss
@livewireStyles
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@laravelPWA
