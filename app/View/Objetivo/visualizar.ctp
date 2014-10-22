<?php
	$editar = $this->ControleDeAcesso->validaAcessoElemento('editar');
	$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir');
?>
<div class="container">
	<legend>Visualizar Objetivo</legend>
	<div class="buttons">
		<?php
		if($editar){
		echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $objetivo['Objetivo']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
			echo "&nbsp;&nbsp;";
		}
		if($excluir){
		echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $objetivo['Objetivo']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $objetivo['Objetivo']['id'])
				);
		}
		?>
	</div>
	<br />
	<div class="row">
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($objetivo['Objetivo']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Ordem'); ?></strong></td>
						<td><?php echo h($objetivo['Objetivo']['ordem']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Dimensao'); ?></strong></td>
						<td><?php echo h($objetivo['Dimensao']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Ano'); ?></strong></td>
						<td><?php echo h($objetivo['Objetivo']['ano']); ?></td>
					</tr>
				</tbody>				
			</table>			
		</div>
	</div>
</div>