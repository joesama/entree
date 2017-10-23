<ul class="list-group"> 
@foreach($roles as $roleId => $role)
<?php $action = data_get($actionRoles,$id,null) ?>
@if(!is_null($action))
<?php $action = $action->filter(function ($value, $key) use($roleId) {
    return $value == $roleId;
})->count() ; ?>
@endif
<li class="list-group-item">
     {{ Form::checkbox(strtolower("{$main}_{$role}"), 'yes', $action , [
        'id' => "{$id}_{$role}",
      ]) }}

      <label for="{$id}_{$role}" >
        {{ $role }}
        &nbsp;&nbsp;&nbsp;
      </label>
</li>
@endforeach
</ul> 