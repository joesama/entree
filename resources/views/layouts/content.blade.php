@extends('entree::layouts.page')
@push('threef.style')

<style type="text/css">
</style>
@stack('content.style')
@stop
@section('page')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			@include('entree::layouts.components.content-header')
			@include('entree::layouts.components.message')
			@yield('content')
		</div>
	</div>
</div>
@endsection
@push('threef.footer')
<script type="text/javascript">
</script>
@stack('content.script')
@stop