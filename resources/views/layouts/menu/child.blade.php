<li class="dropdown nav-item" id="subMenuNav" >
    <a class="nav-link dropdown-toggle text-left" href="{{ $item->link }}" data-toggle="dropdown">
        <i class="{{ $item->icon }}" aria-hidden="true"></i>
        {!! $item->title !!}
        <span class="caret"></span>
    </a>
    @if(!empty($item->childs))
    <div class="dropdown-menu" aria-labelledby="navbarDropdown4MenuLink">
        @foreach($item->childs as $childMenu)
            @if($acl->canIf($childMenu->id) || $user->roles->contains('id', 1) )
                @if(empty($childMenu->childs))
                    <a class="dropdown-item" href="{{ $childMenu->link }}">
                        <i class="{{ $childMenu->icon }}" aria-hidden="true"></i>
                        {!! $childMenu->title !!}
                    </a>
                @else
                    <a class="dropdown-item disabled" style="color: rgb(13, 13, 14); font-weight: bold;" href="#" >
                        <i class="{{ $childMenu->icon }}" aria-hidden="true"></i>
                        {!! $childMenu->title !!}
                    </a>
                    @foreach($childMenu->childs as $childSubMenu)
                    <a class="dropdown-item" style="padding-left: 30px" href="{{ $childSubMenu->link }}">
                        <i class="{{ $childSubMenu->icon }}" aria-hidden="true"></i>
                        {!! $childSubMenu->title !!}
                    </a>
                    @endforeach
                @endif
            @endif
            <div class="dropdown-divider"></div>
        @endforeach
    </div>
    @endif
</li>