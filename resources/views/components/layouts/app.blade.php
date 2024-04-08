<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if ($favicon = filament()->getFavicon())
        <link rel="icon" href="{{ $favicon }}" />
    @endif

    @yield('meta')

    <title>
        {{ value(function($title, $siteName){
        if($title)
        return "{$title} - {$siteName}";
        else
        return $siteName;
        }, $title ?? null, "IKA UNIV. BRAWIJAYA") }}
    </title>

    <style>
        html{
            font-size: 14px;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:300,400,500,600,700" rel="stylesheet" />
    @filamentStyles
    @vite([
        'resources/css/app.css'
    ])
    @stack('styles')
</head>

<body>
    {{ $slot }}

    @livewire('notifications')
    @filamentScripts
    @vite('resources/js/app.js')
    @stack('scripts')
    
    <script>
        document.addEventListener('livewire:initialized', () => {

            let scriptElement = document.createElement("script");
            
            scriptElement.setAttribute("type", "text/javascript");
            document.body.appendChild(scriptElement);
        })
    </script>
</body>

</html>
