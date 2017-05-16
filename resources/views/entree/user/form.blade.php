@extends('threef/entree::layouts.content')
@push('content.style')
<style type="text/css">
/*textarea:focus .required,
input[type="text"]:focus required,
input[type="password"]:focus,
input[type="datetime"]:focus,
input[type="datetime-local"]:focus,
input[type="date"]:focus,
input[type="month"]:focus,
input[type="time"]:focus,
input[type="week"]:focus,
input[type="number"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="search"]:focus,
input[type="tel"]:focus,
input[type="color"]:focus,
.uneditable-input:focus {   
  border-color: #a94442
}*/

input:valid {
  border-color: #3c763d
}
input:invalid {
  border-color: #a94442
}
</style>
@endpush
@section('content')

<div class="row">
    <div class="col-md-10 col-xs-12">
    {!! Form::open(array('url' => url()->current(), 'method' => 'POST', 'class' => 'form-horizontal form-validation')) !!}
      <div class="form-group">
        <label for="fullname" class="col-sm-2 control-label">
          {{ trans('threef/entree::entree.user.grid.fullname') }}
        </label>
        <div class="col-sm-10">
          {!! Form::text('fullname', data_get($user,'fullname',old('fullname')) , array('required','class' => 'form-control', 'id' => 'fullname','placeholder' => trans('threef/entree::entree.user.grid.fullname') )) !!}
        </div>
      </div>
      <div class="form-group">
        <label for="email" class="col-sm-2 control-label">
        {{ trans('threef/entree::entree.user.grid.email') }}
        </label>
        <div class="col-sm-10">
          {!! Form::email('email', data_get($user,'email',old('email')) , array('required','class' => 'form-control', 'id' => 'email','placeholder' => trans('threef/entree::entree.user.grid.email') )) !!}
        </div>
      </div>
      <div class="form-group">
        <label for="email" class="col-sm-2 control-label">
        {{ trans('threef/entree::entree.user.grid.idno') }}
        </label>
        <div class="col-sm-10">
          {!! Form::text('idnumber', data_get($user,'profile.idnumber',old('idnumber')) , array('class' => 'form-control', 'id' => 'idnumber','placeholder' => trans('threef/entree::entree.user.grid.idno') )) !!}
        </div>
      </div>
      <div class="form-group">
        <label for="spec_project" class="col-sm-2 control-label">
        {{ trans('threef/entree::entree.user.grid.role') }}
        </label>
        <div class="col-sm-10">
          {!! Form::select('roles[]', $roles , data_get($user,'roles',collect([]))->pluck('id'), ['required', 'class'=>'form-control' , 'multiple' => TRUE] ) !!}
        </div>
      </div>
      @if(!data_get($user,'id',false) )
      <div class="form-group">
        <label for="password" class="col-sm-2 control-label">
        {{ trans('threef/entree::entree.login.password') }}
        </label>
        <div class="col-sm-10">
          {!! Form::text('password',NULL, array('required','class' => 'form-control', 'id' => 'password','placeholder' => trans('threef/entree::entree.login.password') )) !!}
        </div>
      </div>
      @endif
      {!! Form::hidden('photo', data_get($user,'profile.photo') ) !!}
      {!! Form::hidden('id', data_get($user,'id',false)  ) !!}
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10 text-right">
          <button type="submit" class="btn btn-primary">
          {{  trans('threef/manager::form.action.save')  }}
          </button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
    <div class="col-md-2 col-xs-12">
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
    image: "{{ data_get($user,'profile.photo',false) }}",
    newPhoto: "{{ data_get($user,'profile.photo',false) }}",
    padRight: '',
    profileID: "{{ data_get($user,'id',false) }}",
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
      data.append('photo', this.photo);

      this.$http.post("{{ handles('threef/entree::user/photo') }}", data).then((response) => {
          $( "input[name='photo']" ).val(response.body.path);
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
