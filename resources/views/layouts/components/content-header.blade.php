<div class="page-header">
  <!-- <h1>{{ get_meta('page-header') }} <small>{{ get_meta('page-header:subtext') }}</small></h1> -->
  	@if($crumb !== null)
  	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				@if($crumb->has('main'))
			  		<li><a href="{{ $crumb->get('main')->link }}">{{ $crumb->get('main')->title }}</a></li>
			  	@endif
				@if($crumb->has('head'))
			  		<li><a href="{{ $crumb->get('head')->link }}">{{ $crumb->get('head')->title }}</a></li>
			  	@else
				  	<li class="active">{{ get_meta('title', '') }}</li>
			  	@endif
				@if($crumb->has('path'))
			  	<li class="active">{{ $crumb->get('path')->title }}</li>
			  	@endif
			</ol>
		</div>
	</div>
	@endif
</div>