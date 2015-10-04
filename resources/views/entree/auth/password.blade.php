@extends('entree::layouts.content')
@push('content.style')
<style type="text/css">

</style>
@stop
@section('content')
    <div class="row" style="">
        <div class="col-sm-18 col-md-12">
            {!! Form::open(['url' => handles('threef::password'), 'action' => 'POST', 'class' => 'form-horizontal']) !!}
			  <div class="form-group">
			    <label for="inputEmail3" class="col-sm-3 control-label">{{ trans('entree::entree.password.form.current') }}</label>
			    <div class="col-sm-9">
			    	<div class="input-group">
			    	<input type="hidden" name="id" value="{{ Auth::user()->id }}" /> 
			      	{!! Form::input('text', 'current_password', '', ['required' => true, 'tabindex' => 1, 'class' => 'form-control', 'placeholder' => trans('entree::entree.password.form.current')]) !!}
					<span class="input-group-addon text-danger" id="basic-addon1">
						<small><span class="glyphicon glyphicon-star  text-danger" aria-hidden="true"></span></small>
					</span>
					{!! $errors->first('current_password', '<p class="help-block">:message</p>') !!}
					</div>
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="inputEmail3" class="col-sm-3 control-label">{{ trans('entree::entree.password.form.new') }}</label>
			    <div class="col-sm-9">
			    	<div class="input-group">
			      	{!! Form::input('password', 'new_password', '', ['required' => true, 'tabindex' => 2, 'class' => 'form-control', 'placeholder' => trans('entree::entree.password.form.new')]) !!}
					<span class="input-group-addon" id="basic-addon1">
						<small><span class="glyphicon glyphicon-star  text-danger" aria-hidden="true"></span></small>
					</span>
					{!! $errors->first('new_password', '<p class="help-block">:message</p>') !!}
					</div>
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="inputEmail3" class="col-sm-3 control-label">{{ trans('entree::entree.password.form.confirm') }}</label>
			    <div class="col-sm-9">
			    	<div class="input-group">
			      	{!! Form::input('password', 'confirm_password', '', ['required' => true, 'tabindex' => 3, 'class' => 'form-control', 'placeholder' => trans('entree::entree.password.form.confirm')]) !!}
					<span class="input-group-addon text-danger" id="basic-addon1">
						<small><span class="glyphicon glyphicon-star  text-danger" aria-hidden="true"></span></small>
					</span>
					{!! $errors->first('confirm_password', '<p class="help-block">:message</p>') !!}
					</div>
			    </div>
			  </div>
			  <button class="btn btn-sm btn-primary pull-right" type="submit">{{ trans('entree::entree.button.update') }}</button>
            {!! Form::close() !!}
        </div>
    </div>

@endsection
@push('content.script')
<script type="text/javascript">

</script>
@stop