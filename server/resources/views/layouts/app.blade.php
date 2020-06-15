<!DOCTYPE html>
<html>
    <head>
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Todo">
        @hasSection('title')
            <title>@yield('title')</title>
            <meta property="og:title" content="@yield('title')">
        @endif
        @hasSection('description')
            <meta name="description" content="@yield('description')">
            <meta property="og:description" content="@yield('description')">
        @endif
        @hasSection('ogp')
            <meta property="og:image" content="@yield('ogp')">
            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:image" content="@yield('ogp')">
        @endif
        <meta charset="utf-8">
        <title>{{ config('app.name') }}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @yield('styles')
    </head>
<body>
    <!-- Header -->
    @component('components.header')@endcomponent

    @yield('content')

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>