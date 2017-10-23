@extends('threef/entree::layouts.content')
@push('content.style')
@endpush
@section('content')
<div class="row" id="notify" >
    <div class="col-md-12 col-xs-12 col-xl-12 col-lg-12">
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12 col-xs-12 col-xl-12 col-lg-12">
				<table class="table table-hover table-condensed">
					<tr v-if="image" v-for="img in image">
						<td>
							<img :src="img.path" class="img-rounded img-responsive"  :width="width" :height="height" />
						</td>
						<td width="50px">
							<button @click="removeUpload(img.id)" class="btn btn-block btn-sm btn-danger"> <i class="fa fa-minus" aria-hidden="true"></i> </button>
						</td>
					</tr>
					<tr>
						<td>
							<img :src="newPhoto" alt="" class="img-rounded img-responsive" :width="width" :height="height" />
						</td>
						<td width="50px">
							<label class="btn btn-xs btn-success btn-block">
				              <input class='btn btn-xs btn-success' style="display: none;" type="file" @change="onFileChange">
				              <i class="fa fa-plus" aria-hidden="true"></i>
				            </label>
				            <button v-if="photo" class="btn btn-xs btn-default  btn-block" @click="uploadPhoto">
				              <i class="fa fa-upload" aria-hidden="true"></i>
				            </button>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
		    <div class="col-md-12 col-xs-12 col-xl-12 col-lg-12">
		    {!! Form::open(array('url' => url()->current(), 'method' => 'POST', 'class' => 'form-horizontal form-validation')) !!}
		      <div class="form-group">
		        <label for="fullname" class="col-sm-2 control-label">
		          {{ trans('threef/entree::entree.notify.desc') }}<span class="text-danger">&nbsp;*</span>
		        </label>
		        <div class="col-sm-10 col-md-10 col-xs-10 col-xl-10 col-lg-10">
		          {!! Form::text('desc', data_get($data,'title',old('desc')) , array('required','class' => 'form-control', 'id' => 'abbr','placeholder' => trans('threef/entree::entree.notify.desc') )) !!}
		        </div>
		      </div>
		      <div class="form-group">
		        <label for="content" class="col-sm-2 control-label">
		          {{ trans('threef/entree::entree.notify.content') }}<span class="text-danger">&nbsp;*</span>
		        </label>
		        <div class="col-sm-10 col-md-10 col-xs-10 col-xl-10 col-lg-10">
		          {!! Form::textarea('content', data_get($data,'content',old('content')) , array('required','class' => 'form-control', 'id' => 'name','placeholder' => trans('threef/entree::entree.notify.content') )) !!}
		        </div>
		      </div>
		      <div class="clearfix">&nbsp;</div>
		      <div class="form-group pull-right">
		        <div class="col-md-12 col-xs-12 col-xl-12 col-lg-12">
		          <button type="submit" class="btn btn-primary">
		          {{  trans('threef/entree::entree.button.save')  }}
		          </button>
		        </div>
		      </div>
		      {!! Form::close() !!}
		    </div>
		</div>
	</div>
</div>
@endsection
@push('content.script')
<script type="text/javascript">

Vue.config.debug = true;
Vue.config.devtools = true;

var resources = new Vue({
  el: '#notify',
  data: {
  	id: "{{ request()->segment(3,false) }}",
    image: window.upload,
    newPhoto: "http://placehold.it/200x50",
    padRight: '',
    photo:false,
    width: '100%',
    height: '200',
    uploadImage:false,
  },
  methods: {
    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length)
        return;
      this.createImage(files[0]);
    },
    createImage(file) {

      var image = new Image();
      var reader = new FileReader();
      var vm = this;

      reader.onload = (e) => {
        vm.newPhoto = e.target.result;
      };

      vm.photo = file;
      // vm.newPhoto = false;
      vm.padRight = 0;
      reader.readAsDataURL(file);

    },
    uploadPhoto: function (e){
      var data = new FormData();

      data.append('_token', "{{ csrf_token() }}");
      data.append('photo', this.photo);

      this.$http.post("{{ handles('threef/entree::notify/upload/' . request()->segment(3)) }}", data).then((response) => {
          this.image = response.body.upload;
          this.newPhoto = "http://placehold.it/200x50";
          this.photo = false;
      }, (response) => {

      });
    },
    removeUpload: function (id) {

      this.$http.get("{{ handles('threef/entree::notify/upload/' . request()->segment(3) .'/remove' ) }}" +'/' + id).then((response) => {
          this.image = response.body.upload;
      }, (response) => {

      });
    }
  }
});

</script>
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'content' );
</script>
@endpush
