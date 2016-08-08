@extends('threef/entree::layouts.content')
@push('content.style')
<style type="text/css">

</style>
@endpush
@section('content')
{!! Form::open(['url' => handles('threef/entree::menu'), 'action' => 'POST', 'class' => 'form-horizontal']) !!}
	@forelse($menu as $links)
	<div class="row">
		<div class="cole-md-12">
			<div class="form-group">
		    <label class="col-md-2 control-label">Menu</label>
		    <div class="col-md-10">
		      <p class="form-control-static">{{$links->title}}</p>
		    </div>
		  </div>
			<div class="form-group">
		    <label class="col-md-2 control-label">Roles</label>
		    <div class="col-md-6">  
		    {{ dump($action->search($links->id)) }}		
		    {!! Form::select($links->id.'[]', $roles, NULL ,array('required','multiple' => 'multiple','class' => 'col-md-5 form-control pull-right')) !!}
		    </div>
		  </div>

		</div>
	</div>
	@forelse($links->childs as $link)
	<div class="row">
		<div class="cole-md-12">
			<div class="form-group">
		    <label class="col-md-2 control-label">Sub Menu</label>
		    <div class="col-md-10">
		      <p class="form-control-static">{{$link->title}}</p>
		    </div>
		  </div>
			<div class="form-group">
		    <label class="col-md-2 control-label">Roles</label>
		    <div class="col-md-6">  		
		    {!! Form::select($links->id.'+'.$link->id.'[]', $roles, NULL ,array('required','multiple' => 'multiple','class' => 'col-md-5 form-control pull-right')) !!}
		    </div>
		  </div>

		</div>
	</div>
	@empty

	@endforelse
	<hr>
	@empty

	@endforelse
	<button class="btn btn-sm btn-primary pull-right" type="submit">{{ trans('threef/entree::entree.button.save') }}</button>
{!! Form::close() !!}
@endsection
@push('content.script')
<script type="text/javascript">

</script>
@endpush