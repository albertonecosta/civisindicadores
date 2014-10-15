<div class="container">
	<legend>Visualizar Empresa</legend>
	<div class="row">
		<div class="span12">
			<legend>Dados Básicos</legend>
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($empresa['Pessoa']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Email'); ?></strong></td>
						<td><?php echo h($empresa['Pessoa']['email']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Tipo'); ?></strong></td>
						<td><?php echo h($empresa['Pessoa']['tipo']); ?></td>
					</tr>
					<?php if($empresa['Empresa']['matriz'] == 0){?>
					<tr>
						<td><strong><?php echo __('Matriz'); ?></strong></td>
						<td><?php echo h($empresa['Matriz']['Pessoa']['titulo']); ?></td>
					</tr>					
					<?php }else{ ?>
					<tr>
						<td><strong><?php echo __('Filiais'); ?></strong></td>
						<td><ul>				
					<?php foreach($empresa['Filial'] as $filial){ ?>
							<li><?php echo $filial['Pessoa']['titulo'];?></li>						
					<?php }}?>
						</ul></td>
					</tr>
					<tr>
						<td><strong><?php echo __('CNPJ'); ?></strong></td>
						<td><?php echo h($empresa['Empresa']['cnpj']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Inscrição Municipal'); ?></strong></td>
						<td><?php echo h($empresa['Empresa']['inscricao_municipal']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Inscrição Estadual'); ?></strong></td>
						<td><?php echo h($empresa['Empresa']['inscricao_estadual']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Observacao'); ?></strong></td>
						<td><?php echo ($empresa['Pessoa']['observacao']); ?></td>
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
						<td><?php echo h($empresa['Pessoa']['Endereco']['logradouro']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Numero'); ?></strong></td>
						<td><?php echo h($empresa['Pessoa']['Endereco']['numero']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Cep'); ?></strong></td>
						<td><?php echo h($empresa['Pessoa']['Endereco']['cep']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Bairro'); ?></strong></td>
						<td><?php echo h($empresa['Pessoa']['Endereco']['bairro']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Cidade'); ?></strong></td>
						<td><?php echo h($empresa['Pessoa']['Endereco']['cidade']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Uf'); ?></strong></td>
						<td><?php echo h($empresa['Pessoa']['Endereco']['uf']); ?></td>
					</tr>		
				</tbody>				
			</table>
		</div>
	</div>
</div>