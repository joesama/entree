@extends('joesama/entree::layouts.main')
@push('joesama.style')

@endpush
@section('body')
    <div id="container" class="cls-container">
        
        <!-- BACKGROUND IMAGE -->
        <!--===================================================-->
        <div id="bg-overlay" class="bg-img" style="background-image: url(img/bg-img-3.jpg)"></div>
        
        
        <!-- LOGIN FORM -->
        <!--===================================================-->
        <div class="cls-content">
            <div class="cls-content-sm panel">
                <div class="panel-body">
                    <div class="mar-ver pad-btm">
                        <img class="image-circle" src="{{ asset(memorize('threef.logo','packages/joesama/entree/img/profile.png')) }}" alt="logo"  style="width:128px;height:128px;" >
                        <p>{{ memorize('threef.' .\App::getLocale(). '.name', config('app.name')) }}</p>
                    </div>
                    {!! Form::open(['url' => handles('joesama/entree::login'), 'action' => 'POST', 'class' => 'form-signin']) !!}
                        <div class="form-group">
                            {!! Form::input('text', 'username', old('username'), ['required' => true, 'tabindex' => 1, 'class' => 'form-control', 'autofocus', 'placeholder' => trans('joesama/entree::entree.login.username')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::input('password', 'password', '', ['required' => true, 'tabindex' => 2, 'class' => 'form-control', 'placeholder' => trans('joesama/entree::entree.login.password')]) !!}
                        </div>
                        <div class="checkbox pad-btm text-left">
                            {!! Form::input('checkbox', 'remember-me', '', [ 'class' => 'magic-checkbox']) !!}
                            <label for="demo-form-checkbox">{{ trans('orchestra/foundation::title.remember-me') }}</label>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Sign In</button>
                    {!! Form::close() !!}
                </div>
        
                <div class="pad-all">
                    <a href="{!! handles('entree::forgot') !!}" class="btn-link mar-rgt">
                        {{ trans('joesama/entree::entree.login.forgot-password') }}
                    </a>
                    @if(memorize('site.registrable', FALSE))
                        <a href="#" class="btn-link mar-lft"  style="display:inline;">
                            {{ trans('orchestra/foundation::title.register') }} 
                        </a>
                    @endif
        
{{--                     <div class="media pad-top bord-top">
                        <div class="pull-right">
                            <a href="#" class="pad-rgt"><i class="psi-facebook icon-lg text-primary"></i></a>
                            <a href="#" class="pad-rgt"><i class="psi-twitter icon-lg text-info"></i></a>
                            <a href="#" class="pad-rgt"><i class="psi-google-plus icon-lg text-danger"></i></a>
                        </div>
                        <div class="media-body text-left text-bold text-main">
                            Login with
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <!--===================================================-->
        
        
        
    </div>
@endsection
@push('joesama.footer')
<script type="text/javascript">

</script>
@endpush