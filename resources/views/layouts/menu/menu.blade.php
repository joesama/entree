@inject('entree', 'Joesama\Entree\EntreeMenu')
<?php $menu = $entree->menu(); ?>
<?php $acl = $entree->acl(); ?>
<ul id="mainnav-menu" class="list-group">
@foreach($menu as $link)
    @if($link->id === 'home')
        {{-- @include('joesama/entree::layouts.menu.item', ['item' => $link]) --}}
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