@extends('threef/entree::layouts.content')
@push('content.style')
<style type="text/css">

</style>
@endpush
@section('content')
<div class="panel panel-default">
  <div class="panel-body">
  {!! $table !!}
  </div>
</div>

@endsection
