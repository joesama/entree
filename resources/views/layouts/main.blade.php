<!DOCTYPE html>
<html lang="en">
    <head>
        @include('joesama/entree::layouts.components._header')
        @stack('joesama.style')
        <link rel="shortcut icon" type="image/x-icon" href="/fav.ico">
        <title>{{ memorize('site.name', '3FRSB - PSS') }}</title>
    </head>
    <body >
        @if(Auth::check())
            @include('joesama/entree::layouts.components.topbar')
        @endif
        <section id="content">
             @yield('body')
        </section>
        <footer>
            @include('joesama/entree::layouts.components._footer')
            @stack('joesama.footer')
        </footer>
    </body>
</html>