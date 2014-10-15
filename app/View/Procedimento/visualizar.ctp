<div class="container">
	<legend>Visualizar Procedimento</legend>
	<div class="buttons">
		<?php
		echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $procedimento['Procedimento']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
		echo "&nbsp;&nbsp;";
		echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $procedimento['Procedimento']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $procedimento['Procedimento']['id'])
				);
		?>
	</div>
	<div class="row">
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($procedimento['Procedimento']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Resultado Esperado'); ?></strong></td>
						<td><?php echo ($procedimento['Procedimento']['resultado_esperado']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Requisito'); ?></strong></td>
						<td><?php echo ($procedimento['Procedimento']['requisito']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Patrocinador'); ?></strong></td>
						<td><?php echo $this->Html->link($procedimento['Patrocinador']['Pessoa']['titulo'], array('controller' => 'Usuario', 'action' => 'visualizar',$procedimento['Patrocinador']['id'])); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Certificado'); ?></strong></td>
						<td><?php echo $procedimento['Procedimento']['resultado_esperado'] == Util::ATIVO ? "Sim": "Não" ; ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Arquivo'); ?></strong></td>
						<td><a href="<?php echo BASE.DS."files".DS."procedimento".DS.$procedimento['Procedimento']['arquivo_dir'].DS.$procedimento['Procedimento']['arquivo']; ?>"><?php echo $procedimento['Procedimento']['arquivo']; ?></a></td>
					</tr>
				</tbody>				
			</table>			
		</div>
	</div>
</div>