<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Styles -->
	<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
	<div id="app">
		<header>
			@if (Auth::check())
				<admin-menu :config="menus"></admin-menu>
			@endif
		</header>
		<main>
			@yield('content')
		</main>
		<footer class="page-footer">
			<div class="footer-copyright">
				<div class="container">
					© {{ date('Y') }} <a href="http://fb.com/maiglon" class="grey-text text-lighten-4">Maiglon Lubacheuski</a>
				</div>
			</div>
		</footer>
	</div>

	<!-- Scripts -->
	<script src="{{ asset('build/admin.bundle.js') }}"></script>
	@if (Auth::check())
		<script type="text/javascript">
			const app = new Vue({
				el: '#app',
				data: {
					menus: {
						'name': "{{ Auth::user()->name }}",
						'menus': [
							{'name': 'teste', 'url': '/home', 'dropdownId': 'teste'},
							{
								'name': 'Bancos', 
								'url': '{{ route('admin.banks.index') }}',
								'active': {{ isRouteActive('admin.banks.index') }}
							}
						],
						'menusDropdown': [
							{
								'id': 'teste',
								'items': [
									{'name': 'Listar contas', 'url': '/listar'},
									{
										'name': 'Bancos', 
										'url': '{{ route('admin.banks.index') }}',
										'active': {{ isRouteActive('admin.banks.index') }}
									}
								]
							}
						],
						'urlLogout': "{{ route('admin.logout') }}",
						'csrfToken': "{{ csrf_token() }}"
					}
				}
			});
		</script>
	@endif

</body>
</html>
