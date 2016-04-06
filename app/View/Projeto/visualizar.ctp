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
$editar = $this->ControleDeAcesso->validaAcessoElemento('editar');
$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir');
$visualizarUsuario = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Usuario');
$visualizarPrograma = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Programa');
$visualizarAtividade = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Atividade');
$adicionarAtividade = $this->ControleDeAcesso->validaAcessoElemento('adicionar', 'Atividade');
?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(document).ready(
	function() {
		$("#sortme").sortable({
			update : function () {
			serial = $('#sortme').sortable('serialize');
			$.ajax({
				url: "http://localhost:8181/civisindicadores/Projeto/atividade/",
				type: "post",
				data: serial,
				error: function(){
					alert("theres an error with AJAX");
				}
			});
		}
	});
}
);
</script>
<div class="container">
	<legend>Visualizar Projeto
		<div class="list-actions-buttons pull-right">
		<?php
		if($editar){
		echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $projeto['Projeto']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
		echo "&nbsp;&nbsp;";
		}
		if($excluir){
		echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $projeto['Projeto']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $projetoa['Projeto']['id'])
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
						<td><?php echo h($projeto['Projeto']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Número do Processo'); ?></strong></td>
						<td><?php echo h($projeto['Projeto']['processo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Data de Início'); ?></strong></td>
						<td><?php echo h($projeto['Projeto']['data_inicio_previsto']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Data de Fim'); ?></strong></td>
						<td><?php echo h($projeto['Projeto']['data_fim_previsto']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Custo'); ?></strong></td>
						<td><?php echo h($projeto['Projeto']['custo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Gasto'); ?></strong></td>
						<td><?php echo h($projeto['Projeto']['gasto']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Descrição'); ?></strong></td>
						<td><?php echo ($projeto['Projeto']['descricao']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Motivações'); ?></strong></td>
						<td><?php echo ($projeto['Projeto']['motivacao']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Riscos'); ?></strong></td>
						<td><?php echo ($projeto['Projeto']['risco']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Resultados'); ?></strong></td>
						<td><?php echo ($projeto['Projeto']['resultado']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Programa'); ?></strong></td>
						<td>
							<?php
								if($visualizarPrograma){
									echo $this->Html->link($projeto['Programa']['titulo'], array('controller' => 'Programa','action' => 'visualizar', $projeto['Programa']['titulo']));
								}else{
									echo $projeto['Programa']['titulo'];
								}
							?>
						</td>
					</tr>

					<tr>
						<td><strong><?php echo __('Responsável'); ?></strong></td>
						<td>
							<?php
								if($visualizarUsuario){
									echo $this->Html->link($projeto['Responsavel']['Pessoa']['titulo'], array('controller' => 'Usuario','action' => 'visualizar', $projeto['Responsavel']['id']));
								}else{
									echo $projeto['Responsavel']['Pessoa']['titulo'];
								}
							?>
						</td>
					</tr>
					<tr>
						<td><strong><?php echo __('Objetivos'); ?></strong></td>
						<td><ul><?php foreach($objetivos as $objetivo){echo "<li>$objetivo</li>";} ?></ul></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Patrocinadores'); ?></strong></td>
						<td><ul><?php foreach($patrocinadores as $patrocinador){echo "<li>$patrocinador</li>";} ?></ul></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Concluido?'); ?></strong></td>
						<td><?php 
						switch ($projeto['Projeto']['concluido']){
							case (Util::ATIVO):
								echo "Sim";
								break;
							case (Util::INATIVO):
								echo "Não";
								break;
						
							default:
								break;
					 }
						
						?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Data de conclusão'); ?></strong></td>
						<td><?php echo h($projeto['Projeto']['data_conclusao']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Atividades Associadas'); ?></strong></td>
						<td class="no-padding">
							<ul class="list-inner" id="sortme">
							
							<?php
							/**
							 * 
							 * Exibição das ações do projeto atual
							 * 							 * 
							 */
							if(isset($atividades)){
								foreach ($atividades as $key => $value) {
								?>
								
									<li id="menu_<?php echo $value['id']?>">
									<div class="wrapper">
									<div class="text">
									<abbr style='font-size: 14px;' title='<?php echo $value["nome"]." | ".Util::inverteData($value["data_inicio_previsto"])." a ".Util::inverteData($value["data_fim_previsto"])?>'>
										<?php
											if($visualizarAtividade){
												echo $this->Html->link($value['titulo'], array('controller' => 'Atividade', 'action' => 'visualizar', $value['id']));
											}else{
												echo "<a>{$value['titulo']}</a>";
											}
										?>
									</abbr>
																		
									<?php 
									
									// Habilitando o icone para ações concluidas
									if($value["status"]==5){
										echo '<span class="icon-check fa fa-check-square-o"></span>';
									}
									$qtdAcoes++;
									
										if(($value["status"]==5)){

											if (strtotime(($value["data_conclusao"]))>strtotime(($value["data_fim_previsto"])))
											$barraProgresso="progress progress-danger progress-striped";
											else
											$barraProgresso="progress progress-success progress-striped";
											$qtdAcoesConcluidas++;
										}else{
											if (time()>strtotime(($value["data_fim_previsto"])))
											$barraProgresso="progress progress-danger progress-striped";
											elseif (time()-604800>strtotime(($value["data_fim_previsto"])))
											$barraProgresso="progress progress-success progress-striped";
											else
											$barraProgresso="progress progress-warning progress-striped";
											
										}
										
										$ondeEsta=substr($value["andamento"],0,strpos($value["andamento"],"%"));
										
										if (time()>strtotime($value["data_fim_previsto"])){
											$ondeDeveriaHoje=100;	
										}elseif(time()<strtotime($value["data_inicio_previsto"])){
											$ondeDeveriaHoje=0;
										}else{
											$ondeDeveriaHoje=time()-strtotime($value["data_inicio_previsto"]);
											$diferenca = (strtotime($value["data_fim_previsto"])-strtotime($value["data_inicio_previsto"]));
											$ondeDeveriaHoje = ($ondeDeveriaHoje/$diferenca)*100;
										}
										echo $ondeDeveriaHoje;
										
										$ondeDeveriaTotal+=$ondeDeveriaHoje;
										$ondeEstaTotal+=$ondeEsta;
									
										?>
									</div>									
									<div class="<?php echo $barraProgresso; ?>">
									  <div class="bar" style="width: <?php echo $value["andamento"];?>;"></div>
									</div>
									</div>
									</li>
								<?php
								
								
								}
								//Calculo para exibição nos indicadores
								 $ondeDeveriaMedia = ($ondeDeveriaTotal/$qtdAcoes);
								
								 $ondeEstaMedia = ($ondeEstaTotal/$qtdAcoes);
								
									 $vp = $projeto['Projeto']['custo']*($ondeDeveriaMedia/100);
									
									 $va = $projeto['Projeto']['custo']*($ondeEstaMedia/100);
									
									
									
									$idc= $va/$projeto['Projeto']['gasto'];
									$idp= $va/$vp;
								
							}
							?>
							<div class="button-area row-fluid">
								<?php if($adicionarAtividade){?>
								<button class="btn btn-mini"  type="button" onclick="abrirModalAtividade(<?php echo $projeto['Projeto']['id']; ?>)">Adicionar</button>
								<?php }?>
							</div>
							</ul>
						&nbsp;
						</td>
					</tr>
					<tr>
						<td><strong><?php echo __('Valor Planejado'); ?></strong><abbr title='Isso mostra a você quanto ($) seu projeto deveria ter utilizado de recurso.'><span class="fa fa-question-circle fa-1g"></span></abbr></td>
						<td>$ <?php echo number_format($vp,2,',','.');?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Valor Agregado'); ?></strong><abbr title='Isso mostra a você quanto($) seu projeto realmente agregou'><span class="fa fa-question-circle fa-1g"></span></abbr></td>
						<td>$ <?php echo number_format($va,2,',','.'); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('IDP'); ?><abbr title='Índice de desempenho de custos - Se IDP maior que 1 (um) você está adiantado, se menor que 1 você está atrasado.'><span class="fa fa-question-circle fa-1g"></span></abbr></strong></td>
						<td><?php echo number_format($idp,2,',','.') ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('IDC'); ?><abbr title=' Índice de desempenho de prazos - Se IDC maior que 1 (um) você está dentro do orçamento, se menor que 1 você está fora do orçamento'><span class="fa fa-question-circle fa-1g"></span></abbr></strong></td>
						<td><?php echo number_format($idc,2,',','.') ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('VPR'); ?><abbr title='Variação dos prazos -  Se o resultado for negativo, significa que houve atraso em relação ao cronograma, e quando positivo, o cronograma está adiantado, e se =1, o projeto está sendo desenvolvido dentro do prazo.'><span class="fa fa-question-circle fa-1g"></span></abbr></strong></td>
						<td><?php echo number_format($va-$vp,2,',','.'); ?></td>
					</tr>
				</tbody>				
			</table>			
		</div>
	</div>
</div>

<div id="dialog" title="Cadastrar Ação" style="display: none">
</div>
	<?php
		echo $this->Html->script(array('highcharts.js','modules/exporting.js', 'highcharts-more.js'));
	?>



<script>
	
$(function () {
	
    $('#container3').highcharts({
	
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: '#f5f5f5',
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
			   spacingTop:0,
			   spacingLeft:0,
			   spacingRight:0,
			   spacingBottom:0,
			   
	        plotShadow: false
	    },
	     credits: {
      enabled: false
  },
	    title: {
	        text: ''
	    },
	    
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       plotOptions: {
            series: {
                dataLabels: {
                    
                    enabled: false
                }
            }
        },
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: 100,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 2,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 1,
	        tickPosition: 'inside',
	        tickLength: 4,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: ''
	        },
	        plotBands: [{
	            from: 90,
	            to: 100,
	            color: '#55BF3B' // green
	        }, {
	            from: 70,
	            to: 90,
	            color: '#DDDF0D' // yellow
	        }, {
	            from: 0,
	            to: 70,
	            color: '#DF5353' // red
	        }]        
	    },
		
	    series: [{
	        name: 'Percentual',
	        data: [<?php echo $ondeEstaMedia?>],
	        
	    }], navigation: {
            buttonOptions: {
                enabled: false
            }
        }
	
	}, 
	// Add some life
	function (chart) {
		
	});

	$('#container4').highcharts({
				
		    chart: {
		        type: 'gauge',
		        plotBackgroundColor: '#f5f5f5',
		        plotBackgroundImage: null,
		        plotBorderWidth: 0,
				   spacingTop:0,
				   spacingLeft:0,
				   spacingRight:0,
				   spacingBottom:0,
				   
		        plotShadow: false
		    },
		     credits: {
	      enabled: false
	  },
		    title: {
		        text: ''
		    },
		    
		    pane: {
		        startAngle: -150,
		        endAngle: 150,
		        background: [{
		            backgroundColor: {
		                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                stops: [
		                    [0, '#FFF'],
		                    [1, '#333']
		                ]
		            },
		            borderWidth: 0,
		            outerRadius: '109%'
		        }, {
		            backgroundColor: {
		                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                stops: [
		                    [0, '#333'],
		                    [1, '#FFF']
		                ]
		            },
		            borderWidth: 1,
		            outerRadius: '107%'
		        }, {
		            // default background
		        }, {
		            backgroundColor: '#DDD',
		            borderWidth: 0,
		            outerRadius: '105%',
		            innerRadius: '103%'
		        }]
		    },
		       
		    // the value axis
		    yAxis: {
		        min: 0,
		        max: 200,
		        
		        minorTickInterval: 'auto',
		        minorTickWidth: 1,
		        minorTickLength: 10,
		        minorTickPosition: 'inside',
		        minorTickColor: '#666',
		
		        tickPixelInterval: 30,
		        tickWidth: 2,
		        tickPosition: 'inside',
		        tickLength: 10,
		        tickColor: '#666',
		        labels: {
		            step: 2,
		            rotation: 'auto'
		        },
		        title: {
		            text: ''
		        },
		        plotBands: [{
		            from: 0,
		            to: 120,
		            color: '#55BF3B' // green
		        }, {
		            from: 120,
		            to: 160,
		            color: '#DDDF0D' // yellow
		        }, {
		            from: 160,
		            to: 200,
		            color: '#DF5353' // red
		        }]        
		    },
		
		    series: [{
		        name: '',
		        data: [80],
		        remove: true
		    }], navigation: {
	            buttonOptions: {
	                enabled: false
	            }
	        }
		
		}, 
		// Add some life
		function (chart) {
			
		});


			      

});	

</script>
	<div class="row-fluid application-graphs">
			<div class="span6">
				<div class="box-graph-w-numbers">
					<div class="graph-number"><?php echo number_format(($ondeEstaTotal/$qtdAcoes),2,',','.'); ?><sup>%</sup></div>
					<div class="graph-number-desc">Percentual real de realização do projeto
						<!-- <span class="desc-arrow negative">-5% <span class="fa fa-caret-down"></span></span>-->
					</div>
					<div id="container3" class="graph" ></div>
					<!-- <div class="graph-number-desc">Indicador da performance do projeto
						<span class="desc-arrow positive">+25% <span class="fa fa-caret-up"></span></span>
					</div>
					 -->	
				</div><!-- /.box-graph-w-numbers -->
			</div><!-- /.span6 -->
			<div class="span6">
				<div class="box-graph-w-numbers">
					<div class="graph-number"><?php echo number_format(($qtdAcoesConcluidas/$qtdAcoes)*100,2,',','.'); ?><sup>%</sup></div>
					<div class="graph-number-desc">Percentual de ações concluídas do projeto
						<!--  <span class="desc-arrow negative">-8% <span class="fa fa-caret-down"></span></span>-->
					</div>
					<div id="container4" class="graph"></div>
					 <!--
					<div class="graph-number-desc">Andamento médio de suas ações
						<span class="desc-arrow positive">+50% <span class="fa fa-caret-up"></span></span>
					</div>
					 -->
				</div><!-- /.box-graph-w-numbers -->
			</div><!-- /.span6 -->
		</div><!-- /.row-fluid -->
		
		<div class="tab-pane" id="tab2">
			<div id='indicadores<?php echo $projeto['Projeto']['id'];?>'><center><img src="<?php echo $this->webroot."img".DS."ajax-loader.gif" ?>" />Carregando indicadores...</center></div>
		</div>
	
			<div id="dialog" title="Cadastro de Atividades" style="display: none">
</div>
<div id="dialog1" title="Painel de Resumo" style="display: none">
</div>
<div id="loading" style="display: none">
	<div class="row-fluid">
		<center><img src="<?php echo $this->webroot."img".DS."ajax-loader.gif" ?>" /></center>
	</div>
	<div class="row-fluid">
		<center>Carregando</center>
	</div>	
</div>
<div id="painelAnomalias" title="Painel de Anomalias" style="display: none">
</div>

<script>
function exibirIndicadores(projetoId){
	var div = "#indicadores" + projetoId;

	$.get(
        "<?php echo $this->webroot;?>MapaEstrategico/indicadoresPorProjeto/"+projetoId,
        null,
        function(data) {
			$(div).html(data);
        	var exibir_valores = "#exibir_valores_" + projetoId;
        	$(exibir_valores).click(function(){
        		var valores = "#valores_" + projetoId;
        		$(valores).slideToggle("slow");
        		
        		var atualizar_valores = "#atualizar_valores_" + projetoId;
        		$(atualizar_valores).click(function(e){
        			e.preventDefault();
        			var form = "#MapaEstrategicoSalvarForm" + projetoId;
        			var action = $(form).attr("action");
        			$.post(
        				action,
        				$(form).serialize(),
        				function(data){
        					alert(data);
        				}
        			);
        		});	
        	});
        }
    );
}

exibirIndicadores(<?php echo $projeto['Projeto']['id'];?>);				
								
function abrirModalAtividade(idProjeto){
	var action = "<?php echo $this->webroot;?>Atividade/ajaxAdicionarComProjeto";
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
				var action = <?php echo $this->webroot; ?> + "Atividade/ajaxAdicionarComProjeto/" + idProjeto;
				$.post(
					action,
					$("#AtividadeAjaxAdicionarComProjetoForm").serialize(),
					function(data){
						alert(data);
						var url = <?php echo $this->webroot; ?> + "Projeto/" + "visualizar/" + idProjeto;
						$(window.document.location).attr('href',url);
					}
				);
			});
		}
	);
	
}
function resumoIndicador(idIndicador, mes, comDialog){
		//true = abrir em modal diferentel, false = abrir no mesmo modal
		//var comDialog = false;
		var action = "<?php echo $this->webroot;?>MapaEstrategico/ajaxPainelResumoApenas";
		$.post(
			action,
			{indicador_id: idIndicador, mes: mes},
			function(data){
				if(comDialog == true){
					$("#dialog1").html(data);				
					$("#dialog1").dialog({
						height: 400,
				    	width: 350,
				    	modal: true
					});
				}else{
					$("#dialog").html(data);				
					$("#dialog").dialog({
						height: 400,
				    	width: 350,
				    	modal: true
					});
				}
				
			}
		);
	}
	
	

	function exibirGrafico(indicadorId){
	
		var action = "<?php echo $this->webroot;?>MapaEstrategico/ajaxGrafico";
		var form_grafico = "#form_grafico_" + indicadorId;
		$.post(
			action,
			$(form_grafico).serialize(),
			function(data){
				
				var grafico = "#grafico_" + indicadorId;
				var mostrarGrafico = "exibir_grafico_" + indicadorId;			
				var options = {
					chart: {
						'type' : 'bar',
						'renderTo': mostrarGrafico
					},
					title: {
						'text' : 'Gráfico Comparativo'
					},
					xAxis: {
			            'categories': ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']
			        },
			        yAxis: {
			            'title': {
			                'text': 'Valores'
			            }
			        },
			        series : []
				}
				$.each(data, function(key, value){
					options.series.push(value);
				});
				console.log(options);
				var chart = new Highcharts.Chart(options);
				$(grafico).slideToggle("slow");
			},
			"json"
		);
	}

	function abrirModal(projetoId, indicadorId, mes, comDialog){
		var action = "<?php echo $this->webroot;?>MapaEstrategico/ajaxPainelResumo";
		$.post(
			action,
			{projeto_id: projetoId, indicador_id: indicadorId, mes: mes},
			function(data){
				$("#dialog").html(data);
				if(comDialog == true){
					$("#dialog").dialog({
						height: 400,
				    	width: 350,
				    	modal: true
					});
				}
				
			}
		);
	}

	function formAnomalia(idObjetivo, idIndicador, mes){
		var action = "<?php echo $this->webroot;?>Anomalia/ajaxAdicionar";
		$.get(
			action,
			{idObjetivo: idObjetivo, idIndicador: idIndicador, mes: mes},
			function(data){
				$("#dialog").html("");
				$("#dialog").html(data);
				$("#salvar").click(function(){

					$.post(
						"<?php echo $this->webroot; ?>Anomalia/ajaxAdicionar", $("#AnomaliaAjaxAdicionarForm").serialize() + "&indicador=" + $("#AnomaliaIndicadorId option:selected").val(), function(data){
							alert(data);
							if(data == "<?php echo Util::REGISTRO_ADICIONADO_SUCESSO; ?>"){
								abrirModal(idObjetivo, idIndicador, mes, false);
							}
						}
					);

				});
			}
		);
	}
	function habilitarForm(ObjetivoId, IndicadorId){
		var action = "<?php echo $this->webroot;?>MapaEstrategico/ajaxFormIndices";
		$.post(
			action,
			{objetivo_id: ObjetivoId, indicador_id: IndicadorId},
			function(data){
				var div = "#form_indices_" + ObjetivoId;
				$(div).html("");
				$(div).html(data);
			}
		);
	}
</script>
