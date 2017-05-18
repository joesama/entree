<div class="page-header">
  	@if($crumb !== null)
  	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">

				@if($crumb->has('main'))
			  		<li><a href="{{ $crumb->get('main')->link }}">{{ $crumb->get('main')->title }}</a></li>
			  	@endif
				@if($crumb->has('head'))
					@if(data_get($crumb->get('head'),'link') != '#')
			  		<li><a href="{{ data_get($crumb->get('head'),'link') }}">{{ data_get($crumb->get('head'),'title') }}</a></li>
			  		@else
			  		<li class="active">{{ data_get($crumb->get('head'),'title') }}</li>
			  		@endif
			  	@endif
				@if($crumb->has('path'))
			  	<li class="active">{{ data_get($crumb->get('path'),'title') }}</li>
			  	@endif
			</ol>
		</div>
	</div>
	@endif
</div>