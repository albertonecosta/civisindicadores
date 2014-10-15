<?php 
echo $this->Html->css('bootstrap.min');
echo $this->Html->css('bootstrap-responsive.min');
?>
<div class="row-fluid">
		<legend>O que devo fazer?</legend>
		<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index1">
			<thead>
				<tr>
					<th data-class="expand"><?php echo __('titulo'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('data de início'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('data final'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('responsável'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('supervisor'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('andamento'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($acoes as $acao){?>
				<tr>
					<td><?php echo $acao['Acao']['titulo']; ?>&nbsp;</td>
					<td><?php echo $acao['Acao']['data_inicio_previsto']; ?>&nbsp;</td>
					<td><?php echo $acao['Acao']['data_fim_previsto']; ?>&nbsp;</td>
					<td><?php echo $acao['Responsavel']['Pessoa']['titulo']; ?>&nbsp;</td>
					<td><?php echo $acao['Supervisor']['Pessoa']['titulo']; ?>&nbsp;</td>
					<td><?php echo $acao['Acao']['andamento']; ?>&nbsp;</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="row-fluid">
		<legend>O que espero que façam?</legend>
		<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index2">
			<thead>
				<tr>
					<th data-class="expand"><?php echo __('titulo'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('data de início'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('data final'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('responsável'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('supervisor'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('andamento'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($acoes2 as $acao){?>
				<tr>
					<td><?php echo $acao['Acao']['titulo']; ?>&nbsp;</td>
					<td><?php echo $acao['Acao']['data_inicio_previsto']; ?>&nbsp;</td>
					<td><?php echo $acao['Acao']['data_fim_previsto']; ?>&nbsp;</td>
					<td><?php echo $acao['Responsavel']['Pessoa']['titulo']; ?>&nbsp;</td>
					<td><?php echo $acao['Supervisor']['Pessoa']['titulo']; ?>&nbsp;</td>
					<td><?php echo $acao['Acao']['andamento']; ?>&nbsp;</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>