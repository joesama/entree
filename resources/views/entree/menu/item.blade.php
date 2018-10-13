<div class="panel-group" role="tablist" style="margin-left: 3px; margin-top:2px;padding-right: 2px"> 
	@foreach($links as $link)
	<div class="panel panel-default"> 
		<div class="panel-heading" role="tab" id="collapseListGroupHeading1"> 
		<h4 class="panel-title"> 
		<a href="#{!! $link->id !!}" class="" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapseListGroup1"><i class="{{ $link->icon }}" aria-hidden="true"></i>&nbsp;{{$link->title}}</a> 
		</h4> 
		</div> 
		<div class="panel-collapse collapse" role="tabpanel" id="{!! $link->id !!}" aria-labelledby="collapseListGroupHeading1" aria-expanded="true"> 
            @if(count($link->childs) > 0)
            	@include('joesama/entree::entree.menu.item',['links' => $link->childs,'roles' => $roles, 'main' => $main .'_'.$link->id])
            @else
            	@include('joesama/entree::entree.menu.role',['id' => $link->id,'roles' => $roles, 'main' => $main.'_'.$link->id])
			@endif
		</div> 
	</div> 
	@endforeach
</div>