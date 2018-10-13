@extends('joesama/entree::layouts.main')
@push('joesama.style')
<style type="text/css">

</style>
@endpush
@section('body')
<div class="container-fluid" style="padding-bottom:310px;margin-top:100px">
    
    <div class="clearfix">&nbsp;</div>
    <div class="row">
        <div class="col-md-10 col-md-push-1">
        @include('joesama/entree::layouts.components.message')
        @if($errors->has('email'))
            <div class="alert alert-danger">
                {!! $errors->first('email', ':message') !!} <button class="close" data-dismiss="alert">×</button>
            </div>
        @endif
            <div class="thumbnail center well well-small text-center" style="padding-bottom:40px">
            <a href="{{ handles('entree::login') }}" class="btn btn-md btn-primary pull-right">
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
            </a>
                <h2 class="text-center text-success">{{ trans('joesama/entree::mail.validated.title') }}</h2>
                <p  class="text-center">{{ trans('joesama/entree::mail.validated.mail') }}</p>
            </div>    
        </div>
    </div>
</div>
@endsection
@push('joesama.footer')
<script type="text/javascript">

</script>
@endpush