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
                    @include('threef/entree::layouts.menu.item', ['item' => $link])
                @else
                    @if($acl->canIf($link->id) || $user->roles->contains('id', 1) )
                        @if(empty($link->childs))
                            @include('threef/entree::layouts.menu.item', ['item' => $link])
                        @else
                            @include('threef/entree::layouts.menu.child', ['item' => $link])
                        @endif
                    @endif
                @endif
            @endforeach
            </ul>
        </div>
    </div>
</div>