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
$editar = $this->ControleDeAcesso->validaAcessoElemento('editar', 'Procedimento');
$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir', 'Procedimento');
$visualizarUsuario = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Usuario');
?>
<div class="container">
	<legend>Visualizar Procedimento
	<div class="list-actions-buttons pull-right">
		<?php
		if($editar){
		echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $procedimento['Procedimento']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
		echo "&nbsp;&nbsp;";
		}
		if($excluir){
		echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $procedimento['Procedimento']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $procedimento['Procedimento']['id'])
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
						<td><?php 
						if($visualizarUsuario){
							echo $this->Html->link($procedimento['Patrocinador']['Pessoa']['titulo'], array('controller' => 'Usuario', 'action' => 'visualizar',$procedimento['Patrocinador']['id']));
						}else{
							echo $procedimento['Patrocinador']['Pessoa']['titulo'];
						}
						?></td>
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