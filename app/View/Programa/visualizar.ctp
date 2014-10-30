<?php 
/**
*
* Copyright [2014] -  Civis Gestão Inteligente
* Este arquivo é parte do programa Civis Estratégia
* O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
* Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
* Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
*
*/

// Carregamento das variáveis para controle de acesso
$editar = $this->ControleDeAcesso->validaAcessoElemento('editar');
$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir');
$visualizarProjeto = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Projeto');
?>
<div class="container">
	<legend>Visualizar Programa
	
	<div class="list-actions-buttons pull-right">
		<?php
		if($editar){
		echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $programa['Programa']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
		echo "&nbsp;&nbsp;";
		}
		if($excluir){
		echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $programa['Programa']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $programa['Programa']['id'])
				);
		}
		?>
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
														echo $this->Html->link($value['titulo'], array('controller' => 'Projeto', 'action' => 'visualizar', $value['id']));
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

