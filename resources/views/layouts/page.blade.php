@extends('joesama/entree::layouts.main')
@push('joesama.style')

@stack('pages.style')
@stack('vuegrid-css')
@endpush
@section('body')
    @inject('user', 'Illuminate\Contracts\Auth\Authenticatable')  
    <div id="container" class="effect aside-float aside-bright mainnav-sm">
    <!--NAVBAR-->
    <!--===================================================-->
        @include('joesama/entree::layouts.themes.header')
    <!--===================================================-->
    <!--END NAVBAR-->

    <div class="boxed">
        <!--CONTENT CONTAINER-->
        <!--===================================================-->
        @yield('page')
        <!--===================================================-->
        <!--END CONTENT CONTAINER-->
        <!--MAIN NAVIGATION-->
        <!--===================================================-->
        <nav id="mainnav-container">
            <div id="mainnav">
                @include('joesama/entree::layouts.themes.sidebar')
            </div>
        </nav>

    </div>

    @include('joesama/entree::layouts.themes.footer')
    <!-- SCROLL PAGE BUTTON -->
    <!--===================================================-->
    <button class="scroll-top btn">
        <i class="pci-chevron chevron-up"></i>
    </button>
    <!--===================================================-->
    </div>
@endsection
@push('joesama.footer')

@stack('pages.script')

@endpush