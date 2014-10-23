<?php
	$adicionar = $this->ControleDeAcesso->validaAcessoElemento('adicionar');
	$visualizar = $this->ControleDeAcesso->validaAcessoElemento('visualizar');
	$editar = $this->ControleDeAcesso->validaAcessoElemento('editar');
	$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir');
	$imprimir = $this->ControleDeAcesso->validaAcessoElemento('imprimir');
	$cronograma = $this->ControleDeAcesso->validaAcessoElemento('cronograma');
	$visualizarUsuario = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Usuario');
?>
<script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });
  $("#index").treetable({ expandable: true});
</script>
<div class="container">

	<h4 class="title title-section">Projetos</h4>
	
	<form method="post" class="well form-search">
		<div class="list-actions row-fluid">
			<!-- Filtros -->
			<div class="list-filters pull-left">
				<div class="with-select">
					<input name="data[Projeto][busca]" placeholder="O que você procura?" type="text" id="ProjetoBusca">
					<?php $options = array('Projeto.titulo' => 'Título', 'Projeto.descricao' => 'Descricao', 'Projeto.data_inicio_previsto' => 'Data de Início', 'Pessoa.titulo'=>'Responsável', 'Setor.titulo'=>'Setor', 'Departamento.titulo'=>'Departamento');?>
					<select name="data[Projeto][buscar_em]" id="ProjetoBuscarEm">
						<option value="Projeto.titulo">Filtrar em:</option>					
						<?php foreach($options as $key => $value){?>
						<option value="<?php echo $key; ?>"><?php echo $value;?></option>
						<?php } ?>
					</select>
					<button type="submit" class="btn"><i class="icon-search fa fa-search"></i></button>
				</div>
				<div class="filters-tags">
					<?php
					if(isset($_SESSION['Search']['Projeto'])){
						if(count($_SESSION['Search']['Projeto'])>0){
						?>
						<h4 class="title">Filtrado por:</h4>
						<?php
							foreach($_SESSION['Search']['Projeto'] as $key => $temo_busca){
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
				<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->webroot; ?>Projeto/adicionar' "><i class="fa fa-plus-circle"></i>Adicionar</button>
				<?php }?>
			</div><!-- /.list-actions -->
			<!-- end Filtros -->
		</div>
	</form>
	
	
	<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index">
		<thead>
			<tr>
				<th data-class="expand">Código</th>
				<th data-class="expand">Titulo</th>
				<th data-hide="phone,tablet">Início Previsto</th>
				<th data-hide="phone,tablet">Fim Previsto</th>
				<th data-hide="phone,tablet">Conclusão</th>
				<!--th data-hide="phone,tablet">Custo</th-->
				<th data-hide="phone,tablet">Responsável</th>
				<!--th data-hide="phone,tablet" width=400><?php echo __('Atividades associadas'); ?></th-->
				<?php if($editar || $excluir || $cronograma || $imprimir){?>
				<th class="actions"><?php echo __('Ações'); ?></th>
				<?php }?>
			</tr>
		</thead>
		<tbody>
		<?php foreach($projetos as $projeto){
		?>
			<tr>
				<td nowrap="nowrap">
					<?php
						if($visualizar){
							echo $this->Html->link($projeto['processo'], array('action' => 'visualizar', $projeto['id']));
						}else{
							echo $projeto['processo'];
						}
					?>&nbsp;
				</td>
				<td>
					<?php
						if($visualizar){
							echo $this->Html->link($projeto['titulo'], array('action' => 'visualizar', $projeto['id']));
						}else{
							echo $projeto['titulo'];
						}
					?>&nbsp;
				</td>
				<td><?php echo Util::inverteData($projeto['data_inicio_previsto']); ?>&nbsp;</td>
				<td <?php if ($projeto['data_fim_previsto'] < Date('Y-m-d') && $projeto['data_conclusao'] == null) echo "style=\"color: red\"";?>><?php echo Util::inverteData($projeto['data_fim_previsto']); ?>&nbsp;</td>
				<td><?php echo Util::inverteData($projeto['data_conclusao']); ?>&nbsp;</td>
				<!--td><?php echo $projeto['moeda']; ?>&nbsp;<?php echo $projeto['custo']; ?>&nbsp;</td-->
				<td>
					<?php
						if($visualizarUsuario){
							echo $this->Html->link($projeto['nome'], array('controller' => 'usuario','action' => 'visualizar', $projeto['usuario_id']));
						}else{
							echo $projeto['nome'];
						}
					?>&nbsp;
				</td>
				<!--td class="no-padding">
					<ul class="list-inner">
					<?php
					if(isset($acoes[$projeto['id']])){
						foreach ($acoes[$projeto['id']] as $key => $value) {

							if($value["Acao"]['status'] != Util::INATIVO and $value["Acao"]['marco']=='1'){
							
						?>
							<li>
								<div class="wrapper">
								<div class="text">
									<?php
									if($value["Acao"]["status"]==5){
										echo '<span class="icon-check fa fa-check-square-o"></span>';
									}
									
									?>

									
									
									
										<acronym title='<?php echo $value["Responsavel"]["login"]." | ".$value["Acao"]["data_inicio_previsto"]." a ".$value["Acao"]["data_fim_previsto"]?>'>
										<?php echo $this->Html->link($value["Acao"]['titulo'], array('controller' => 'Acao', 'action' => 'visualizar', $value["Acao"]['id'])); ?>	
										</acronym>
										
										<?php
										if(($value["Acao"]["status"]==5)){
								
											if (strtotime(Util::inverteData($value["Acao"]["data_conclusao"]))>strtotime(Util::inverteData($value["Acao"]["data_fim_previsto"])))
											$barraProgresso="progress progress-danger progress-striped";
											else
											$barraProgresso="progress progress-success progress-striped";
										}else{
											if (time()>strtotime(Util::inverteData($value["Acao"]["data_fim_previsto"])))
											$barraProgresso="progress progress-danger progress-striped";
											elseif (time()-604800>strtotime(Util::inverteData($value["Acao"]["data_fim_previsto"])))
											$barraProgresso="progress progress-success progress-striped";
											else
											$barraProgresso="progress progress-warning progress-striped";
										}
										
										
										
										?>
									</div>									
									<div class="<?php echo $barraProgresso; ?>">
									  <div class="bar" style="width: <?php echo $value["Acao"]["andamento"];?>;"></div>
									</div>
									
								</div>
							</li>
						<?php
							}
						}
					}
					?>
					</ul>
					<div class="button-area row-fluid">
						<button class="btn btn-mini" type="button" onclick="abrirModal(<?php echo $projeto['id']; ?>)">Adicionar</button>
					</div>
				</td-->
				<?php if($editar || $excluir || $cronograma || $imprimir){?>
				<td width="7%" nowrap="nowrap" class="actions">
					<?php 
						if($editar){
						echo $this->Html->link(
							__(""),
							array('action' => 'editar', $projeto['id']),
							array('class'=>'icon-edit fa fa-edit')
						);
						}
					?>
					<?php if($cronograma){?>
					<a href="javascript:abrirCronograma(<?php echo $projeto['id']; ?>)" title="Cronograma" class="icon-time fa fa-clock-o"></a>
					<?php
					}
					if($excluir){
						echo $this->Form->postLink(
							__(""), 
							array('action' => 'excluir', $projeto['id']), 
							array('class'=>'icon-trash fa fa-trash-o'),
							__("Você realmente deseja deletar o registro # {$projeto['id']}? Todas as ações, tarefas e posts relacionados ao projeto também serão deletadas. Deseja continuar?", $projeto['id'])
						); 
					}
					?>
						<?php
						if($imprimir){
						echo "&nbsp;";
						echo $this->Html->link(
							__(""),
							array('action' => 'imprimir', $projeto['id']),
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
	
<div id="dialog" title="Cadastrar Ação" style="display: none">
</div>
<div id="cronograma" title="Cronograma" style="display: none">
	
</div>

<script type="text/javascript" src="<?php echo $this->base?>/js/libs/highcharts.js"></script>
<script type="text/javascript" src="<?php echo $this->base?>/js/libs/jquery.fn.gantt.js"></script>
<script>
function abrirModal(idProjeto){
	var action = "<?php echo $this->webroot;?>Acao/ajaxAdicionarComProjeto";
	$.get(
		action,
		{id_projeto: idProjeto},
		function(data){
			$("#dialog").html(data);
			$("#dialog").css("display", "block");
		    $("#dialog").dialog({
		    	height: 400,
		    	width: 350,
		    	modal: true
		    });
		    $("#salvar").click(function(){
				var action = "<?php echo $this->webroot; ?>Acao/ajaxAdicionarComProjeto/" + idProjeto;
				$.post(
					action,
					$("#AcaoAjaxAdicionarComProjetoForm").serialize(),
					function(data){
						alert(data);
						$(window.document.location).attr('href',"<?php echo $this->webroot; ?>Projeto");
					}
				);
			});
		}
	);
	
}

function abrirCronograma(idProjeto){
	var action = "<?php echo $this->webroot;?>Projeto/cronograma";
	$.get(
		action,
		{projeto_id: idProjeto},
		function(data){
			$("#cronograma").html(data);
			$("#formCronograma").submit(function(){
				$.post("<?php echo $this->webroot;?>Projeto/salvar_datas_cronograma", $(this).serialize(), function(resposta){
					alert(resposta.msg);
				}, "json");
				return false;
			});			
			$("#cronograma").css("display", "block");
		    $("#cronograma").dialog({
		    	height: 400,
		    	width: 1000,
		    	modal: true
		    });

		   
		}
	);
}
function abrirPizza(idProjeto){
	
	var action = "<?php echo $this->webroot;?>Projeto/exibirGrafico";
	$.get(
		action,
		{projeto_id: idProjeto},
		function(data){
			$("#cronograma").dialog('close');
			var html = "<div id='chart' class='span5' style='height:300px;'></div><a href='javascript:abrirCronograma(" + idProjeto + ")' class='btn'>Voltar</a>";
			$("#cronograma").html(html);
			
			var options = {
		        chart: {
		            plotBackgroundColor: null,
		            plotBorderWidth: null,
		            plotShadow: false,
		            renderTo: 'chart'
		        },
		        title: {
		            text: 'Gráfico de torta'
		        },
		        tooltip: {
		    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		        },
		        plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: 'pointer',
		                dataLabels: {
		                    enabled: true,
		                    color: '#000000',
		                    connectorColor: '#000000',
		                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
		                }
		            }
		        },
		        series: []
		    }
		    
			options.series.push(data);
			
		    var chart = new Highcharts.Chart(options);
		    $("#cronograma").dialog({
		    	height: 400,
		    	width: 600,
		    	modal: true
		    });
		},
		'json'
	);
}

function abrirGantt(idProjeto){
	var action = "<?php echo $this->webroot;?>Projeto/exibirGantt/"+idProjeto;
	var html = "<div id='gantt' class='ui-helper-reset'></div><a href='javascript:abrirCronograma(" + idProjeto + ")' class='btn' style='margin-top: 10px;'>Voltar</a>";
	$("#cronograma").html(html);
	$("#cronograma").dialog({
    	height: 400,
    	width: 831,
    	modal: true
    });	
	$("#gantt").gantt({source: action, navigate: 'scroll', scale: 'days', maxScale: 'months', minScale: 'days'});
	
	/*$.get(
		action,
		{projeto_id: idProjeto},
		function(data){
			$("#cronograma").dialog('close');
			var html = "<div id='gantt_here' style='width:770px; height:330px;'></div><a href='javascript:abrirCronograma(" + idProjeto + ")' class='btn'>Voltar</a>";
			$("#cronograma").html(html);
			var tasks = data;
			gantt.config.scale_unit = "month";
			gantt.config.columns = [
				{name:"text",       label:"Task name",  width:"*", tree:true, width:'*' },
			    {name:"start_date", label:"Start time", align: "center" },
			    {name:"duration",   label:"Duration",   align: "center" }
			];
	        gantt.init("gantt_here");
	        gantt.parse (tasks);
	       var dados = data;
	       
			$("#cronograma").dialog({
		    	height: 400,
		    	width: 800,
		    	modal: true
		    });
		}
	);*/
}
</script>
