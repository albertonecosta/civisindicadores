<div class="container">
	<legend>Visualizar Ações</legend>
	<div class="buttons">
		<?php
		echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $medida['Medida']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
		echo "&nbsp;&nbsp;";
		echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $medida['Medida']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $medida['Medida']['id'])
				);
		?>
	</div>
	<div class="row">
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($medida['Medida']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Ordem'); ?></strong></td>
						<td><?php echo h($medida['Medida']['ordem']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Dimensao'); ?></strong></td>
						<td><?php echo h($medida['Dimensao']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Ano'); ?></strong></td>
						<td><?php echo h($medida['Medida']['ano']); ?></td>
					</tr>
				</tbody>				
			</table>			
		</div>
	</div>
</div>