@extends('joesama/entree::layouts.main')
@push('joesama.style')
<style type="text/css">

body{
    height:100vh;
    font-family: 'Roboto Condensed', sans-serif;

    }
#up{
     border-bottom:0px solid transparent;
     box-shadow: 0 0 transparent;
     background:transparent;
   }
#navbarSupportedContent li {
    margin:0px 10px;
}
#navbarSupportedContent li a{
    color:rgb(13, 13, 14);
}
#navbarSupportedContent li.dropdown.profile{
    width: 250px;
}
#up h2{
   color:#00c851!important;
   font-size:1.3rem;
   cursor: pointer;
          
}
#navbarSupportedContent .dropdown-menu.show{
	display: block;
	right: 0px;
}

#navbarSupportedContent .dropdown-item,#navbarSupportedContent .nav-item a{
	font-size: 12px;
}

#navbarSupportedContent .nav-item a{
	font-size: 14px;
}


#navbarSupportedContent .nav-item .dropdown-menu.show a{
	font-size: 12px;
}

#navbarSupportedContent .dropdown-menu {
    position: absolute;
    top: 100%;
    left: calc(100% - 200px);
    z-index: 1000;
    display: none;
    float: left;
    min-width: 10rem;
    padding: .5rem 0;
    margin: .125rem 0 0;
    font-size: 1rem;
    color: rgb(13, 13, 14);
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 0px;
}


</style>
@stack('pages.style')
@stack('vuegrid-css')
@endpush
@section('body')
<div class="container-fluid">
	@yield('page')
</div>
@endsection
@push('joesama.footer')
<script type="text/javascript">
    $(window).scroll(function(){
        if( $(this).scrollTop()>50){
            
            $('.navbar').css('background','#263238');
            $('#navbarSupportedContent li a.nav-link').css('color','white');
            $('#navbarSupportedContent li a img').css('background-color','white');
            $('#up a.navbar-brand img').css('background-color','white');
            $('#navbarSupportedContent .dropdown-menu.show li a').css('color','rgb(13, 13, 14)');
            $('#navbarSupportedContent .dropdown-menu').css('margin-top','15px');
            $('#subMenuNav .dropdown-menu').css('margin-top','20px');
           
          }else{
            $('.navbar').css('background','transparent');
            $('#navbarSupportedContent li a').css('color','rgb(13, 13, 14)');
            $('#navbarSupportedContent .dropdown-menu').css('margin-top','0px');
          }
    });
</script>
@stack('pages.script')
@stack('vuegrid-js')
@endpush