@inject('bread', 'Joesama\Entree\EntreeCrumbler')
<?php $crumb = $bread->crumbler(); ?>
<div id="page-head">
    
    <!--Page Title-->
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div id="page-title">
        <h1 class="page-header text-overflow">
          {!! data_get($crumb->get('path'),'title',get_meta('title', '')) !!}
        </h1>
    </div>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <!--End page title-->


<!--Breadcrumb-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@if(!is_null($crumb))
<ol class="breadcrumb">
	@if($crumb->has('main'))
  		<li class="breadcrumb-item"><a href="{{ $crumb->get('main')->link }}">{{ $crumb->get('main')->title }}</a></li>
  @endif
	@if($crumb->has('head'))
		@if(data_get($crumb->get('head'),'link') != '#')
  		<li class="breadcrumb-item">
  			<a href="{{ data_get($crumb->get('head'),'link') }}">
  				{{ data_get($crumb->get('head'),'title') }}
  			</a>
  		</li>
  		@else
  		<li class="breadcrumb-item active" aria-current="page" >
  			{{ data_get($crumb->get('head'),'title') }}
  		</li>
  		@endif
  	@endif
	@if($crumb->has('path') && data_get($crumb->get('path'),'id') !== 'home')
  	<li class="breadcrumb-item active" aria-current="page">{{ data_get($crumb->get('path'),'title') }}</li>
  	@endif
</ol>
@endif
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--End breadcrumb-->


</div>








