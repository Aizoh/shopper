@props(['title' => config('app.name')])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="sh min-h-screen scroll-smooth antialiased">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="X-DNS-Prefetch-Control" content="on" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
        <meta name="base-url" content="{{ config('app.url') }}" />
        <meta name="dashboard-url" content="{{ config('app.url') . '/' . shopper()->prefix() }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        @if ($favicon = config('shopper.admin.favicon'))
            <link rel="icon" href="{{ $favicon }}" />
        @else
            <x-shopper::favicons />
        @endif

        <title>{{ $title }} || {{ __('shopper::layout.meta_title') }}</title>

        <link rel="dns-prefetch" href="{{ config('app.url') }}" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap"
            rel="stylesheet"
        />

        @stack('styles')

        @filamentStyles
        {{ \Shopper\Facades\Shopper::getThemeLink() }}

        <script
            defer
            src="{{
                route('shopper.asset', [
                    'id' => get_asset_id('shopper.js'),
                    'file' => 'shopper.js',
                ])
            }}"
        ></script>

        @include('shopper::includes._additional-styles')
    </head>
    <body {{ $attributes->twMerge(['class' => 'sh-body bg-gray-50 font-sans dark:bg-gray-950']) }}>
        {{ $slot }}

        @livewire(\Filament\Notifications\Livewire\Notifications::class)
        @livewire(\Shopper\Livewire\Components\SlideOverPanel::class)
        @livewire(\Shopper\Livewire\Components\Modal::class)

        @filamentScripts

        @include('shopper::includes._additional-scripts')
    </body>
</html>
