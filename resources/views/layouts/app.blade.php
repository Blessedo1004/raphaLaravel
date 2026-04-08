<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <link rel="icon" href="{{ asset('images/icon1.png') }}" type="image/png" sizes="16x16">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  {{-- <meta name="description" content="{{ $description  ?? ''}}"> --}}
  <title>{{ $title ?? config('app.name') }}</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
   @livewireStyles
</head>
    <body>
         <x-preloader>
         </x-preloader>   
        {{ $slot }}

    @livewireScripts
    </body>
</html>
