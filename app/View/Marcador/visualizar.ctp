<?php 
/**
 *
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL.odt", junto com este programa. Se não encontrar,
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
 *
 */

// Carregamento das variáveis de controle de acesso
$editar = $this->ControleDeAcesso->validaAcessoElemento('editar', 'Marcador');
$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir', 'Marcador');
$visualizarAcaoEstrategica = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'AcaoEstrategica');
?>
<div class="container">
	<legend>Visualizar Marcador</legend>
	<div class="buttons">
		<?php
		if($editar){
			echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $marcador['Marcador']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
			echo "&nbsp;&nbsp;";
		}
		if($excluir){
			echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $marcador['Marcador']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $marcador['Marcador']['id'])
				);
		}
		?>
	</div>
	<br/>
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
						<td><strong><?php echo __('Ações Estratégicas Associadas'); ?></strong></td>
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
												<?php 
												if($visualizarAcaoEstrategica){
													echo $this->Html->link($objetivo["Objetivo"]['titulo'], array('controller' => 'AcaoEstrategica', 'action' => 'visualizar', $objetivo["Objetivo"]['id']));
												}else{
													echo $objetivo["Objetivo"]['titulo'];
												}?>	
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