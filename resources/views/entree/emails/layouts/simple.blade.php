<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- If you delete this meta tag, Half Life 3 will never be released. -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
@include('threef/entree::entree.emails.layouts.styles.basic')
</head>
 
<body bgcolor="#FFFFFF">

<!-- HEADER -->
<table class="head-wrap  alert-{{ $level }}" bgcolor="#999999">
	<tr>
		<td></td>
		<td class="header container" >
				<div class="content-header">
				<div class="label"><h6 class="collapse">{{ $title }}</h6></div>
				@unless(is_null($logoUrl = config('app.logo')))
				<div  class="logo">
				<a href="{{ handles('app::/') }}" target="_blank">
				<img src="{{ $logoUrl }}" width="80" height="80" />
				</a>
				</div>
				@endif
				</div>
				
		</td>
		<td></td>
	</tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap">
	<tr>
		<td class="container" bgcolor="#FFFFFF">
			<div class="content">
			<table>
				<tr>
					<td>
						<h5>{{ title_case($greeting) }}</h5>
						<!-- <p class="lead">{{ title_case($title) }}</p> -->
						@foreach($introLines as $line)
	                    <p>{{ $line }}</p>
	                    @endforeach
						<!-- Callout Panel -->
						@if(isset($actionText))
						<p class="callout {{ $level }}">
							@foreach ($outroLines as $line)
	                        {{ title_case($line) }}
	                      	@endforeach	
							<br>
							<a href="{{ $actionUrl }}" target="_blank">{{ title_case($actionText) }} &raquo;</a>
						</p><!-- /Callout Panel -->	
						@else
							@foreach ($outroLines as $line)
	                        <p>{{ $line }}</p>
	                      	@endforeach	
						@endif		
						
					</td>
				</tr>
			</table>
			</div><!-- /content -->
									
		</td>
	</tr>
</table><!-- /BODY -->
@include('threef/entree::entree.emails.layouts.footer')
</body>
</html>