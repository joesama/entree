<!DOCTYPE html>
<html lang="en">
    <head>
        @include('threef/entree::layouts.components._header')
        @stack('threef.style')
        <link rel="shortcut icon" type="image/x-icon" href="/fav.ico">
        <title>{{ memorize('site.name', '3FRSB - PSS') }}</title>
    </head>
    <body >
        @if(Auth::check())
            @include('threef/entree::layouts.components.topbar')
        @endif
        <section id="content">
             @yield('body')
        </section>
        <footer>
            @include('threef/entree::layouts.components._footer')
            @include('footer')
            @stack('threef.footer')
            <script type="text/javascript">
            $('select').select2();
            </script>
        </footer>
    </body>
</html>