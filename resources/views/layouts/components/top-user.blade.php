<!--User dropdown-->
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
<!--End user dropdown-->