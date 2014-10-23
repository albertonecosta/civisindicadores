<?php
	$editar = $this->ControleDeAcesso->validaAcessoElemento('editar');
	$visualizarProjeto = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Projeto');
?>
<div class="container">
	<legend>Visualizar Programa
			<div class="list-actions-buttons pull-right">				
			<?php if($editar){?>
			<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->Html->url(__(""),
							array('action' => 'editar', $programa['Programa']['id']));?>'"><i class="fa fa-plus-circle"></i>Editar</button><?php }?>
		</div>



	</legend>
	<div class="row">
	
		
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($programa['Programa']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Descrição'); ?></strong></td>
						<td><?php echo h($programa['Programa']['descricao']); ?></td>
					</tr>					
					<tr>
						<td><strong><?php echo __('Data de Início'); ?></strong></td>
						<td><?php echo h($programa['Programa']['data_inicio']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Data de Fim'); ?></strong></td>
						<td><?php echo h($programa['Programa']['data_fim']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Projetos Associados'); ?></strong></td>
						<td class="no-padding">
							<ul class="list-inner">
							
							<?php
							/**
							 * 
							 * Exibição das ações do projeto atual
							 * 							 * 
							 */
							if(isset($projetos)){
								foreach ($projetos as $key => $value) {
								?>
								
									<li>
									<div class="wrapper">
									<div class="text">
									<?php
									// Habilitando o icone para projetos concluidos
									if($value["concluido"]==1){
										echo '<span class="icon-check fa fa-check-square-o"></span>';
									}
									?>
									
											<abbr style='font-size: 16px;' title='<?php echo $value["titulo"]." | ".Util::inverteData($value["data_inicio_previsto"])." a ".Util::inverteData($value["data_fim_previsto"])?>'>
												<?php
													if($visualizarProjeto){
														echo $this->Html->link($value['titulo'], array('controller' => 'Acao', 'action' => 'visualizar', $value['id']));
													}else{
														echo $value['titulo'];
													}
												?>
											<abbr>
										
																			
								
									</div>									
									</div>
									</li>
					<?php }} ?>
							</ul>
						&nbsp;
						</td>
					</tr>
				</tbody>				
			</table>			
		</div>
	</div>
</div>

