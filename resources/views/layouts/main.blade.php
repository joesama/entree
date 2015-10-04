<!DOCTYPE html>
<html lang="en">
    <head>
        @include('orchestra/foundation::layouts._header')
        @stack('threef.style')
        <link rel="shortcut icon" type="image/x-icon" href="/fav.ico">
        <title>3FRSB - PSS</title>
    </head>
    <body >
        @yield('body')
        <div class="row">
            <div class="col-md-12 text-center" style="position: absolute;bottom: 5px;" >  
                @include('orchestra/foundation::layouts._footer')
            </div>
            @stack('threef.footer')
        </div>
    </body>
</html>