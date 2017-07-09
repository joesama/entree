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

<div class="panel-group" role="tablist"> 

	@foreach($menu as $links)
	@if($links->id !== 'home')
	<div class="col-md-3">
	<div class="panel panel-default"> 
		<div class="panel-heading" role="tab" id="collapseListGroupHeading1"> 
		<h4 class="panel-title"> 
		<a href="#{!! $links->id !!}" class="" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapseListGroup1"> {{$links->title}}</a> 
		</h4> 
		</div> 
		<div class="panel-collapse collapse in" role="tabpanel" id="{!! $links->id !!}" aria-labelledby="collapseListGroupHeading1" aria-expanded="true" style="padding:5px;padding-left: 2px;padding-right: 3px"> 

            @if(count($links->childs) > 0)
            	@include('threef/entree::entree.menu.item',['links' => $links->childs,'roles' => $roles, 'main' => $links->id])
            @else
            	@include('threef/entree::entree.menu.role',['id' => $links->id,'roles' => $roles, 'main' => $links->id])
			@endif
		</div> 
	</div> 
	</div> 
	@endif
	@endforeach
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