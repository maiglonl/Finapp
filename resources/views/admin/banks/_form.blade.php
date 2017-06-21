<div class="row">
	<div class="row">
		<div class="input-field col s6">
			<?php $errorClass = $errors->first('name')? ['class' => 'validade invalid'] : []; ?>
			{!! Form::text('name', null, $errorClass) !!}
			{!! Form::label('name', 'Nome', ['data-error' => $errors->first('name')]) !!}
		</div> 
	</div>
	<div class="row">
		<div class="input-field file-field col s6">
			<div class="btn">
				<span>Logo</span>
				{!! Form::file('logo') !!}
			</div>
			<div class="file-path-wrapper">
				<input type="text" class="file-path">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="input-field col s12">
			{!! Form::submit('Enviar', ['class' => 'btn waves-effect right']) !!}
		</div>
	</div>
</div>