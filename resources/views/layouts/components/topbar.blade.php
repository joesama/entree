@inject('user', 'Illuminate\Contracts\Auth\Authenticatable')
@inject('entree', 'Joesama\Entree\EntreeMenu')
<?php $menu = $entree->menu(); ?>
<?php $acl = $entree->acl(); ?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="up">
  <img class="rounded-circle" src="{{ asset(memorize('threef.logo','packages/joesama/entree/img/profile.png')) }}" alt="logo"  style="width:50px;height:50px;" >
  <button class="navbar-toggler" type="button"
  data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        @foreach($menu as $link)
            @if($link->id === 'home')
                @include('joesama/entree::layouts.menu.item', ['item' => $link])
            @else
                @if($acl->canIf($link->id) || $user->roles->contains('id', 1) )
                    @if(empty($link->childs))
                        @include('joesama/entree::layouts.menu.item', ['item' => $link])
                    @else
                        @include('joesama/entree::layouts.menu.child', ['item' => $link])
                    @endif
                @endif
            @endif
        @endforeach
    </ul>
    <ul class="navbar-nav ml-auto">
      @unless(is_null($user))
      <?php $userPhoto = (data_get($user,'photo',NULL) ? asset(data_get($user,'photo',NULL)) : app('orchestra.avatar')->user($user)->setSize(55)->render() ) ?>
        <li class="dropdown nav-item profile" >
            <a class="nav-link dropdown-toggle text-right" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span>{{ ucwords(strtolower($user->fullname)) }}</span>
                <img class="rounded-circle" width="30px" height="30px" src="{{ $userPhoto }}" alt="{{ str_limit($user->fullname,14,'') }}"/>
            </a>
            <div class="dropdown-menu text-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="{!! handles('joesama/entree::account/info') !!}">
                  {{ trans('joesama/entree::entree.user.info') }}&nbsp;&nbsp;
                  <i class="far fa-user-circle"></i>
                  
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{!! handles('joesama/entree::logout') !!}">
                  Logout&nbsp;&nbsp;<i class="fas fa-sign-out-alt"></i>
              </a>
            </div>
        </li>
        
        @endunless
    </ul>
  </div>
</nav>
@unless(is_null($user))

@endunless




