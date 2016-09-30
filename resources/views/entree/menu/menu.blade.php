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
			@forelse($menu as $links)
			@if($links->id !== 'home')
			<div class="col-md-2 lpad-2">
				<div class="panel panel-primary" >
					<div class="panel-heading" role="tab" id="heading{{$links->id}}">
				      <h4 class="panel-title">
				        <a role="button" data-toggle="collapse" data-parent="#menu-access" href="#collapse{{$links->id}}" aria-expanded="true" aria-controls="collapse{{$links->id}}">
				          {{$links->title}}
				        </a>
				      </h4>
				      <span class="pull-right clickable collapsed"><i class="fa fa-chevron-down"></i></span>
				    </div>
				    <div id="collapse{{$links->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$links->id}}">
					    <div class="panel-body no-padding">
							<ul class="list-group">
		                    @foreach($roles as $id => $role)
		                    <?php $action = data_get($actionRoles,$links->id,null) ?>
		                    @if(!is_null($action))
							<?php $action = $action->filter(function ($value, $key) use($id) {
							    return $value == $id;
							})->count() ; ?>
							@endif
		                        <li class="list-group-item">
		                         {{ Form::checkbox(strtolower("{$links->id}_{$role}"), 'yes', $action , [
						            'id' => "{$links->id}_{$role}",
						          ]) }}
						          <label for="{$links->id}_{$role}" class="three columns checkboxes">
						            {{ $role }}
						            &nbsp;&nbsp;&nbsp;
						          </label>
		                        </li>
		                    @endforeach
		                    </ul>
					    </div>
				    </div>
			    </div>
		    </div>
		    	@forelse($links->childs as $link)
		    	<div class="col-md-2 lpad-2">
					<div class="panel panel-primary">
						<div class="panel-heading" role="tab" id="heading{{$links->id}}">
					      <h4 class="panel-title">
					        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$links->id.$link->id}}" aria-expanded="true" aria-controls="collapse{{$links->id.$link->id}}">
					          {{$link->title}}
					        </a>
					      </h4>
					      <span class="pull-right clickable collapsed"><i class="fa fa-chevron-down"></i></span>
					    </div>
					    <div id="collapse{{$links->id.$link->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$links->id.$link->id}}">
					      	<div class="panel-body no-padding">
						      	<ul class="list-group">	
						            @foreach($roles as $id => $role)
				                    <?php $action = data_get($actionRoles,$links->id.$link->id,null) ?>
				                    @if(!is_null($action))
									<?php $action = $action->filter(function ($value, $key) use($id) {
									    return $value == $id;
									})->count() ; ?>
									@endif
				                        <li class="list-group-item">
				                         {{ Form::checkbox(strtolower("{$links->id}{$link->id}_{$role}"), 'yes', $action, [
								            'id' => "{$links->id}{$link->id}_{$role}",
								          ]) }}
								          <label for="{$links->id}{$link->id}_{$role}" class="three columns checkboxes">
								            {{ $role }}
								            &nbsp;&nbsp;&nbsp;
								          </label>
				                        </li>
				                    @endforeach
		                    	</ul>
						    </div>
						</div>
					</div>
				</div>
				@empty

				@endforelse
			@endif
			@empty

			@endforelse
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