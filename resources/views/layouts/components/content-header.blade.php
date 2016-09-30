@inject('bread', 'Threef\Entree\EntreeCrumbler')
<?php $crumb = $bread->crumbler(); ?>
<div class="page-header">
  <h1>{{ get_meta('page-header') }} <small>{{ get_meta('page-header:subtext') }}</small></h1>
  <div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
			@if($crumb->has('main'))
		  		<li><a href="{{ $crumb->get('main')->link }}">{{ $crumb->get('main')->title }}</a></li>
		  	@endif
			@if($crumb->has('head'))
		  		<li><a href="{{ $crumb->get('head')->link }}">{{ $crumb->get('head')->title }}</a></li>
		  	@endif
		  	<li class="active">{{ $crumb->get('path')->title }}</li>
		</ol>
	</div>
</div>
</div>