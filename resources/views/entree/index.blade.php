
@extends('entree::layouts.main')
@push('threef.style')
<style type="text/css">
.form-signin
{
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
}
.form-signin .form-signin-heading, .form-signin .checkbox
{
    margin-bottom: 10px;
}
.form-signin .checkbox
{
    font-weight: normal;
}
.form-signin .form-control
{
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.form-signin .form-control:focus
{
    z-index: 2;
}
.form-signin input[type="text"]
{
    margin-bottom: -1px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}
.form-signin input[type="password"]
{
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.account-wall
{
    margin-top: 20px;
    padding: 40px 0px 20px 0px;
    background-color: #f7f7f7;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}
.login-title
{
    color: #555;
    font-size: 18px;
    font-weight: 400;
    display: block;
}
.profile-img
{
    width: 96px;
    height: 96px;
    margin: 0 auto 10px;
    display: block;
}
.need-help
{
    margin-top: 10px;
}
.new-account
{
    display: block;
    margin-top: 10px;
}
</style>
@endpush
@section('body')
<div class="container-fluid" style="padding-bottom:100px">
    <div class="row" style="margin-top:50px">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
                <img  class="profile-img img-responsive" src="data:image/png;base64,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"/>
            	<h1 class="text-center login-title">3F Resources Sdn Bhd<br/><small>Professional Software Services</small></h1>
                {!! Form::open(['url' => handles('threef::login'), 'action' => 'POST', 'class' => 'form-signin']) !!}
                <label class="sr-only">Email</label>
                {!! Form::input('text', 'email', old('email'), ['required' => true, 'tabindex' => 1, 'class' => 'form-control', 'autofocus', 'placeholder' => trans('entree::entree.login.username')]) !!}
				{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
				<label class="sr-only">Password</label>
                {!! Form::input('password', 'password', '', ['required' => true, 'tabindex' => 2, 'class' => 'form-control', 'placeholder' => trans('entree::entree.login.password')]) !!}
				{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                <label class="checkbox" style="padding-left:20px">
					<p class="help-box">
					{!! Form::checkbox('remember', 'yes', false, ['tabindex' => 3, 'style'=>'padding-left:15px']) !!}
					{{ trans('orchestra/foundation::title.remember-me') }}
					</p>
				</label>
                <button class="btn btn-lg btn-primary btn-block" type="submit">{{ trans('entree::entree.login.button.signin') }}</button>
                <label class="checkbox text-right">
					<p class="help-box">
						<a href="{!! handles('entree::forgot') !!}" class="pull-left" style="display:inline">
							{{ trans('entree::entree.login.forgot-password') }}
						</a>
						@if(memorize('site.registrable', TRUE))
			            	<a href="#" class="new-account"  style="display:inline">
			            		{{ trans('orchestra/foundation::title.register') }} 
			            	</a>
			            @endif
					</p>
				</label>
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