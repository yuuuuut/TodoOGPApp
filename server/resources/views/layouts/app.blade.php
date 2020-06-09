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
    </head>
<body>
    @guest
        isGest
    @else
        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endguest
    @yield('content')
</body>
</html>