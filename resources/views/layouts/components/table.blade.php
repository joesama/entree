<section class="panel panel-default">
<div class="table-responsive">
	<table{!! HTML::attributable($grid->attributes(), ['class' => 'table table-bordered table-striped table-condensed']) !!}>
		<thead>
			<tr>
				@foreach($grid->columns() as $column)
				<th{!! HTML::attributes($column->headers ?: []) !!}>
					{!! strtoupper($column->label) !!}
				</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach($grid->data() as $row)
			<tr{!! HTML::attributes(call_user_func($grid->header(), $row) ?: []) !!}>
				@foreach($grid->columns() as $column)
				<td{!! HTML::attributes(call_user_func($column->attributes, $row)) !!}>
					{!! $column->getValue($row) !!}
				</td>
				@endforeach
			</tr>
			@endforeach
			@if(! count($grid->data()) && $empty)
			<tr class="norecords">
				<td colspan="{!! count($grid->columns()) !!}">{!! $empty !!}</td>
			</tr>
			@endif
		</tbody>
	</table>
</div>
<footer class="panel-footer">
        <div class="row">
            <div class="col-sm-4 hidden-xs">&nbsp;</div>
            <div class="col-sm-4 text-right text-center-xs">                
                {!! $pagination or '' !!}
            </div>
        </div>
    </footer>
</section>
