<div class="container">
	<legend>Visualizar Cargo</legend>
	<div class="row">
	<div class="buttons">
		<?php
		echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $cargo['Cargo']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
		echo "&nbsp;&nbsp;";
		echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $cargo['Cargo']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $cargo['Cargo']['id'])
				);
		?>
	</div>
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($cargo['Cargo']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Descrição'); ?></strong></td>
						<td><?php echo ($cargo['Cargo']['descricao']); ?></td>
					</tr>
				</tbody>				
			</table>			
		</div>
	</div>
</div>