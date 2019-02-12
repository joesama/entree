<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ memorize('threef.' .\App::getLocale(). '.abbr', config('app.name')) }}</title>
<!--Open Sans Font [ OPTIONAL ] -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">

<!--Bootstrap Stylesheet [ REQUIRED ]-->
<link href="{{ asset('packages/joesama/entree/css/bootstrap.min.css') }}" rel="stylesheet">
<!--Font Awesome Stylesheet [ REQUIRED ]-->
<link href="{{ asset('packages/joesama/entree/css/font-awesome.min.css') }}" rel="stylesheet">
<!--Nifty Stylesheet [ REQUIRED ]-->
<link href="{{ asset('packages/joesama/entree/css/nifty.min.css') }}" rel="stylesheet">


<!--Premium Icons [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/premium/icon-sets/icons/line-icons/premium-line-icons.min.css') }}" rel="stylesheet">
<link href="{{ asset('packages/joesama/entree/premium/icon-sets/icons/solid-icons/premium-solid-icons.min.css') }}" rel="stylesheet">
<link href="{{ asset('packages/joesama/entree/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

<!--Page Load Progress Bar [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/css/pace.min.css') }}" rel="stylesheet">
<link href="{{ asset('packages/joesama/entree/plugins/morris-js/morris.min.css') }}" rel="stylesheet">
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
@stack('joesama.style')