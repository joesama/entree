@extends('joesama/entree::layouts.page')

@push('pages.style')
<style type="text/css">
	#content-container:before{
		height:100px;
	}
	#page-content {
	    padding: 5px 5px 0;
	}
	#page-title {
		padding: 0px 10px;
	}
	#page-title .page-header {
		font-weight: 700;
		padding: 0px 0px 10px;
	}
	.breadcrumb{
		padding:0 10px 10px
	}
</style>
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