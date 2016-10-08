@extends('threef/entree::layouts.content')
@push('pages.style')
<style type="text/css">

</style>
@endpush
@section('content')
{!! Form::open(['url' => handles('threef/entree::menu'), 'action' => 'POST', 'class' => 'form-horizontal']) !!}
<div class="container-fluid">
<div class="row">
	<div class="col-md-12">
		<div class="panel-group" id="menu-access" role="tablist" aria-multiselectable="true">
			<div class="row">
			@foreach($menu as $links)
				@if($links->id !== 'home')
				@include('threef/entree::entree.menu.item',['links' => $links,'roles' => $roles])
				@endif
			@endforeach
			</div>
		</div>
	</div>
</div>
<div class="clearfix">&nbsp;</div>
<hr>
<div class="row">
	<div class="col-md-12">
		<button class="btn btn-sm btn-primary pull-right" type="submit">{{ trans('threef/entree::entree.button.save') }}</button>
	</div>
</div>
</div>
{!! Form::close() !!}



@endsection
@push('pages.script')
<script type="text/javascript">
$(document).on('click', '.panel-heading span.clickable', function(e){
    var $this = $(this);
    var $parent = $this.parents('.panel').find('.panel-collapse.collapse');
    $parent.collapse('toggle');

    $parent.on('hidden.bs.collapse', function () {
		$this.find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
	})
    $parent.on('shown.bs.collapse', function () {
		$this.find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
	})

	// if(!$this.parents('.panel').find('.panel-heading h4 a').hasClass('collapsed')) {
	// 	$this.find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
	// } else {
	// 	$this.find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');

	// }
})
</script>
@endpush