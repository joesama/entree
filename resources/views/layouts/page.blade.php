@extends('joesama/entree::layouts.main')
@push('joesama.style')
<style type="text/css">

</style>
@stack('pages.style')
@stack('vuegrid-css')
@endpush
@section('body')
<div class="container-fluid">
	@yield('page')
</div>
@endsection
@push('joesama.footer')
<script type="text/javascript">

</script>
@stack('pages.script')
@stack('vuegrid-js')
@endpush