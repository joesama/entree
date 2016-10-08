<div class="col-md-2 lpad-2">
	<div class="panel panel-primary" >
		<div class="panel-heading" role="tab" id="heading{{$links->id}}">
	      <h4 class="panel-title">
	        <a role="button" data-toggle="collapse" data-parent="#menu-access" href="#collapse{{$links->id}}" aria-expanded="true" aria-controls="collapse{{$links->id}}">
	          {{$links->title}}
	        </a>
	      </h4>
	      <span class="pull-right clickable collapsed"><i class="fa fa-chevron-down"></i></span>
	    </div>
	    <div id="collapse{{$links->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$links->id}}">
		    <div class="panel-body no-padding">
				<ul class="list-group">
                @foreach($roles as $id => $role)
                <?php $action = data_get($actionRoles,$links->id,null) ?>
                @if(!is_null($action))
				<?php $action = $action->filter(function ($value, $key) use($id) {
				    return $value == $id;
				})->count() ; ?>
				@endif
                    <li class="list-group-item">
                     {{ Form::checkbox(strtolower("{$links->id}_{$role}"), 'yes', $action , [
			            'id' => "{$links->id}_{$role}",
			          ]) }}
			          <label for="{$links->id}_{$role}" class="three columns checkboxes">
			            {{ $role }}
			            &nbsp;&nbsp;&nbsp;
			          </label>
                    </li>
                @endforeach
                </ul>
		    </div>
	    </div>
    </div>
</div>
@foreach($links->childs as $link)
	@include('threef/entree::entree.menu.item',['links' => $link,'roles' => $roles])
@endforeach