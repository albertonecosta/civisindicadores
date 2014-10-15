<script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });
  $("#index").treetable({ expandable: true});
</script>
<div class="container">

	<h4 class="title title-section">Anomalias</h4>
	<form method="post" class="well form-search">
		<div class="list-actions row-fluid">
			<!-- Filtros -->
			<div class="list-filters pull-left">
				<div class="with-select">
					<input name="data[Anomalia][busca]" placeholder="O que você procura?" type="text" id="AnomaliaBusca">
					<?php $options = array('identificacao_problema' => 'Identificação do problema','estratificacao_problema' => 'Estratificação do problema','data' => 'Data');?>
					<select name="data[Anomalia][buscar_em]" id="AnomaliaBuscarEm">
						<option value="titulo">Filtrar em:</option>					
						<?php foreach($options as $key => $value){?>
						<option value="<?php echo $key; ?>"><?php echo $value;?></option>
						<?php } ?>
					</select>
					<button type="submit" class="btn"><i class="icon-search fa fa-search"></i></button>
				</div>
				<div class="filters-tags">
					<?php
					if(isset($_SESSION['Search']['Anomalia'])){
						if(count($_SESSION['Search']['Anomalia'])>0){
						?>
						<h4 class="title">Filtrado por:</h4>
						<?php
							foreach($_SESSION['Search']['Anomalia'] as $key => $temo_busca){
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
				<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->webroot; ?>Anomalia/adicionar' "><i class="fa fa-plus-circle"></i>Adicionar</button>
			</div><!-- /.list-actions -->
			<!-- end Filtros -->
		</div>
	</form>
	

	
	<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index">
		<thead>
			<tr>
				<th data-class="expand"><?php echo $this->Paginator->sort('identificacao_problema', 'Identificação do problema'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('estratificacao_problema', 'Estratificação do problema'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('data'); ?></th>
				<th data-hide="phone,tablet"><?php echo __('Ações associadas'); ?></th>
				<th><center><?php echo __('Ações'); ?></center></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($anomalia as $anomalia){?>
			<tr>
				<td><?php echo $anomalia['Anomalia']['identificacao_problema']; ?>&nbsp;</td>
				<td><?php echo $anomalia['Anomalia']['estratificacao_problema']; ?>&nbsp;</td>
				<td><?php echo $anomalia['Anomalia']['data']; ?>&nbsp;</td>
				<td class="no-padding">
					<ul class="list-inner">
					<?php
					if(isset($anomalia['Acao'])){
					
						foreach ($anomalia['Acao'] as $key => $value) {
						
						?>
							<li>
								<div class="wrapper">
								<acronym title='<?php echo @$value["Responsavel"]["login"]." | ".$value["data_inicio_previsto"]." a ".$value["data_fim_previsto"]?>'>
								<?php echo $this->Html->link($value['titulo'], array('controller' => 'Acao', 'action' => 'visualizar', $value['id'])); ?>
								
								<?php
									if (time()>strtotime(Util::inverteData($value["data_fim_previsto"])))
									$barraProgresso="progress progress-danger progress-striped";
									elseif (time()-604800>strtotime(Util::inverteData($value["data_fim_previsto"])))
									$barraProgresso="progress progress-warning progress-striped";
									else
									$barraProgresso="progress progress-success progress-striped";
									?>
									
									
									<div class="<?php echo $barraProgresso; ?>">
									  <div class="bar" style="width: <?php echo $value["andamento"];?>;"></div>
									</div></acronym>
								</div>
							</li>
						<?php
						}
					}
					?>
					</ul>
					<div class="button-area row-fluid">
						<button class="btn btn-mini" type="button" onclick="abrirModal(<?php echo $anomalia['Anomalia']['id']; ?>)">Adicionar</button>
					</div>
					
					
				</td>
				<td width="7%" nowrap="nowrap">
					<center>
					<a href="javascript:abrirPainelAnomalia(<?php echo $anomalia['Anomalia']['id']; ?>)"><i class="icon-fullscreen" title="Painel de Anomalia"></i></a>
					<?php 
						echo "&nbsp;";
						echo $this->Html->link(
							__(""),
							array('action' => 'editar', $anomalia['Anomalia']['id']),
							array('class'=>'icon-edit')
						);
						echo "&nbsp;";
						echo $this->Form->postLink(
							__(""), 
							array('action' => 'excluir', $anomalia['Anomalia']['id']), 
							array('class'=>'icon-trash'),
							__(Util::MENSAGEM_DELETAR, $anomalia['Anomalia']['id'])
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
<div id="dialog" title="Cadastrar Ação" style="display: none">
</div>
<div id="painelAnomalias" title="Painel de Anomalias" style="display: none">
</div>
<script>
function abrirModal(idAnomalia){
	var action = "<?php echo $this->webroot;?>Acao/ajaxAdicionar/" + idAnomalia;
	$.get(
		action,
		{},
		function(data){
			$("#dialog").html(data);
			$("#dialog").css("display", "block");
		    $("#dialog").dialog({
		    	height: 400,
		    	width: 350,
		    	modal: true
		    });
		    $("#salvar").click(function(){
				var action = <?php echo $this->webroot; ?> + "Acao/ajaxAdicionar/" + idAnomalia;
				$.post(
					action,
					$("#AcaoAjaxAdicionarForm").serialize(),
					function(data){
						alert(data);
						$(window.document.location).attr('href',"<?php echo $this->webroot; ?>Anomalia");
					}
				);
			});
		}
	);
	
}
function abrirPainelAnomalia(idAnomalia){
	var action = "<?php echo $this->webroot;?>Anomalia/ajaxPainelAnomalia/" + idAnomalia;
	$.get(
		action,
		{},
		function(data){
			$("#painelAnomalias").html(data);
			$("#painelAnomalias").css("display", "block");
		    $("#painelAnomalias").dialog({
		    	height: 500,
		    	width: 800,
		    	modal: true
		    });
		}
	);	
}
</script>