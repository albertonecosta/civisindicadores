<?php
	$adicionar = $this->ControleDeAcesso->validaAcessoElemento('adicionar', 'Procedimento');
	$visualizar = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Procedimento');
	$editar = $this->ControleDeAcesso->validaAcessoElemento('editar', 'Procedimento');
	$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir', 'Procedimento');
	$imprimir = $this->ControleDeAcesso->validaAcessoElemento('imprimir', 'Procedimento');
	$visualizarUsuario = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Usuario');
?>
<script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });
  $("#index").treetable({ expandable: true});
</script>
<div class="container">
	<br />
	<h4>Procedimentos</h4>
	<form method="post" class="well form-search">
		<div class="list-actions row-fluid">
			<!-- Filtros -->
			<div class="list-filters pull-left">
				<div class="with-select">
					<input name="data[Procedimento][busca]" placeholder="O que você procura?" type="text" id="ProcedimentoBusca">
					<?php $options = array('titulo' => 'Título');?>
					<select name="data[Procedimento][buscar_em]" id="ProcedimentoBuscarEm">
						<option value="titulo">Filtrar em:</option>					
						<?php foreach($options as $key => $value){?>
						<option value="<?php echo $key; ?>"><?php echo $value;?></option>
						<?php } ?>
					</select>
					<button type="submit" class="btn"><i class="icon-search fa fa-search"></i></button>
				</div>
				<div class="filters-tags">
					<?php
					if(isset($_SESSION['Search']['Procedimento'])){
						if(count($_SESSION['Search']['Procedimento'])>0){
						?>
						<h4 class="title">Filtrado por:</h4>
						<?php
							foreach($_SESSION['Search']['Procedimento'] as $key => $temo_busca){
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
				<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->webroot; ?>Procedimento/adicionar' "><i class="fa fa-plus-circle"></i>Adicionar</button>
				<?php }?>
			</div><!-- /.list-actions -->
			<!-- end Filtros -->
		</div>
	</form>
	
	<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index">
		<thead>
			<tr>
				<th data-class="expand"><?php echo $this->Paginator->sort('titulo'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('passos'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('resultado_esperado'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Patrocinador.Pessoa.titulo', 'Patrocinador'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('certificado'); ?></th>
				<th><center><?php echo __('Ações'); ?></center></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($procedimento as $procedimento){?>
			<tr>
				<td><?php echo $this->Html->link($procedimento['Procedimento']['titulo'], array('action' => 'visualizar', $procedimento['Procedimento']['id'])); ?>&nbsp;</td>
				<td><?php echo $procedimento['Procedimento']['passos']; ?></td>
				<td><?php echo $procedimento['Procedimento']['resultado_esperado']; ?></td>
				<td><?php echo $this->Html->link($procedimento['Patrocinador']['Pessoa']['titulo'], array('controller' => 'Usuario', 'action' => 'visualizar',$procedimento['Patrocinador']['id'])); ?></td>
				<td><?php echo $procedimento['Procedimento']['certificado'] == Util::ATIVO? "Sim" : "Não" ; ?></td>
				<td width="7%" nowrap="nowrap">
					<center>
					<?php 
						echo $this->Html->link(
							__(""),
							array('action' => 'editar', $procedimento['Procedimento']['id']),
							array('class'=>'icon-edit')
						);
						echo "&nbsp;&nbsp;";
						echo $this->Html->link(
							__(""),
							array('action' => 'imprimir', $procedimento['Procedimento']['id']),
							array('class'=>'icon-print')
						);
						echo "&nbsp;&nbsp;";
						echo $this->Form->postLink(
							__(""), 
							array('action' => 'excluir', $procedimento['Procedimento']['id']), 
							array('class'=>'icon-trash'),
							__(Util::MENSAGEM_DELETAR, $procedimento['Procedimento']['id'])
						); 
					?>
					</center>
				</td>
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