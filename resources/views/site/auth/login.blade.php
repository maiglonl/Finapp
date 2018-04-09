@extends('layouts.site')

@section('content')
<div class="container">
	<div class="row">
		<div class="col s6 offset-s3 z-depth-2">
			<h3 class="center">Finapp</h3>
			<form method="POST" action="{{ env('URL_SITE_LOGIN') }}">
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
						<input id="password" type="password" class="validate {{ $messageError ? 'invalid' : $messageError }}" name="password" value="{{ old('password') }}" required>
						<label for="password" {!! $messageError !!}>Senha</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12 center">
						<div class="row">
							<button type="submit" class="btn waves-effect">Login</button>
						</div>
						<div class="row">
							<a href="{{ route('site.auth.register.create') }}" class="btn white blue-grey-text">
								Registre-se aqui
							</a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
