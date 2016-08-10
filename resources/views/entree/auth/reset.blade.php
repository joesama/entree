@extends('threef/entree::layouts.main')
@push('threef.style')
<style type="text/css">

</style>
@endpush
@section('body')
<div class="container-fluid" style="padding-bottom:310px;margin-top:100px">
    
    <div class="clearfix">&nbsp;</div>
    <div class="row">
        <div class="col-md-10 col-md-push-1">
        @include('threef/entree::layouts.components.message')
        @if($errors->has('email'))
            <div class="alert alert-danger">
                {!! $errors->first('email', ':message') !!} <button class="close" data-dismiss="alert">×</button>
            </div>
        @endif
            <div class="thumbnail center well well-small text-center" style="padding-bottom:40px">
            <a href="{{ handles('entree::login') }}" class="btn btn-md btn-info pull-right">
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home
            </a>
                <h2 class="text-center">{{ trans('threef/entree::entree.password.reset.title') }}<small></small></h2>
               {!! Form::open(['url' => handles('threef/entree::forgot/reset/{$token}'), 'action' => 'POST', 'class' => 'form-horizontal']) !!}
                <input type="hidden" name="token" value="{!! $token !!}">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">{{ trans('threef/entree::entree.login.emel') }}</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                        {!! Form::input('text', 'email', old('email'), ['required' => true, 'tabindex' => 1, 'class' => 'form-control', 'autofocus', 'placeholder' => trans('threef/entree::entree.login.emel')]) !!}
                        <span class="input-group-addon text-danger" id="basic-addon1">
                            <small><span class="glyphicon glyphicon-star  text-danger" aria-hidden="true"></span></small>
                        </span>
                        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">{{ trans('threef/entree::entree.password.form.new') }}</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                        {!! Form::input('password', 'password', '', ['required' => true, 'tabindex' => 2, 'class' => 'form-control', 'placeholder' => trans('threef/entree::entree.password.form.new')]) !!}
                        <span class="input-group-addon" id="basic-addon1">
                            <small><span class="glyphicon glyphicon-star  text-danger" aria-hidden="true"></span></small>
                        </span>
                        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">{{ trans('threef/entree::entree.password.form.confirm') }}</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                        {!! Form::input('password', 'password_confirmation', '', ['required' => true, 'tabindex' => 3, 'class' => 'form-control', 'placeholder' => trans('threef/entree::entree.password.form.confirm')]) !!}
                        <span class="input-group-addon text-danger" id="basic-addon1">
                            <small><span class="glyphicon glyphicon-star  text-danger" aria-hidden="true"></span></small>
                        </span>
                        {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                  </div>
                  <button class="btn btn-sm btn-primary pull-right" type="submit">{{ trans('threef/entree::entree.button.reset') }}</button>
                {!! Form::close() !!}
            </div>    
        </div>
    </div>
</div>
@endsection
@push('threef.footer')
<script type="text/javascript">

</script>
@endpush