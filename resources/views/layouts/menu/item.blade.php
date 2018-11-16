<li class="nav-item">
    <a class="nav-link" href="{{ $item->link }}" >
    <i class="{{ $item->icon }}" aria-hidden="true"></i>
    &nbsp;{!! data_get($item,'title') !!}
    </a>
</li>