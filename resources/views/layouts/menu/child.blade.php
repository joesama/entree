<li>
    <a href="{{ $item->link }}" >
        <i class="{{ $item->icon }}" aria-hidden="true"></i>
        <span class="menu-title">{!! $item->title !!}</span>
        <i class="arrow"></i>
    </a>
    @if(!empty($item->childs))
    <ul class="collapse">
        @foreach($item->childs as $childMenu)
            @if($acl->canIf($childMenu->id) || $user->roles->contains('id', 1) )
                @if(empty($childMenu->childs))
                    @include('joesama/entree::layouts.menu.item', ['item' => $childMenu])
                @else
                    @include('joesama/entree::layouts.menu.child', ['item' => $childMenu])
                @endif
            @endif
        @endforeach
    </ul>
    @endif
</li>