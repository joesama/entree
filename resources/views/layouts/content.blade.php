@extends('joesama/entree::layouts.page')

@push('pages.style')
	@stack('content.style')
@endpush

@section('page')

 <!--CONTENT CONTAINER-->
<!--===================================================-->
<div id="content-container">
	@include('joesama/entree::layouts.components.content-header')
    <!--Page content-->
    <!--===================================================-->
    <div id="page-content">
    	<div class="row">
		    <div class="col-lg-12 col-md-12">
				@yield('content')
		    </div>
		</div>
    </div>
    <!--===================================================-->
    <!--End page content-->
</div>
@endsection
@push('pages.script')
	@stack('messages.jscript')
	@stack('content.script')
@endpush