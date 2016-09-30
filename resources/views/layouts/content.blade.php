@extends('threef/entree::layouts.page')
@push('page.style')
@stack('pages.style')
@endpush
@section('page')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			@include('threef/entree::layouts.components.content-header')
			@include('threef/entree::layouts.components.message')
			@yield('content')
		</div>
	</div>
</div>
@endsection
@push('pages.script')
@stack('content.script')
@endpush