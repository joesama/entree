<li class="dropdown mega-dropdown">
    <a href="{{ $item->link }}" data-toggle="dropdown">
        <i class="{{ $item->icon }}" aria-hidden="true"></i>
        {!! $item->title !!}
        <span class="caret"></span>
    </a>
    @if(!empty($item->childs))
    <ul class="dropdown-menu mega-dropdown-menu">
        @foreach($item->childs as $child)
        @if($acl->canIf($item->id.$child->id) || $user->roles->contains('id', 1))
            <li class="col-md-2">
                <ul>
                    @if(empty($child->childs))
                    <li class="dropdown-header">
                    <a href="{{ $child->link }}">
                        <i class="{{ $child->icon }}" aria-hidden="true"></i>
                        {!! $child->title !!}
                    </a>
                    </li>
                    @else
                    <li class="dropdown-submenu">
                    <a href="{{ $child->link }}" data-toggle="dropdown">
                        <i class="{{ $child->icon }}" aria-hidden="true"></i>
                        {!! $child->title !!}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu mega-dropdown-submenu">
                        @foreach($child->childs as $submenu)
                            @if($acl->canIf($item->id.$child->id.$submenu->id) || $user->roles->contains('id', 1))
                            <li>
                                <a href="{{ $submenu->link }}" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="{{ $submenu->icon }}" aria-hidden="true"></i>
                                    {!! $submenu->title !!}
                                </a>
                            </li>
                    
                            @endif
                        @endforeach
                    </ul>
                    @endif
                    </li>
                </ul>
            </li>
        @endif
        @endforeach
    </ul>
    @endif
</li>