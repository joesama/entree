@extends('threef/entree::layouts.page')
@push('page.style')
@stack('pages.style')
@endpush
@section('page')
@inject('bread', 'Threef\Entree\EntreeCrumbler')
<?php $crumb = $bread->crumbler(); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			@include('threef/entree::layouts.components.content-header',[ 'crumb' => $crumb ])
			@include('threef/entree::layouts.components.message')
			<div class="panel panel-default">
				<div class="panel-heading">
					@if($crumb->has('path'))
				  	{{ $crumb->get('path')->title }}
				  	@else
				  	{{ get_meta('title', '') }}
				  	@endif
				</div>
				<div class="panel-body">
					@yield('content')
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('pages.script')
@include('footer')
@stack('content.script')
@stack('datagrid.jscript')
@stack('messages.jscript')
@endpush