@extends('layouts.admin')

@section('content')
<div class="container">
	<div class="row">
		<div class="col s6 offset-s3 z-depth-2">
			<h3 class="center">Finapp.admin</h3>
			<form method="POST" action="{{ route('admin.login') }}">
				{{ csrf_field() }}
				<div class="row">
					<div class="input-field col s12">
						<?php $messageError = $errors->has('email') ? "data-error='{$errors->first('email')}'" : null ?>
						<input id="email" type="email" class="validate {{ $messageError ? 'invalid' : $messageError }}" name="email" value="{{ old('email') }}" required autofocus>
						<label for="email" {!! $messageError !!}>E-mail</label>
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12">
						<?php $messageError = $errors->has('password') ? "data-error='{$errors->first('password')}'" : null ?>
						<input id="password" type="password" class="validate {{ $messageError ? 'invalid' : $messageError }}" name="password" value="{{ old('password') }}" required autofocus>
						<label for="password" {!! $messageError !!}>Senha</label>
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12">
						<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
						<label for="remember">Lembrar-me</label>
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12">
						<button type="submit" class="btn waves-effect">Login</button>
						<a class="btn-flat waves-effect" href="{{ route('admin.password.reset') }}">Recuperar senha</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
