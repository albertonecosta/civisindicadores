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

//Carregamento das variáveis para controlde de acesso

$adicionar = $this->ControleDeAcesso->validaAcessoElemento('adicionar');
$visualizar = $this->ControleDeAcesso->validaAcessoElemento('visualizar');
$editar = $this->ControleDeAcesso->validaAcessoElemento('editar');
$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir');
?>
<div class="container">
	<br />
	<h4>Cargos</h4>
	<form method="post" class="well form-search">
		<div class="list-actions row-fluid">
			<!-- Filtros -->
			<div class="list-filters pull-left">
				<div class="with-select">
					<input name="data[Cargo][busca]" placeholder="O que você procura?" type="text" id="CargoBusca">
					<?php $options = array('Cargo.titulo' => 'Título');?>
					<select name="data[Cargo][buscar_em]" id="CargoBuscarEm">
						<option value="Cargo.titulo">Filtrar em:</option>					
						<?php foreach($options as $key => $value){?>
						<option value="<?php echo $key; ?>"><?php echo $value;?></option>
						<?php } ?>
					</select>
					<button type="submit" class="btn"><i class="icon-search fa fa-search"></i></button>
				</div>
				<div class="filters-tags">
					<?php
					if(isset($_SESSION['Search']['Cargo'])){
						if(count($_SESSION['Search']['Cargo'])>0){
						?>
						<h4 class="title">Filtrado por:</h4>
						<?php
							foreach($_SESSION['Search']['Cargo'] as $key => $temo_busca){
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
				<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->webroot; ?>Cargo/adicionar' "><i class="fa fa-plus-circle"></i>Adicionar</button>
				<?php }?>
			</div><!-- /.list-actions -->
			<!-- end Filtros -->
		</div>
	</form>
	
	<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('titulo'); ?></th>
				<?php if($editar || $excluir){?>
				<th><center><?php echo __('Ações'); ?></center></th>
				<?php }?>
			</tr>
		</thead>
		<tbody>
		<?php foreach($cargo as $cargo){?>
			<tr>
				<td><?php 
				if($visualizar){
					echo $this->Html->link($cargo['Cargo']['titulo'], array('action' => 'visualizar', $cargo['Cargo']['id']));
				}else{
					echo $cargo['Cargo']['titulo'];
				}
				?>&nbsp;</td>
				<?php if($editar || $excluir){?>
				<td width="7%" nowrap="nowrap">
					<center>
					<?php 
						if($editar){
						echo $this->Html->link(
							__(""),
							array('action' => 'editar', $cargo['Cargo']['id']),
							array('class'=>'icon-edit')
						);
						echo "&nbsp;&nbsp;";
						}
						if($excluir){
						echo $this->Form->postLink(
							__(""), 
							array('action' => 'excluir', $cargo['Cargo']['id']), 
							array('class'=>'icon-trash'),
							__(Util::MENSAGEM_DELETAR, $cargo['Cargo']['id'])
						); 
						}
					?>
					</center>
				</td>
				<?php }?>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	
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