<?php
	$editar = $this->ControleDeAcesso->validaAcessoElemento('editar');
	$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir');
?>
<div class="container">
	<legend>Visualizar Faixa</legend>
	<div class="buttons">
		<?php
		if($editar){
		echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $faixa['Faixa']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
		echo "&nbsp;&nbsp;";
		}
		if($excluir){
		echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $faixa['Faixa']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $faixa['Faixa']['id'])
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
						<td><?php echo h($faixa['Faixa']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Limite Vermelho'); ?></strong></td>
						<td><?php echo h($faixa['Faixa']['limite_vermelho']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Limite Amarelo'); ?></strong></td>
						<td><?php echo h($faixa['Faixa']['limite_amarelo']); ?></td>
					</tr>
				</tbody>				
			</table>			
		</div>
	</div>
</div>