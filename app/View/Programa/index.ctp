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
				<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->webroot; ?>Programa/adicionar' "><i class="fa fa-plus-circle"></i>Adicionar</button>
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
				
			</tr>
		</thead>
		<tbody>
		<?php foreach($programas as $programa){
		?>
			<tr>
				<td><?php echo $this->Html->link($programa['titulo'], array('action' => 'visualizar', $programa['id'])); ?>&nbsp;</td>
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
										<?php echo $this->Html->link($value["Projeto"]['titulo'], array('controller' => 'Projeto', 'action' => 'visualizar', $value["Projeto"]['id'])); ?>	
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
				<td width="7%" nowrap="nowrap" class="actions">
					<?php 
						echo $this->Html->link(
							__(""),
							array('action' => 'editar', $programa['id']),
							array('class'=>'icon-edit fa fa-edit')
						);
					?>
					
					<?php
						echo $this->Form->postLink(
							__(""), 
							array('action' => 'excluir', $programa['id']), 
							array('class'=>'icon-trash fa fa-trash-o'),
							__("Você realmente deseja deletar o registro # {$programa['id']}? Todas as ações, tarefas e posts relacionados ao programa também serão deletadas. Deseja continuar?", $programa['id'])
						); 
					?>
						<?php
						echo "&nbsp;";
						echo $this->Html->link(
							__(""),
							array('action' => 'imprimir', $programa['id']),
							array('class'=>'icon-print fa fa-print')
						);
						echo "&nbsp;";
					?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	
	<?php echo $this->element('paginacao'); ?>
	
