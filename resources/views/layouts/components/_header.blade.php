<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ memorize('threef.' .\App::getLocale(). '.abbr', config('app.name')) }}</title>
<!--Open Sans Font [ OPTIONAL ] -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<!--Bootstrap Stylesheet [ REQUIRED ]-->
<link href="{{ asset('packages/joesama/entree/css/bootstrap.min.css') }}" rel="stylesheet">


<!--Nifty Stylesheet [ REQUIRED ]-->
<link href="{{ asset('packages/joesama/entree/css/nifty.min.css') }}" rel="stylesheet">


<!--Premium Icons [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/premium/icon-sets/icons/line-icons/premium-line-icons.min.css') }}" rel="stylesheet">
<link href="{{ asset('packages/joesama/entree/premium/icon-sets/icons/solid-icons/premium-solid-icons.min.css') }}" rel="stylesheet">

<!--Page Load Progress Bar [ OPTIONAL ]-->
<link href="{{ asset('packages/joesama/entree/css/pace.min.css') }}" rel="stylesheet">

@stack('joesama.style')