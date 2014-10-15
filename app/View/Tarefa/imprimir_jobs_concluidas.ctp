<?php 
	echo $this->Html->css('bootstrap.min');
	echo $this->Html->css('bootstrap-responsive.min');
?>
<div class="row-fluid">
	<legend>Jobs Concluidas</legend>
	<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th><?php echo __('titulo'); ?></th>
				<th><?php echo __('data de início'); ?></th>
				<th><?php echo __('data final'); ?></th>
				<th><?php echo __('responsável'); ?></th>
				<th><?php echo __('supervisor'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($tarefa as $tarefa){?>
			<tr>
				<td><?php echo $tarefa['Tarefa']['titulo']; ?>&nbsp;</td>
				<td><?php echo $tarefa['Tarefa']['data_inicio_previsto']; ?>&nbsp;</td>
				<td><?php echo $tarefa['Tarefa']['data_fim_previsto']; ?>&nbsp;</td>
				<td><?php echo $tarefa['Responsavel']['Pessoa']['titulo']; ?>&nbsp;</td>
				<td><?php echo $tarefa['Supervisor']['Pessoa']['titulo']; ?>&nbsp;</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>