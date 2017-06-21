@extends('layouts.admin')

@section('content')
	<div class="container">
		<div class="row">
			<h4>Listagem de Bancos</h4>
			<a href="{{ route('admin.banks.create') }}" class="btn waves-effect">Novo Banco</a>
			<table class="bordered striped highlight centered responsive-table z-depth-5">
				<thead>
					<tr>
						<th>#</th>
						<th>Nome</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					@foreach($banks as $bank)
						<tr>
							<td>
								<div class="row valign-wrapper">
									<div class="col s12">{{ $bank->id }}</div>
								</div>
							</td>
							<td>
								<div class="row valign-wrapper">
									<div class="col s2">
										<img src="{{asset($bank->logoPath)}}" class="bank-logo">
									</div>
									<div class="col s10">
										<span class="left">{{ $bank->name }}</span>
									</div>
								</div>
							</td>
							<td>
								<div class="row valign-wrapper">
									<div class="col s12">
										<a href="{{ route('admin.banks.edit', ['bank' => $bank->id]) }}">Editar</a> | 
										<delete-action action="{{ route('admin.banks.destroy', ['bank' => $bank->id]) }}" 
														action-element="link-delete-{{$bank->id}}" csrf-token="{{ csrf_token() }}">
											<?php $modalId = "modal-delete-{$bank->id}"; ?>
											<a id="link-modal-{{$bank->id}}" href="#{{ $modalId }}">Excluir</a>
											<modal :modal="{{json_encode(['id' => $modalId])}}" style="display: none;">
												<div slot="content">
													<div slot="content">
														<h5>Mensagem de confirmação</h5>
														<p>Deseja excluir este banco?</p>
														<div class="divider"></div>
														<p>Nome: <strong>{{ $bank->name }}</strong></p>
														<div class="divider"></div>
													</div>
													<div slot="footer" class="right">
														<br>
														<button class="btn btn-flat waves-effect waves-red modal-action modal-close">Cancelar</button>
														<button class="btn btn-flat waves-effect green lighten-2 modal-action modal-close" id="link-delete-{{$bank->id}}">OK</button>
													</div>
												</div>
											</modal>
										</delete-action>
									</div>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{!! $banks->links() !!}
		</div>
	</div>

@endsection