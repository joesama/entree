@extends('joesama/entree::layouts.content')
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
{!! $dataTable->scripts() !!}
@endpush