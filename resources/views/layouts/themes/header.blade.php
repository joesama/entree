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
                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <?php $userPhoto = (data_get($user,'photo',NULL) ? asset(data_get($user,'photo',NULL)) : app('orchestra.avatar')->user($user)->setSize(55)->render() ) ?>
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <span class="ic-user pull-right">
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--You can use an image instead of an icon.-->
                            <img class="img-circle img-user media-object"src="{{ $userPhoto }}" alt="{{ str_limit($user->fullname,14,'') }}"/>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            {{-- <i class="pli-male"></i> --}}
                        </span>
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <!--You can also display a user name in the navbar.-->
                        <div class="username hidden-xs">{{ ucwords(strtolower($user->fullname)) }}</div>
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    </a>


                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
                        <ul class="head-list">
                            <li>
                                <a href="{!! handles('joesama/entree::account/info') !!}"><i class="pli-male icon-lg icon-fw"></i> 
                                {{ trans('joesama/entree::entree.user.info') }}
                                </a>
                            </li>
{{--                                     <li>
                                <a href="#"><span class="badge badge-danger pull-right">9</span><i class="pli-mail icon-lg icon-fw"></i> Messages</a>
                            </li>
                            <li>
                                <a href="#"><span class="label label-success pull-right">New</span><i class="pli-gear icon-lg icon-fw"></i> Settings</a>
                            </li>
                            <li>
                                <a href="#"><i class="pli-computer-secure icon-lg icon-fw"></i> Lock screen</a>
                            </li> --}}
                            <li>
                                <a href="{!! handles('joesama/entree::logout') !!}"><i class="pli-unlock icon-lg icon-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->
                @endunless
{{--                         <li>
                    <a href="#" class="aside-toggle">
                        <i class="pli-dot-vertical"></i>
                    </a>
                </li> --}}
            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

    </div>
</header>
<!--===================================================-->
<!--END NAVBAR-->