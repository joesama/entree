<!--Menu-->
<!--================================-->
<div id="mainnav-menu-wrap">
    <div class="nano">
        <div class="nano-content">

            <!--Profile Widget-->
            <!--================================-->
            <div id="mainnav-profile" class="mainnav-profile">
                <div class="profile-wrap text-center">
                    @unless(is_null($user))
                    <?php $userPhoto = (data_get($user,'photo',NULL) ? asset(data_get($user,'photo',NULL)) : app('orchestra.avatar')->user($user)->setSize(55)->render() ) ?>
                    <div class="pad-btm">
                        <img class="img-circle img-md"src="{{ $userPhoto }}" alt="{{ str_limit($user->fullname,14,'') }}"/>
                    </div>
                    <a href="#profile-nav" class="box-block" data-toggle="collapse" aria-expanded="false">
                        <span class="pull-right dropdown-toggle">
                        </span>
                        <p class="mnp-name">
                            {{ ucwords(strtolower($user->fullname)) }}
                        </p>
                        <span class="mnp-desc">
                            {{ ucwords(strtolower($user->email)) }}
                        </span>
                    </a>
                    @endunless
                </div>
                <div id="profile-nav" class="collapse list-group bg-trans">
                    <a href="{!! handles('joesama/entree::account/info') !!}" class="list-group-item">
                        <i class="pli-male icon-lg icon-fw"></i> 
                        {{ trans('joesama/entree::entree.user.info') }}
                    </a>
{{--                                         <a href="#" class="list-group-item">
                        <i class="pli-gear icon-lg icon-fw"></i> Settings
                    </a>
                    <a href="#" class="list-group-item">
                        <i class="pli-information icon-lg icon-fw"></i> Help
                    </a> --}}
                    <a href="{!! handles('joesama/entree::logout') !!}" class="list-group-item">
                        <i class="pli-unlock icon-lg icon-fw"></i> Logout
                    </a>
                </div>
            </div>

            @includeIf('joesama.entree.layouts.menu.shortcut')

            @include('joesama/entree::layouts.menu.menu')

        </div>
    </div>
</div>
<!--================================-->
<!--End menu-->