<x-html :title="($title) ? $title . ' | ' . config('app.name') : config('app.name')">

  <x-slot name="head">

    <!-- favicon -->
    <!-- https://realfavicongenerator.net/ -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />
    <link rel="mask-icon" href="{{ asset('favicon/safari-pinned-tab.svg') }}" color="#ef3b2d" />
    <meta name="msapplication-TileColor" content="#ef3b2d" />
    <meta name="theme-color" content="#ffffff" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />

    @stack('styles')
    @livewireStyles

    <style>
      [x-cloak] { display: none !important; }
    </style>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
  </x-slot>

  {{ $slot }}

  @stack('modals')

  @livewireScripts
  @stack('scripts')
</x-html>
