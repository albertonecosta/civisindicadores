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
$adicionar = $this->ControleDeAcesso->validaAcessoElemento('adicionar');
$visualizar = $this->ControleDeAcesso->validaAcessoElemento('visualizar');
$editar = $this->ControleDeAcesso->validaAcessoElemento('editar');
$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir');
$imprimir = $this->ControleDeAcesso->validaAcessoElemento('imprimir');
$visualizarProjeto = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Projeto');
?>
<script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });
  $("#index").treetable({ expandable: true});
</script>
<div class="container">

	<h4 class="title title-section">Programas</h4>
	
	<form method="post" class="well form-search">
		<div class="list-actions row-fluid">
			<!-- Filtros -->
			<div class="list-filters pull-left">
				<div class="with-select">
					<input name="data[Programa][busca]" placeholder="O que você procura?" type="text" id="ProgramaBusca">
					<?php $options = array('Programa.titulo' => 'Título', 'Programa.descricao' => 'Descricao', 'Programa.data_inicio_previsto' => 'Data de Início', 'Pessoa.titulo'=>'Responsável', 'Setor.titulo'=>'Setor', 'Departamento.titulo'=>'Departamento');?>
					<select name="data[Programa][buscar_em]" id="ProgramaBuscarEm">
						<option value="Programa.titulo">Filtrar em:</option>					
						<?php foreach($options as $key => $value){?>
						<option value="<?php echo $key; ?>"><?php echo $value;?></option>
						<?php } ?>
					</select>
					<button type="submit" class="btn"><i class="icon-search fa fa-search"></i></button>
				</div>
				<div class="filters-tags">
					<?php
					if(isset($_SESSION['Search']['Programa'])){
						if(count($_SESSION['Search']['Programa'])>0){
						?>
						<h4 class="title">Filtrado por:</h4>
						<?php
							foreach($_SESSION['Search']['Programa'] as $key => $temo_busca){
						?>
							<span class="type-tag"><?php echo $options[$temo_busca['buscar_em']]?>: <?php echo $temo_busca['busca']?><?php echo $this->Html->link("", array("action" => "excluirFiltro", $key), array("class" => "fa fa-times")); ?></span>
						<?php	
							}
						}
					}
					?>
				</div>
			</div><!-- /.list-filters -->
				<div class="list-actions-buttons pull-right">	
				<?php if($adicionar){?>			
				<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->webroot; ?>Programa/adicionar' "><i class="fa fa-plus-circle"></i>Adicionar</button>
				<?php }?>
			</div><!-- /.list-actions -->
			<!-- end Filtros -->
		</div>
	</form>
	
	
	<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index">
		<thead>
			<tr>
				<th data-class="expand">Titulo</th>
				<th data-hide="phone,tablet">Início</th>
				<th data-hide="phone,tablet">Fim</th>
				<th data-hide="phone,tablet" width=400><?php echo __('Projetos associados'); ?></th>
				<?php if($editar || $excluir || $imprimir){?>
				<th><center><?php echo __('Ações'); ?></center></th>
				<?php }?>
			</tr>
		</thead>
		<tbody>
		<?php foreach($programas as $programa){
		?>
			<tr>
				<td>
					<?php
						if($visualizar){
							echo $this->Html->link($programa['titulo'], array('action' => 'visualizar', $programa['id']));
						}else{
							echo $programa['titulo'];
						}
					?>&nbsp;
				</td>
				<td><?php echo Util::inverteData($programa['data_inicio']); ?>&nbsp;</td>
				<td><?php echo Util::inverteData($programa['data_fim']); ?>&nbsp;</td>
				<td class="no-padding">
					<ul class="list-inner">
					<?php
					
					if(isset($projetos[$programa['id']])){
						foreach ($projetos[$programa['id']] as $key => $value) {

							if($value["Projeto"]['status'] != Util::INATIVO){
							
							
							
						?>
							<li>
								<div class="wrapper">
								<div class="text">
									<?php
									if($value["Projeto"]["concluido"]==1){
										echo '<span class="icon-check fa fa-check-square-o"></span>';
									}
									
									?>
										<abbr>
										<?php 
											if($visualizarProjeto){
											echo $this->Html->link($value["Projeto"]['titulo'], array('controller' => 'Projeto', 'action' => 'visualizar', $value["Projeto"]['id']));
											}else{
												echo $value["Projeto"]['titulo'];
											}
										?>	
										</abbr>
									
									</div>									
								</div>
							</li>
						<?php
							}
						}
					}
					?>
					</ul>
					
				</td>
				<?php if($editar || $excluir || $imprimir){?>
				<td width="7%" nowrap="nowrap" class="actions">
					<?php 
						if($editar){
						echo $this->Html->link(
							__(""),
							array('action' => 'editar', $programa['id']),
							array('class'=>'icon-edit fa fa-edit')
						);
						}
					?>
					
					<?php
						if($excluir){
						echo $this->Form->postLink(
							__(""), 
							array('action' => 'excluir', $programa['id']), 
							array('class'=>'icon-trash fa fa-trash-o'),
							__(Util::MENSAGEM_DELETAR, $programa['id'])
						); 
						}
					?>
						<?php
						if($imprimir){
						echo "&nbsp;";
						echo $this->Html->link(
							__(""),
							array('action' => 'imprimir', $programa['id']),
							array('class'=>'icon-print fa fa-print')
						);
						echo "&nbsp;";
						}
					?>
				</td>
				<?php }?>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	
	<?php echo $this->element('paginacao'); ?>
	
