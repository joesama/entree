@extends('joesama/entree::layouts.content')

@push('pages.style')
<!--Switchery [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/plugins/switchery/switchery.min.css') }}" rel="stylesheet">


<!--Bootstrap Select [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet">


<!--Bootstrap Tags Input [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.css') }}" rel="stylesheet">


<!--Chosen [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/plugins/chosen/chosen.min.css') }}" rel="stylesheet">


<!--noUiSlider [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/plugins/noUiSlider/nouislider.min.css') }}" rel="stylesheet">


<!--Select2 [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/plugins/select2/css/select2.min.css') }}" rel="stylesheet">


<!--Bootstrap Timepicker [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">


<!--Bootstrap Datepicker [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">

<!--Bootstrap Validator [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/plugins/bootstrap-validator/bootstrapValidator.min.css') }}" rel="stylesheet">

<!--Summernote [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/plugins/summernote/summernote.min.css') }}" rel="stylesheet">

<!--Bootstrap Tags Input [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.css') }}" rel="stylesheet">

@stack('form.style')
@endpush

@section('content')
	@yield('form')
@endsection
@push('pages.script')

<!--Switchery [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/switchery/switchery.min.js') }}"></script>


<!--Bootstrap Select [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>

<!--Bootstrap Tags Input [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>

<!--Chosen [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/chosen/chosen.jquery.min.js') }}"></script>

<!--noUiSlider [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/noUiSlider/nouislider.min.js') }}"></script>

<!--Select2 [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/select2/js/select2.min.js') }}"></script>

<!--Bootstrap Timepicker [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>

<!--Bootstrap Datepicker [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<!--Bootstrap Validator [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/bootstrap-validator/bootstrapValidator.min.js') }}"></script>

<!--Summernote [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/summernote/summernote.min.js') }}"></script>

<!--Bootstrap Tags Input [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>

<!--Masked Input [ OPTIONAL ]-->
<script src="{{ asset('packages/joesama/entree/plugins/masked-input/jquery.maskedinput.min.js') }}"></script>

<script type="text/javascript">
$(document).on('nifty.ready', function() {

	$(".date-select2").select2();

})
</script>

@stack('form.script')
@endpush