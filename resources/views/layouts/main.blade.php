<!DOCTYPE html>
<html lang="en">
    <head>
        @include('joesama/entree::layouts.components._header')
        @stack('joesama.style')
        <link rel="shortcut icon" type="image/x-icon" href="/fav.ico">
        <title>{{ memorize('threef.' .\App::getLocale(). '.abbr') }}</title>
    </head>
    <body >
        @if(Auth::check())
            @include('joesama/entree::layouts.components.topbar')
        @endif
        <section class="wrapper fixed-top">
            <div class="overlays"></div><!--Mascara de imagen-->
            <div class="container h-100">
                @yield('body')
            </div>
        </section> 
        <footer>
            @include('joesama/entree::layouts.components._footer')
            @stack('joesama.footer')
        </footer>
    </body>
</html>