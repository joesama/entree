@extends('entree::layouts.content')
@push('content.style')
<style type="text/css">

</style>
@endpush
@section('content')
<div class="panel panel-default">
  <div class="panel-body">
	{!! $dataTable->table() !!}
  </div>
</div>

@endsection
@push('content.script')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}
@endpush