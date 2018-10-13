@extends('joesama/entree::layouts.content')
@push('content.style')
<style type="text/css">

</style>
@endpush
@section('content')
<div class="panel panel-default">
  <div class="panel-body">
	@include('orchestra/foundation::users._search')
	{!! $table !!}
  </div>
</div>

@endsection
@push('content.script')
<script type="text/javascript">

</script>
@endpush