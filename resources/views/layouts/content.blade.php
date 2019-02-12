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
		    	@include('joesama/entree::layouts.components.message')
				@yield('content')
		    </div>
		</div>
    </div>
    <!--===================================================-->
    <!--End page content-->
</div>
@endsection
@push('pages.script')

<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
<script type="text/javascript">
$(document).on('nifty.ready', function() {

  	$( 'form' ).submit(function( event ) {

	    $( "form" ).find('panel-footer button[type="submit"]').attr('disabled',true);
	    
	    swal({
	      title: "{{ trans('joesama/entree::entree.alert.wait.title') }}",
	      text: "{{ trans('joesama/entree::entree.alert.wait.text') }}",
	      onOpen: function () {
	        swal.showLoading()
	      }
	    }).then(
	      function () {},
	    )

	});

})
</script>
	@stack('messages.jscript')
	@stack('content.script')
@endpush