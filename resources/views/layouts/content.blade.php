@extends('entree::layouts.page')
@push('threef.style')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<style type="text/css">
</style>
@stack('content.style')
@stop
@section('page')
<div class="container-fluid">
	@include('entree::layouts.components.topbar')
	<div class="row" style="padding-top:50px">
		<div class="col-md-12">
			@include('entree::layouts.components.content-header')
			@include('entree::layouts.components.message')
			@yield('content')
		</div>
	</div>
</div>
@endsection
@push('threef.footer')
<script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript">
</script>
@stack('content.script')
@stop