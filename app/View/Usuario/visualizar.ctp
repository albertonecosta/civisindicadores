<div class="container">
	<legend>Visualizar Usuário</legend>
	<div class="row">
		<div class="span12">
			<legend>Dados Pessoais</legend>
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($usuario['Pessoa']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Email'); ?></strong></td>
						<td><?php echo h($usuario['Pessoa']['email']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Login'); ?></strong></td>
						<td><?php echo h($usuario['Usuario']['login']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('CPF'); ?></strong></td>
						<td><?php echo h($usuario['Usuario']['cpf']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('RG'); ?></strong></td>
						<td><?php echo h($usuario['Usuario']['rg']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Observacao'); ?></strong></td>
						<td><?php echo ($usuario['Pessoa']['observacao']); ?></td>
					</tr>		
				</tbody>				
			</table>			
		</div>
		<div class="span12">
			<legend>Endereço</legend>
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Logradouro'); ?></strong></td>
						<td><?php echo h($endereco['Endereco']['logradouro']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Numero'); ?></strong></td>
						<td><?php echo h($endereco['Endereco']['numero']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Cep'); ?></strong></td>
						<td><?php echo h($endereco['Endereco']['cep']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Bairro'); ?></strong></td>
						<td><?php echo h($endereco['Endereco']['bairro']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Cidade'); ?></strong></td>
						<td><?php echo h($endereco['Endereco']['cidade']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Uf'); ?></strong></td>
						<td><?php echo h($endereco['Endereco']['uf']); ?></td>
					</tr>		
				</tbody>				
			</table>
		</div>
		<div class="span12">
			<legend>Dados de Acesso</legend>
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Grupo'); ?></strong></td>
						<td><?php echo h($usuario['Grupo']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Cargo'); ?></strong></td>
						<td><?php echo h($usuario['Cargo']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Vinculo'); ?></strong></td>
						<td><?php echo h($usuario['Vinculo']['titulo']); ?></td>
					</tr>	
				</tbody>				
			</table>
		</div>
	</div>
</div>