<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ trans('threef/entree::entree.password.reset.title') }}</h2>

		<p>
			{{ trans('threef/entree::mail.reset.form') }} {{ url(handles("entree::forgot/reset/{$token}")) }}.<br/>
			{{ trans('threef/entree::mail.reset.expired', ['time' => config('auth.reminder.expire', 60) ]) }}.
		</p>
	</body>
</html>
