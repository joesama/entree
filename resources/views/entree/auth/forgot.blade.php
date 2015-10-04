
@extends('entree::layouts.main')
@push('threef.style')
<style type="text/css">

</style>
@stop
@section('body')
<div class="container-fluid" style="padding-bottom:310px;margin-top:100px">
    
    <div class="clearfix">&nbsp;</div>
    <div class="row">
        <div class="col-md-10 col-md-push-1">
        @include('entree::layouts.components.message')
        @if($errors->has('email'))
            <div class="alert alert-danger">
                {!! $errors->first('email', ':message') !!} <button class="close" data-dismiss="alert">×</button>
            </div>
        @endif
            <div class="thumbnail center well well-small text-center" style="padding-bottom:40px">
            <a href="{{ handles('entree::login') }}" class="btn btn-md btn-info pull-right">
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home
            </a>
                <h2 class="text-center">{{ trans('entree::entree.password.reset.title') }}</h2>
                <p  class="text-center">{{ trans('entree::entree.password.reset.desc') }}</p>
                {!! Form::open(['url' => handles('entree::forgot'), 'action' => 'POST', 'class' => 'form-inline']) !!}
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon1">
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                      </span>
                      {!! Form::input('text', 'email', old('email'), ['required' => true, 'tabindex' => 1, 'class' => 'form-control', 'autofocus', 'placeholder' => trans('entree::entree.login.emel'),'style' => 'width:400px']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit">{{ trans('entree::entree.password.reset.title') }}</button>
                </div>
              {!! Form::close() !!}
            </div>    
        </div>
    </div>
</div>
@endsection
@push('threef.footer')
<script type="text/javascript">

</script>
@stop