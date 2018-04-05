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
		<link href="{{ asset('css/site.css') }}" rel="stylesheet">
	</head>
	<body>
		<div id="app">
			<header>
				<?php
					$menuConfig = [
						'auth' => (boolean)Auth::check(),
						'name' => Auth::check() ? Auth::user()->name : '',
						'menus' => [
							[
								'name' => "Home",
								'url' => url('/'),
								'active' => isRouteActive('site.home')
							]
						],
						'menusDropDown' => [],
						'urlLogout' => env('URL_SITE_LOGOUT'),
						'csrfToken' => csrf_token()
					];
				?>
				<site-menu :config="{{ json_encode($menuConfig) }}"></site-menu>
			</header>
			<main>
				@yield('content')
			</main>
			<footer class="page-footer">
				<div class="footer-copyright">
					<div class="container">
						© {{ date('') }} <a href="http://maiglon.com" class="gre-text text-lighten-4">Maiglon Lubacheuski</a>
					</div>
				</div>
			</footer>
		</div>
		<!-- Scripts -->
		@stack('scripts')
		<script src="{{ asset('build/site.bundle.js') }}"></script>
	</body>
</html>
