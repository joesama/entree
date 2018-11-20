@inject('bread', 'Joesama\Entree\EntreeCrumbler')
<?php $crumb = $bread->crumbler(); ?>

@if( data_get($crumb->get('path',FALSE),'id') !== 'home')
<div class="page-header">
  	@if(!is_null($crumb))
  	<div class="row">
		<div class="col-md-12">
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
		</div>
	</div>
	@endif
</div>
<div class="clearfix">&nbsp;</div>
@endif








