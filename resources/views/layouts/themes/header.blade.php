<!--NAVBAR-->
<!--===================================================-->
<header id="navbar">
    <div id="navbar-container" class="boxed">

        <!--Brand logo & name-->
        <!--================================-->
        <div class="navbar-header">
            <a href="{{handles('joesama/entree::'.config('joesama/entree::entree.landing','home'))}}" class="navbar-brand">
                <img class="brand-icon" src="{{ asset(memorize('threef.logo','packages/joesama/entree/img/profile.png')) }}" alt="logo"  style="width:50px;height:50px;" >
                <div class="brand-title">
                    <span class="brand-text">{{ memorize('threef.' .\App::getLocale(). '.name', config('app.name')) }}</span>
                </div>
            </a>
        </div>
        <!--================================-->
        <!--End brand logo & name-->


        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content clearfix">
            <ul class="nav navbar-top-links">

                <!--Navigation toogle button-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="tgl-menu-btn">
                    <a class="mainnav-toggle" href="#">
                        <i class="pli-list-view icon-lg"></i>
                    </a>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Navigation toogle button-->



                <!--Search-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li>
                    <div class="custom-search-form">
{{--                         <label class="btn btn-trans" for="search-input" data-toggle="collapse" data-target="#nav-searchbox">
                            <i class="pli-magnifi-glass"></i>
                        </label> --}}
{{--                         <form>
                            <div class="search-container collapse" id="nav-searchbox">
                                <input id="search-input" type="text" class="form-control" placeholder="Type for search...">
                            </div>
                        </form> --}}
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Search-->

            </ul>
            <ul class="nav navbar-top-links">

            @unless(is_null($user))
                @if(view()->exists('joesama.entree.layouts.themes.mailing'))
                    @includeIf('joesama.entree.layouts.themes.mailing')
                @else
                    @include('joesama/entree::layouts.themes.mailing')
                @endif

                @include('joesama/entree::layouts.components.top-user')

            @endunless

            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

    </div>
</header>
<!--===================================================-->
<!--END NAVBAR-->