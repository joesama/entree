@extends('threef/entree::layouts.main')
@push('threef.style')
<style type="text/css">

</style>
@stack('pages.style')
@endpush
@section('body')
<div class="container-fluid">
	@yield('page')
</div>
@endsection
@push('threef.footer')
<script type="text/javascript">

</script>
@stack('pages.script')
@endpush