<!DOCTYPE html>
<html lang="en">
    <head>
        @include('joesama/entree::layouts.components._header')
        @stack('joesama.style')
        <title>{{ memorize('threef.' .\App::getLocale(). '.abbr', config('app.name')) }}</title>
    </head>
    <body >
        @if(Auth::check())
            @include('joesama/entree::layouts.components.topbar')
        @endif
        <section class="wrapper fixed-top">
            <div class="overlays"></div><!--Mascara de imagen-->
            <div class="container-fluid h-100">
                @yield('body')
            </div>
        </section> 
        <footer>
            @include('joesama/entree::layouts.components._footer')
            @stack('joesama.footer')
        </footer>
    </body>
</html>