<?php

$format = <<<MESSAGE
<div id="floating-bottom-container" class="floating-container">
  <div id="floating-bottom-right">
    <div class="alert-wrap animated jellyIn in">
      <div class="alert alert-:key" role="alert">
        <button class="close" data-dismiss="alert">
          <i class="pci-cross pci-circle"></i>
        </button>
        <div class="media">
          <strong>Well done!</strong> :message .
        </div>
      </div>
    </div>
  </div>
</div>
MESSAGE;

  $errorBags = $errors->getMessages();
  $hasError = $errors->isEmpty();


	$message = app('orchestra.messages')->retrieve();

	if ($message instanceof Orchestra\Messages\MessageBag) :
		$message->setFormat($format);
		foreach (['danger', 'info', 'success','error'] as $key) :
			if ($message->has($key)) :
				echo implode('', $message->get($key));
			endif;
		endforeach;
	endif;

?>

@push('pages.script')

<script type="text/javascript">

let errorBags = @json($errorBags);
let hasError = @json($hasError);

// create Vue app
var mesej = new Vue({
  // element to mount to
  el: '.form-validation',
  // initial data
  data: {
    errors: errorBags,
    bags: hasError,
  },
  // methods
  mounted: function () {
   	if(this.bags == false){
		this.createMessage;
	}
  },
  computed: {
    createMessage: function () {
    		
		for( x in this.errors){

		$( "#" + x ).parent().addClass( "has-error" ).append( '<span id="helpBlock2" class="help-block text-right"><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;' + this.errors[x] + '</span>' );

		}

    }
  }
});

</script>
@endpush
