<?php
	$adicionar = $this->ControleDeAcesso->validaAcessoElemento('adicionar', 'Marcador');
	$visualizar = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Marcador');
	$editar = $this->ControleDeAcesso->validaAcessoElemento('editar', 'Marcador');
	$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir', 'Marcador');
	$visualizarMedida = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Medida');
?>
<script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });
  $("#index").treetable({ expandable: true});
</script>
<div class="container">
	<br />
	<h4>Marcador</h4>
	<form method="post" class="well form-search">
		<div class="list-actions row-fluid">
			<!-- Filtros -->
			<div class="list-filters pull-left">
				<div class="with-select">
					<input name="data[Marcador][busca]" placeholder="O que você procura?" type="text" id="MarcadorBusca">
					<?php $options = array('titulo' => 'Título');?>
					<select name="data[Marcador][buscar_em]" id="MarcadorBuscarEm">
						<option value="titulo">Filtrar em:</option>					
						<?php foreach($options as $key => $value){?>
						<option value="<?php echo $key; ?>"><?php echo $value;?></option>
						<?php } ?>
					</select>
					<button type="submit" class="btn"><i class="icon-search fa fa-search"></i></button>
				</div>
				<div class="filters-tags">
					<?php
					if(isset($_SESSION['Search']['Marcador'])){
						if(count($_SESSION['Search']['Marcador'])>0){
						?>
						<h4 class="title">Filtrado por:</h4>
						<?php
							foreach($_SESSION['Search']['Marcador'] as $key => $temo_busca){
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
				<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->webroot; ?>Marcador/adicionar' "><i class="fa fa-plus-circle"></i>Adicionar</button>
				<?php }?>
			</div><!-- /.list-actions -->
			<!-- end Filtros -->
		</div>
	</form>
	
	<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index">
		<thead>
			<tr>
				<th data-class="phone,tablet"><?php echo $this->Paginator->sort('Marcador.titulo', 'Título'); ?></th>
				<?php if($editar || $excluir){?>
				<th data-hide="phone,tablet"><?php echo __('Ações Associadas'); ?></th>
				<?php }?>
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach($marcador as $marcador){?>
			<tr>
			
				<td><?php
						if($visualizar){
							echo $this->Html->link($marcador['Marcador']['titulo'], array('action' => 'visualizar', $marcador['Marcador']['id']));
						}else{
							echo $marcador['Marcador']['titulo'];
						} 
					?>&nbsp;</td>
				<td class="no-padding">
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
											if($visualizarMedida){
												echo $this->Html->link($objetivo["Objetivo"]['titulo'], array('controller' => 'Medida', 'action' => 'visualizar', $objetivo["Objetivo"]['id']));
											}else{
												echo $objetivo["Objetivo"]['titulo'];
											}
											?>	
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
				<?php if($editar || $excluir){?>
				<td width="7%" nowrap="nowrap">
					<center>
					<?php 
						if($editar){
							echo $this->Html->link(
								__(""),
								array('action' => 'editar', $marcador['Marcador']['id']),
								array('class'=>'icon-edit')
							);
						echo "&nbsp;&nbsp;";
						}
						if($excluir){
							echo $this->Form->postLink(
								__(""), 
								array('action' => 'excluir', $marcador['Marcador']['id']), 
								array('class'=>'icon-trash'),
								__(Util::MENSAGEM_DELETAR, $marcador['Marcador']['id'])
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