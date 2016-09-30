<div class="row">
    <div class="col-md-12  no-padding top-menu">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle menu-button" data-toggle="collapse" data-target=".js-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- <a class="navbar-brand" href="#">Brand</a> -->
        </div>
        <div class="collapse navbar-collapse js-navbar-collapse">
            <ul id="topbar"  class="nav navbar-nav">
            @foreach($menu as $link)
                @if($link->id === 'home')
                    <li>
                        <a href="{{ $link->link }}" >
                        <i class="{{ $link->icon }}" aria-hidden="true"></i>
                        &nbsp;&nbsp;{!! $link->title !!}
                        </a>
                    </li>
                @else
                    @if($acl->canIf($link->id) || $user->roles->contains('id', 1) )
                        @if(empty($link->childs))
                        <li>
                            <a href="{{ $link->link }}" >
                            <i class="{{ $link->icon }}" aria-hidden="true"></i>
                            &nbsp;&nbsp;{!! $link->title !!}
                            </a>
                        </li>
                        @endif
                        @if(!empty($link->childs))
                        <li class="dropdown mega-dropdown">
                            <a href="{{ $link->link }}" data-toggle="dropdown">
                                <i class="{{ $link->icon }}" aria-hidden="true"></i>
                                &nbsp;&nbsp;{!! $link->title !!}
                                <span class="caret"></span>
                            </a>
                            @if(!empty($link->childs))
                            <ul class="dropdown-menu mega-dropdown-menu">
                                @foreach($link->childs as $child)
                                @if($acl->canIf($link->id.$child->id) || $user->roles->contains('id', 1))
                                <li class="col-sm-3">
                                    <ul>
                                        <li class="dropdown-header">
                                        <a href="{{ $child->link }}">
                                            <i class="{{ $child->icon }}" aria-hidden="true"></i>
                                            &nbsp;&nbsp;{!! $child->title !!}
                                        </a>
                                        </li>
                                    </ul>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endif
                    @endif
                @endif
            @endforeach
            </ul>
        </div>
    </div>
</div>