@extends('threef/entree::layouts.content')
@push('content.style')

@endpush
@section('content')

<div class="row">
    <div class="col-md-10 col-xs-12">
    {!! Form::open(array('url' => url()->current(), 'method' => 'POST', 'class' => 'form-horizontal form-validation')) !!}
      <div class="form-group">
        <label for="fullname" class="col-sm-2 control-label">
          {{ trans('threef/entree::entree.base.abbr') }}<span class="text-danger">&nbsp;*</span>
        </label>
        <div class="col-sm-10">
          {!! Form::text('abbr', data_get($data,'abbr',old('abbr')) , array('required','class' => 'form-control', 'id' => 'abbr','placeholder' => trans('threef/entree::entree.base.abbr') )) !!}
        </div>
      </div>
      <div class="form-group">
        <label for="fullname" class="col-sm-2 control-label">
          {{ trans('threef/entree::entree.base.name') }}<span class="text-danger">&nbsp;*</span>
        </label>
        <div class="col-sm-10">
          {!! Form::text('name', data_get($data,'name',old('name')) , array('required','class' => 'form-control', 'id' => 'name','placeholder' => trans('threef/entree::entree.base.name') )) !!}
        </div>
      </div>
      <div class="form-group">
        <label for="fullname" class="col-sm-2 control-label">
          {{ trans('threef/entree::entree.base.summary') }}<span class="text-danger">&nbsp;*</span>
        </label>
        <div class="col-sm-10">
          {!! Form::textarea('summary', data_get($data,'summary',old('summary')) , array('required','class' => 'form-control', 'id' => 'summary','placeholder' => trans('threef/entree::entree.base.summary') )) !!}
        </div>
      </div>
      <div class="form-group">
        <label for="fullname" class="col-sm-2 control-label">
          {{ trans('threef/entree::entree.base.footer') }}<span class="text-danger">&nbsp;*</span>
        </label>
        <div class="col-sm-10">
          {!! Form::textarea('footer', data_get($data,'footer',old('footer')) , array('required','class' => 'form-control', 'id' => 'footer','placeholder' => trans('threef/entree::entree.base.footer') )) !!}
        </div>
      </div>
      {!! Form::hidden('logo', data_get($data,'logo') ) !!}
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10 text-right">
          <button type="submit" class="btn btn-primary">
          {{  trans('threef/entree::entree.button.save')  }}
          </button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
    <div class="col-md-2 col-xs-12">
      <center>
        <label for="fullname" class="control-label">
        {{ trans('threef/entree::entree.base.logo') }}
        </label>
      </center>
      <div id="photoprofile" class="row">
        <div  class="col-md-12" v-if="!image">
          <img src="http://placehold.it/200x200" alt="" class="img-rounded img-responsive" :width="width"/>
          <div class="row"  style="margin-top: 5px">
          <div class="col-md-12">
            <label class="btn btn-xs btn-primary btn-block">
              <input class='btn btn-xs btn-primary' style="display: none;" type="file" @change="onFileChange">
              <i class="fa fa-pencil" aria-hidden="true"></i>
            </label>
          </div>
          </div>
        </div>
        <div class="col-md-12" v-else>
          <img :src="image" class="img-rounded img-responsive"  :width="width" :height="height" />
          <div class="row"  style="margin-top: 5px">
          <div :class="[ !newPhoto ? 'col-md-6':'col-md-12' ]" :style="{ paddingRight: padRight }">
            <label class="btn btn-xs btn-danger btn-block">
              <input class='btn btn-xs btn-danger' style="display: none;" type="file" @change="onFileChange">
              <i class="fa fa-pencil" aria-hidden="true"></i>
            </label>
          </div>
          <div class="col-md-6" v-if="!newPhoto" style="padding-left:5px">
            <button class="btn btn-xs btn-primary  btn-block" @click="uploadPhoto">
              <i class="fa fa-upload" aria-hidden="true"></i>
            </button>
          </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@push('content.script')
<!-- <script src="{{ asset('packages/threef/manager/js/jcrop.min.js') }}"></script> -->
<!-- <script src="{{ asset('packages/threef/manager/js/vue-crop.js') }}"></script> -->
<script type="text/javascript">

Vue.config.debug = true;
Vue.config.devtools = true;

var resources = new Vue({
  el: '#photoprofile',
  data: {
    image: "{{ data_get($data,'logo',false) }}",
    newPhoto: "{{ data_get($data,'logo',false) }}",
    padRight: '',
    photo:'',
    width: '200',
    height: '200'
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
        vm.image = e.target.result;
      };

      vm.photo = file;
      vm.newPhoto = false;
      vm.padRight = '5px';
      reader.readAsDataURL(file);

    },
    uploadPhoto: function (e){
      var data = new FormData();

      data.append('_token', "{{ csrf_token() }}");
      data.append('id', this.profileID);
      data.append('logo', this.photo);

      this.$http.post("{{ handles('threef/entree::logo') }}", data).then((response) => {
          $( "input[name='logo']" ).val(response.body.path);
      }, (response) => {

      });
    },
    removeImage: function (e) {
      this.image = '';
    }
  }
});

</script>
@endpush
