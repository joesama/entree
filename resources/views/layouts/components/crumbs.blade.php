<style type="text/css">
/* Breadcrumbs from http://bootsnipp.com/snippets/featured/triangle-breadcrumbs-arrows */
.btn-breadcrumb .btn:not(:last-child):after {
  content: " ";
  display: block;
  width: 0;
  height: 0;
  border-top: 17px solid transparent;
  border-bottom: 17px solid transparent;
  border-left: 10px solid white;
  position: absolute;
  top: 50%;
  margin-top: -17px;
  left: 100%;
  z-index: 3;
}
.btn-breadcrumb .btn:not(:last-child):before {
  content: " ";
  display: block;
  width: 0;
  height: 0;
  border-top: 17px solid transparent;
  border-bottom: 17px solid transparent;
  border-left: 10px solid rgb(173, 173, 173);
  position: absolute;
  top: 50%;
  margin-top: -17px;
  margin-left: 1px;
  left: 100%;
  z-index: 3;
}

.btn-breadcrumb .btn {
  padding:6px 12px 6px 24px;
}
.btn-breadcrumb .btn:first-child {
  padding:6px 6px 6px 10px;
}
.btn-breadcrumb .btn:last-child {
  padding:6px 18px 6px 24px;
}

/** Default button **/
.btn-breadcrumb .btn.btn-default:not(:last-child):after {
  border-left: 10px solid #fff;
}
.btn-breadcrumb .btn.btn-default:not(:last-child):before {
  border-left: 10px solid #ccc;
}
.btn-breadcrumb .btn.btn-default:hover:not(:last-child):after {
  border-left: 10px solid #ebebeb;
}
.btn-breadcrumb .btn.btn-default:hover:not(:last-child):before {
  border-left: 10px solid #adadad;
}

/* The responsive part */

.btn-breadcrumb > * > div {
    /* With less: .text-overflow(); */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;    
}

.btn-breadcrumb > *:nth-child(n+2) {
  display:none;
}

/* === For phones =================================== */
@media (max-width: 767px) {
    .btn-breadcrumb > *:nth-last-child(-n+2) {
        display:block;
    } 
    .btn-breadcrumb > * div {
        max-width: 60px;
    }
}

/* === For tablets ================================== */
@media (min-width: 768px) and (max-width:991px) {
    .btn-breadcrumb > *:nth-last-child(-n+4) {
        display:block;
    } 
    .btn-breadcrumb > * div {
        max-width: 100px;
    }
}

/* === For desktops ================================== */
@media (min-width: 992px) {
    .btn-breadcrumb > *:nth-last-child(-n+6) {
        display:block;
    } 
    .btn-breadcrumb > * div {
        max-width: 170px;
    }
}	
</style>

 <div id="bc1" class="btn-group btn-breadcrumb">
    <a href="#" class="btn btn-default"><i class="fa fa-home"></i></a>
    <div class="btn btn-default">...</div>
    <a href="#" class="btn btn-default"><div>label 1</div></a>
    <a href="#" class="btn btn-default"><div>label 2. A very very long one to truncate</div></a>
    <a href="#" class="btn btn-default"><div>label 3</div></a>
    <a href="#" class="btn btn-default"><div>label 4</div></a>
    <a href="#" class="btn btn-default"><div>label 5</div></a>
    <a href="#" class="btn btn-default"><div>label 6. A very very long one to truncate</div></a>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $(window).resize(function() {

        ellipses1 = $("#bc1 :nth-child(2)")
        if ($("#bc1 a:hidden").length >0) {ellipses1.show()} else {ellipses1.hide()}
        
        ellipses2 = $("#bc2 :nth-child(2)")
        if ($("#bc2 a:hidden").length >0) {ellipses2.show()} else {ellipses2.hide()}
        
    })
    
});
</script>