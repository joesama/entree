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
	.pace {
	  -webkit-pointer-events: none;
	  pointer-events: none;

	  -webkit-user-select: none;
	  -moz-user-select: none;
	  user-select: none;

	  z-index: 2000;
	  position: fixed;
	  height: 60px;
	  width: 100px;
	  margin: auto;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	}

	.pace .pace-progress {
	  z-index: 2000;
	  position: absolute;
	  height: 60px;
	  width: 100px;
	  background: transparent;

	  -webkit-transform: translate3d(0, 0, 0) !important;
	  -ms-transform: translate3d(0, 0, 0) !important;
	  transform: translate3d(0, 0, 0) !important;
	}

	.pace-running #container{
		background-color:black;
		opacity: 0.1;
	}

	.pace-running #container button{
		opacity: 0.1;
	}

	.pace .pace-progress:before {
	  content: attr(data-progress-text);
	  text-align: center;
	  color: #fff;
	  background: #294f75;
	  border-radius: 50%;
	  font-family: "Helvetica Neue", sans-serif;
	  font-size: 14px;
	  font-weight: 600;
	  line-height: 1;
	  padding: 12px 3px;
	  margin: 10px 0 0 30px;
	  display: block;
	  z-index: 999;
	  position: absolute;
	}

	.pace .pace-activity {
	  font-size: 15px;
	  line-height: 1;
	  z-index: 2000;
	  position: absolute;
	  height: 60px;
	  width: 100px;
	  background-color: transparent !important;

	  display: block;
	  -webkit-animation: pace-theme-center-atom-spin 2s linear infinite;
	  -moz-animation: pace-theme-center-atom-spin 2s linear infinite;
	  -o-animation: pace-theme-center-atom-spin 2s linear infinite;
	  animation: pace-theme-center-atom-spin 2s linear infinite;
	}

	.pace .pace-activity {
	  border-radius: 50%;
	  border: 5px solid #25adfc;
	  content: ' ';
	  display: block;
	  position: absolute;
	  top: 0;
	  left: 0;
	  height: 60px;
	  width: 100px;
	}

	.pace .pace-activity:after {
	  border-radius: 50%;
	  border: 5px solid #25adfc;
	  content: ' ';
	  display: block;
	  position: absolute;
	  top: -5px;
	  left: -5px;
	  height: 60px;
	  width: 100px;

	  -webkit-transform: rotate(60deg);
	  -moz-transform: rotate(60deg);
	  -o-transform: rotate(60deg);
	  transform: rotate(60deg);
	}

	.pace .pace-activity:before {
	  border-radius: 50%;
	  border: 5px solid #25adfc;
	  content: ' ';
	  display: block;
	  position: absolute;
	  top: -5px;
	  left: -5px;
	  height: 60px;
	  width: 100px;

	  -webkit-transform: rotate(120deg);
	  -moz-transform: rotate(120deg);
	  -o-transform: rotate(120deg);
	  transform: rotate(120deg);
	}

	@-webkit-keyframes pace-theme-center-atom-spin {
	  0%   { -webkit-transform: rotate(0deg) }
	  100% { -webkit-transform: rotate(359deg) }
	}
	@-moz-keyframes pace-theme-center-atom-spin {
	  0%   { -moz-transform: rotate(0deg) }
	  100% { -moz-transform: rotate(359deg) }
	}
	@-o-keyframes pace-theme-center-atom-spin {
	  0%   { -o-transform: rotate(0deg) }
	  100% { -o-transform: rotate(359deg) }
	}
	@keyframes pace-theme-center-atom-spin {
	  0%   { transform: rotate(0deg) }
	  100% { transform: rotate(359deg) }
	}
</style>
@stack('joesama.style')