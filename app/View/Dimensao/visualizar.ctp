<div class="container">
	<legend>Visualizar Dimensao</legend>
	<div class="buttons">
		<?php
		echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $dimensao['Dimensao']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
		echo "&nbsp;&nbsp;";
		echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $dimensao['Dimensao']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $dimensao['Dimensao']['id'])
				);
		?>
	</div>
	<div class="row">
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($dimensao['Dimensao']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Observação'); ?></strong></td>
						<td><?php echo ($dimensao['Dimensao']['observacao']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Ordem'); ?></strong></td>
						<td><?php echo h($dimensao['Dimensao']['ordem']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Empresa'); ?></strong></td>
						<td><?php echo h($dimensao['Empresa']['Pessoa']['titulo']); ?></td>
					</tr>
				</tbody>				
			</table>			
		</div>
	</div>
</div>