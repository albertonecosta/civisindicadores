<?php 
echo $this->Html->css('bootstrap.min');
echo $this->Html->css('bootstrap-responsive.min');
?>
<div class="row-fluid">
	<legend>O que devo fazer?</legend>
	<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th><?php echo __('titulo'); ?></th>
				<th><?php echo __('data de início'); ?></th>
				<th><?php echo __('data final'); ?></th>
				<th><?php echo __('responsável'); ?></th>
				<th><?php echo __('supervisor'); ?></th>
				<th><?php echo __('andamento'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($acao as $acao){?>
			<tr>
				<td><?php echo $acao['Acao']['titulo']; ?>&nbsp;</td>
				<td><?php echo $acao['Acao']['data_inicio_previsto']; ?>&nbsp;</td>
				<td><?php echo $acao['Acao']['data_fim_previsto']; ?>&nbsp;</td>
				<td><?php echo $acao['Responsavel']['Pessoa']['titulo']; ?>&nbsp;</td>
				<td><?php $acao['Supervisor']['Pessoa']['titulo']; ?>&nbsp;</td>
				<td><?php echo $acao['Acao']['andamento']; ?>&nbsp;</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>