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
$adicionar = $this->ControleDeAcesso->validaAcessoElemento('adicionar', 'Tarefa');
$visualizar = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Tarefa');
$editar = $this->ControleDeAcesso->validaAcessoElemento('editar', 'Tarefa');
$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir', 'Tarefa');
$imprimir = $this->ControleDeAcesso->validaAcessoElemento('imprimir', 'Tarefa');
$visualizarUsuario = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Usuario');
?>
<div class="container">
	<br />
	<h4>Tarefas</h4>
	<?php
		echo $this->FilterForm->create('',array('class' => 'well form-search'));
	?>
	<div class="row">
		<div class="span6">
			<div class="input-append">
				<?php
					echo $this->FilterForm->input('filter1');		
				?>
				<button type="submit" class="btn"><i class="icon-search"></i>&nbsp;</button>
			</div>
		</div>
		<div class="span5">				
			<div class="span3">
				<?php if($adicionar){?>
				<button class="btn btn-small btn-primary pull-right" type="button" onclick="location.href= '<?php echo $this->Html->url(array('controller' => 'Acao', 'action' => 'adicionar'), true);?>' ">Adicionar</button>
				<?php }?>
			</div>
			<?php 
			$url = $_SERVER['REQUEST_URI'];
			$url = explode("/", $url);
			$url = end($url);
			?>
			<div class="span1">
				<?php if($imprimir){?>
				<button class="btn btn-small btn-primary pull-left" type="button" onclick="location.href= '<?php echo $this->webroot;?>Tarefa/imprimirJobsNaoIniciados/<?php echo $url; ?>' ">Imprimir</button>
				<?php }?>
			</div>
		</div>
	</div>
	</form>
	
	<div class="row-fluid">
		<legend>Jobs não iniciadas</legend>
		<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index1">
			<thead>
				<tr>
					<th data-class="expand"><?php echo __('titulo'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('data de início'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('data final'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('responsável'); ?></th>
					<th data-hide="phone,tablet"><?php echo __('supervisor'); ?></th>
					<?php if($editar || $excluir){?>
					<th><center><?php echo __('Ações'); ?></center></th>
					<?php }?>
				</tr>
			</thead>
			<tbody>
			<?php foreach($tarefa as $tarefa){?>
				<tr>
					<td><?php
						if($visualizar){ 
							echo $this->Html->link($tarefa['Tarefa']['titulo'], array('action' => 'visualizar', $tarefa['Tarefa']['id']));
						}else{
							echo $tarefa['Tarefa']['titulo'];
						}
						?>&nbsp;</td>
					<td><?php echo $tarefa['Tarefa']['data_inicio_previsto']; ?>&nbsp;</td>
					<td><?php echo $tarefa['Tarefa']['data_fim_previsto']; ?>&nbsp;</td>
					<td><?php 
					if($visualizarUsuario){
					echo $this->Html->link($tarefa['Responsavel']['Pessoa']['titulo'], array('controller' => 'Usuario','action' => 'visualizar', $tarefa['Responsavel']['id'])); 
					}else{
						echo $tarefa['Responsavel']['Pessoa']['titulo'];
					}
					?>&nbsp;</td>
					<td><?php 
					if($visualizarUsuario){
						echo $this->Html->link($tarefa['Supervisor']['Pessoa']['titulo'], array('controller' => 'Usuario','action' => 'visualizar', $tarefa['Supervisor']['id']));
					}else{
						echo $tarefa['Supervisor']['Pessoa']['titulo'];
					}
					?>&nbsp;</td>
					<?php if($editar || $excluir){?>
					<td width="7%" nowrap="nowrap" align=left>
						<?php 
							if($editar){
								echo $this->Html->link(
									__(""),
									array('action' => 'editar', $tarefa['Tarefa']['id']),
									array('class'=>'icon-edit')
								);
								echo "&nbsp;";
							}
							if($excluir){
								echo $this->Form->postLink(
									__(""), 
									array('action' => 'excluir', $tarefa['Tarefa']['id']), 
									array('class'=>'icon-trash'),
									__(Util::MENSAGEM_DELETAR, $tarefa['Tarefa']['id'])
								);
								echo "&nbsp;";
							}
							if(count($tarefa['Post']) > 0){
								if($visualizar){
									echo $this->Html->link(
										__(""), 
										array('action' => 'visualizar', $tarefa['Tarefa']['id']), 
										array('class'=>'icon-comment')
									);
								}
							}
						?>
					</td>
					<?php }?>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	
	<div class="row">
		<div class="span6">
			<small>
				<?php
				echo $this->Paginator->counter(array(
				'format' => __(Util::MENSAGEM_PADRAO_PAGINACAO)
				));
				?>
			</small>	
		</div>	
		<div class="span6">
				<div class="pagination pagination-mini pull-right" style="margin:0;">
				<ul>
				<?php
					echo $this->Paginator->prev(__(Util::ANTERIOR_PAGINACAO), array(
						'escape'=>false,
						'tag'=>'li'
					), '<a onclick="return false;">' . Util::ANTERIOR_PAGINACAO . '</a>', 
					array('class'=>'disabled prev','escape'=>false,'tag'=>'li'));
					
					echo $this->Paginator->numbers(
						array(
							'separator' => '',
							'currentClass' => 'active',
							'currentTag' => 'a',
							'tag'=>'li'
						)
					);
					
					echo $this->Paginator->next(__(Util::PROXIMO_PAGINACAO), array(
						'escape'=>false,
						'tag'=>'li'
					), '<a onclick="return false;">' . Util::PROXIMO_PAGINACAO . '</a>', 
					array('class'=>'disabled next','escape'=>false,'tag'=>'li'));
			
				?>
				</ul>
				</div>
			</div>
	</div>
</div>