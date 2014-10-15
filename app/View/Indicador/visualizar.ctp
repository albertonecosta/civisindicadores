<div class="container">
	<h4 class="title title-section">Indicador</h4>
	<legend>Visualizar Indicador</legend>
	<div class="row">
		<div class="span12">
			<legend>Dados Básicos</legend>
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($indicador['Indicador']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Tipo'); ?></strong></td>
						<td><?php echo h($indicador['Indicador']['tipo']) == Util::ATIVO ? "Inteiro" : "Decimal"; ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Faixa'); ?></strong></td>
						<td><?php echo h($indicador['Faixa']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Resposável'); ?></strong></td>
						<td><?php echo h($indicador['Responsavel']['Pessoa']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Item superior'); ?></strong></td>
						<td><?php echo h($indicador['Pai']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Tipo do Calculo'); ?></strong></td>
						<td><?php echo Util::getTipoCalculo($indicador['Indicador']['tipo_calculo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Desdobramento'); ?></strong></td>
						<td><?php echo $indicador['Indicador']['desdobramento'] == Util::ATIVO ? 'Mensal' : 'Anual'; ?></td>
					</tr>	
				</tbody>				
			</table>			
		</div>
		<div class="span12">
			<legend>Atribuições</legend>
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Ordem'); ?></strong></td>
						<td><?php echo h($indicador['Indicador']['ordem']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Anos'); ?></strong></td>
						<td>
							<ul>
							<?php foreach ($anos as $key => $value) { ?>
								<li><?php echo $value;?></li>
							<?php } ?>
							</ul>
						</td>
					</tr>
					<tr>
						<td><strong><?php echo __('Quem irá visualizar'); ?></strong></td>
						<td>
							<ul>
							<?php foreach ($indicadorAutorizadoVisualizar as $key => $value) { ?>
								<li><?php echo $value['Usuario']['Pessoa']['titulo'];?></li>
							<?php } ?>
							</ul>
						</td>
					</tr>
					<tr>
						<td><strong><?php echo __('Quem irá colocar a meta'); ?></strong></td>
						<td>
							<ul>
							<?php foreach ($indicadorResponsavelMeta as $key => $value) { ?>
								<li><?php echo $value['Usuario']['Pessoa']['titulo'];?></li>
							<?php } ?>
							</ul>
						</td>
					</tr>
					<tr>
						<td><strong><?php echo __('Quem irá colocar o realizado'); ?></strong></td>
						<td>
							<ul>
							<?php foreach ($indicadorResponsavelrealizado as $key => $value) { ?>
								<li><?php echo $value['Usuario']['Pessoa']['titulo'];?></li>
							<?php } ?>
							</ul>
						</td>
					</tr>	
				</tbody>				
			</table>
		</div>
</div>