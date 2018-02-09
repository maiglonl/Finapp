<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Finapp') }}</title>

	<!-- Styles -->
	<link href="{{ asset('css/spa.css') }}" rel="stylesheet">
</head>
<body>
	<div id="spaApp">
		<app></app>
	</div>
	<!-- Scripts -->
	<script src="{{ asset('build/spa.bundle.js') }}"></script>
</body>
</html>
