@extends('entree::layouts.main')
@push('threef.style')
<style type="text/css">

</style>
@stack('content.style')
@stop
@section('body')
<div class="container-fluid">
	@yield('page')
</div>
@endsection
@push('threef.footer')
<script type="text/javascript">

</script>
@stack('content.script')
@stop