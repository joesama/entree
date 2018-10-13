@inject('user', 'Illuminate\Contracts\Auth\Authenticatable')
@inject('entree', 'Joesama\Entree\EntreeMenu')
<?php $menu = $entree->menu(); ?>
<?php $acl = $entree->acl(); ?>
@unless(is_null($user))
<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 no-padding top-header">
                <div class="col-md-2 pull-left">
                    &nbsp;   
                </div>
                <div class="col-md-6">
                     &nbsp;
                </div>
                <div class="col-md-4 pull-right">
                <ul id="profile" class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle text-right" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span> 
                            <strong>{{ $user->fullname }}</strong>
                            <span class="glyphicon glyphicon-chevron-down"></span><br>
                            <small class="text-center">{{ $user->roles->implode('name',' | ') }}</small>
                        </a>
                        <ul class="dropdown-menu navbar-login">
                            <li>
                                <a class=" text-center" href="{!! handles('joesama::account/info') !!}">
                                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                                <strong>{{ trans('joesama/entree::entree.user.info') }}</strong>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{!! handles('joesama::logout') !!}" class="btn btn-primary btn-block">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;
                                    {{ trans('orchestra/foundation::title.logout') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                </div>
            </div>
        </div>
        @include('joesama/entree::layouts.themes.topnav')
    </div>
</nav>
@endunless




