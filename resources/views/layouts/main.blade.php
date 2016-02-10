<!DOCTYPE html>
<html lang="en">
    <head>
        @include('entree::layouts.components._header')
        @stack('threef.style')
        <link rel="shortcut icon" type="image/x-icon" href="/fav.ico">
        <title>{{ memorize('site.name', '3FRSB - PSS') }}</title>
    </head>
    <body >
        @include('entree::layouts.components.topbar')
        <section id="content">
             @yield('body')
        </section>
        <footer>
            @include('entree::layouts.components._footer')
            @stack('threef.footer')
        </footer>
    </body>
</html>