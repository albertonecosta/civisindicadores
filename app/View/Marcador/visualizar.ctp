<div class="container">
	<legend>Visualizar Marcador</legend>
	<div class="buttons">
		<?php
		echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $marcador['Marcador']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
		echo "&nbsp;&nbsp;";
		echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $marcador['Marcador']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $marcador['Marcador']['id'])
				);
		?>
	</div>
	<div class="row">
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($marcador['Marcador']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Descrição'); ?></strong></td>
						<td><?php echo h($marcador['Marcador']['descricao']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Ações'); ?></strong></td>
						<td>
							<ul class="list-inner">
							<?php
							
							if(isset($marcador["MarcadorObjetivo"])){
								

									foreach($marcador["MarcadorObjetivo"] as $objetivo){
									
								?>
									<li>
										<div class="wrapper">
										<div class="text">
												<abbr>
												<?php echo $this->Html->link($objetivo["Objetivo"]['titulo'], array('controller' => 'Medida', 'action' => 'visualizar', $objetivo["Objetivo"]['id'])); ?>	
												</abbr>
											</div>									
										</div>
									</li>
								<?php
									
								}
							}
							?>
							</ul>
						</td>
					</tr>
				</tbody>				
			</table>			
		</div>
	</div>
</div>