@extends('joesama/entree::layouts.main')
@push('joesama.style')
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
    font-size: 14px;
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
    font-family: 'Allerta Stencil', sans-serif;
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
    <div class="row" style="margin-top:calc(10%)">
        <div class="col-sm-6 col-md-4" style="margin: 0px auto;">
            @include('joesama/entree::layouts.components.message')
            <div class="account-wall">
                <center>
                <img class="image-circle" src="{{ asset(memorize('threef.logo','packages/joesama/entree/img/profile.png')) }}" alt="logo"  style="width:128px;height:128px;" >
                </center>
            	<h1 class="text-center login-title">
                    {{ memorize('threef.' .\App::getLocale(). '.name', 'Joesama Props') }}<br/>
                    <small></small>
                </h1>
                {!! Form::open(['url' => handles('joesama/entree::login'), 'action' => 'POST', 'class' => 'form-signin']) !!}
                <label class="sr-only">Email</label>
                {!! Form::input('text', 'username', old('username'), ['required' => true, 'tabindex' => 1, 'class' => 'form-control', 'autofocus', 'placeholder' => trans('joesama/entree::entree.login.username')]) !!}
				{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
				<label class="sr-only">Password</label>
                {!! Form::input('password', 'password', '', ['required' => true, 'tabindex' => 2, 'class' => 'form-control', 'placeholder' => trans('joesama/entree::entree.login.password')]) !!}
				{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                <label class="checkbox">
					<p class="help-box">
					{!! Form::checkbox('remember', 'yes', false, ['tabindex' => 3, 'style'=>'padding-left:15px']) !!}
					{{ trans('orchestra/foundation::title.remember-me') }}
					</p>
				</label>
                <button class="btn btn-sm btn-primary btn-block" type="submit">{{ trans('joesama/entree::entree.login.button.signin') }}</button>
                <label class="checkbox text-right" style="width: 100%">
					<p class="help-box" style="margin-top: 5px;">
						<a href="{!! handles('entree::forgot') !!}" class="pull-left" style="display:inline">
							{{ trans('joesama/entree::entree.login.forgot-password') }}
						</a>
						@if(memorize('site.registrable', TRUE))
			            	<a href="#" class="new-account"  style="display:inline;">
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
@push('joesama.footer')
<script type="text/javascript">

</script>
@endpush