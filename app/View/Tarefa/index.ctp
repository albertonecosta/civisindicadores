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

// Carregamento das variáveis para controle de acesso
$adicionar = $this->ControleDeAcesso->validaAcessoElemento('adicionar', 'Tarefa');
$visualizar = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Tarefa');
$editar = $this->ControleDeAcesso->validaAcessoElemento('editar', 'Tarefa');
$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir', 'Tarefa');
$imprimir = $this->ControleDeAcesso->validaAcessoElemento('imprimir', 'Tarefa');
$visualizarUsuario = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Usuario');
?>
<div class="container">
<script src="<?php echo $this->base?>/js/responsiveTabs.js"></script>
		<script>
		$(document).ready(function() {
			$('.footable').footable();
			$("#index1").treetable({ expandable: true});
			$("#index2").treetable({ expandable: true});
			$("#index3").treetable({ expandable: true});
			RESPONSIVEUI.responsiveTabs();
			
		})
		
		</script>
  <link rel="stylesheet" href="<?php echo $this->base?>/css/responsive-tabs.css">
	<h4 class="title title-section">Tarefas</h4>
	<form method="post" class="well form-search">
		<div class="list-actions row-fluid">
			<!-- Filtros -->
			<div class="list-filters pull-left">
				<div class="with-select">
					<input name="data[Tarefa][busca]" placeholder="O que você procura?" type="text" id="TarefaBusca">
					<?php $options = array('titulo' => 'Título', 'data_inicio_previsto' => 'Data início', 'data_fim_previsto' => 'Data fim');?>
					<select name="data[Tarefa][buscar_em]" id="TarefaBuscarEm">
						<option value="titulo">Filtrar em:</option>					
						<?php foreach($options as $key => $value){?>
						<option value="<?php echo $key; ?>"><?php echo $value;?></option>
						<?php } ?>
					</select>
					<button type="submit" class="btn"><i class="icon-search fa fa-search"></i></button>
				</div>
				<div class="filters-tags">
					<?php
					if(isset($_SESSION['Search']['Tarefa'])){
						if(count($_SESSION['Search']['Tarefa'])>0){
						?>
						<h4 class="title">Filtrado por:</h4>
						<?php
							foreach($_SESSION['Search']['Tarefa'] as $key => $temo_busca){
						?>
							<span class="type-tag"><?php echo $temo_busca['buscar_em']?>: <?php echo $temo_busca['busca']?><?php echo $this->Html->link("", array("action" => "excluirFiltro", $key), array("class" => "fa fa-times")); ?></span>
						<?php	
							}
						}
					}
					?>
				</div>
			</div><!-- /.list-filters -->
				<div class="list-actions-buttons pull-right">
				<?php if($adicionar){?>				
				<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->webroot; ?>Tarefa/adicionar' "><i class="fa fa-plus-circle"></i>Adicionar</button>
				<?php }?>
			</div><!-- /.list-actions -->
			<!-- end Filtros -->
		</div>
	</form>
	<!-- 
	<?php
		echo $this->FilterForm->create('',array('class' => 'well form-search'));
	?>

	<div class="list-actions row-fluid">
	
		
		<div class="list-filters pull-left">
			
			<div class="with-select">
				<?php
					echo $this->FilterForm->input('filter1', array('placeholder' => 'O que você procura?'));		
				?>
				<select name="" id="">
					<option value="">Filtrar em:</option>
					<option value="">Título</option>
				</select>
				<button type="submit" class="btn"><i class="icon-search fa fa-search"></i></button>
			</div>
			
			<div class="filters-tags">
				<h4 class="title">Filtrado por:</h4>
				<span class="type-tag">Cidade: Recife<a href="javascript:void(0)" class="fa fa-times"></a></span>
				<span class="type-tag">Cidade: Recife<a href="javascript:void(0)" class="fa fa-times"></a></span>
				<span class="type-tag">Cidade: Recife<a href="javascript:void(0)" class="fa fa-times"></a></span>
			</div>

		</div>
		
		<div class="list-actions-buttons pull-right">
			<div class="span3">
				<button class="btn btn-small btn-primary pull-right" type="button" onclick="location.href= '<?php echo $this->Html->url(array('controller' => 'Acao', 'action' => 'adicionar'), true);?>' ">Adicionar</button>
			</div>
			<div class="span1">
				<button class="btn btn-small btn-primary pull-left" type="button" onclick="location.href= '<?php echo $this->webroot;?>Tarefa/imprimirIndex/<?php echo $limit; ?>' ">Imprimir</button>
			</div>			
			</div>

		

	</div>
	</form>
	 -->
	<div class="row-fluid">
		<div class="responsive-tabs">

			<h2>	<legend>Não Iniciadas</legend></h2>
			<div class="row-fluid">
			
	
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
			<?php foreach($naoIniciadas as $tarefa){?>
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
	<div class="row-fluid" style="margin-bottom: 20px">
		<button class="btn btn-small btn-primary pull-left" type="button" onclick="location.href= '<?php echo $this->Html->url(array('controller' => 'Tarefa', 'action' => 'jobsNaoIniciados'), true);?>' ">Ver todos</button>
	</div>
</div>
			<h2><legend>Em Andamento</legend></h2>
			<div>
			
		
		<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index2">
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
			<?php foreach($iniciadas as $tarefa){?>
				<tr>
					<td><?php if($visualizar){ 
							echo $this->Html->link($tarefa['Tarefa']['titulo'], array('action' => 'visualizar', $tarefa['Tarefa']['id']));
						}else{
							echo $tarefa['Tarefa']['titulo'];
						} ?>&nbsp;</td>
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
	
	<div class="row-fluid" style="margin-bottom: 20px">
		<button class="btn btn-small btn-primary pull-left" type="button" onclick="location.href= '<?php echo $this->Html->url(array('controller' => 'Tarefa', 'action' => 'jobsEmAndamento'), true);?>' ">Ver todos</button>
	</div>
			
			</div>
			
			<h2><legend>Concluídas</legend></h2>
			<div>
		<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index3">
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
			<?php foreach($concluidas as $tarefa){?>
				<tr>
					<td><?php if($visualizar){ 
							echo $this->Html->link($tarefa['Tarefa']['titulo'], array('action' => 'visualizar', $tarefa['Tarefa']['id']));
						}else{
							echo $tarefa['Tarefa']['titulo'];
						} ?>&nbsp;</td>
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
		<div class="row-fluid" style="margin-bottom: 20px">
			<button class="btn btn-small btn-primary pull-left" type="button" onclick="location.href= '<?php echo $this->Html->url(array('controller' => 'Tarefa', 'action' => 'jobsConcluidas'), true);?>' ">Ver todos</button>
		</div>
			
		</div>
	</div>

		<div class="row-fluid">
			<div class="span6">
				<small>
					<form method="post">
						<?php
							$total = count($naoIniciadas);
							if(count($naoIniciadas) < count($iniciadas)){
								$total = count($iniciadas);
							}else if(count($iniciadas) < count($concluidas)){
								$total = count($concluidas);
							}
						?>
						Exibir até <input type="text" class="span1" name="limit" value="<?php echo $limit > $total ? $total : $limit; ?>"> registros no total.
						<button type="submit" class="btn btn-primary">Enviar</button>
					</form>
				</small>	
			</div>	
			<div class="span6">
					<div class="pagination pagination-mini pull-right" style="margin:0;">
					</div>
				</div>
		</div>
	</div>
</div>