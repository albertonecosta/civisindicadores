<?php
	$editar = $this->ControleDeAcesso->validaAcessoElemento('editar');
	$visualizarUsuario = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Usuario');
	$visualizarPrograma = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Programa');
	$visualizarAcao = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Acao');
	$adicionarAcao = $this->ControleDeAcesso->validaAcessoElemento('adicionar', 'Acao');
?>
<div class="container">
	<legend>Visualizar Projeto
		<div class="list-actions-buttons pull-right">
			<?php if($editar){?>				
			<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->Html->url(
					array('action' => 'editar', $projeto['Projeto']['id']));?>'"><i class="fa fa-plus-circle"></i>Editar</button>
			<?php }?>
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
							<ul class="list-inner">
							
							<?php
							/**
							 * 
							 * Exibição das ações do projeto atual
							 * 							 * 
							 */
							if(isset($acoes)){
								foreach ($acoes as $key => $value) {
								?>
								
									<li>
									<div class="wrapper">
									<div class="text">
									<abbr style='font-size: 14px;' title='<?php echo $value["nome"]." | ".Util::inverteData($value["data_inicio_previsto"])." a ".Util::inverteData($value["data_fim_previsto"])?>'>
										<?php
											if($visualizarAcao){
												echo $this->Html->link($value['titulo'], array('controller' => 'Acao', 'action' => 'visualizar', $value['id']));
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
											if (strtotime(Util::inverteData($value["data_conclusao"]))>strtotime(Util::inverteData($value["data_fim_previsto"])))
											$barraProgresso="progress progress-danger progress-striped";
											else
											$barraProgresso="progress progress-success progress-striped";
											$qtdAcoesConcluidas++;
										}else{
											if (time()>strtotime(Util::inverteData($value["data_fim_previsto"])))
											$barraProgresso="progress progress-danger progress-striped";
											elseif (time()-604800>strtotime(Util::inverteData($value["data_fim_previsto"])))
											$barraProgresso="progress progress-success progress-striped";
											else
											$barraProgresso="progress progress-warning progress-striped";
											
										}
										
										$ondeEsta=substr($value["andamento"],0,strpos($value["andamento"],"%"));
										
										$ondeDeveriaHoje=time()-strtotime($value["data_inicio_previsto"]);
										if ($ondeDeveriaHoje<0) $ondeDeveriaHoje=1;
										$diferenca = (strtotime($value["data_fim_previsto"])-strtotime($value["data_inicio_previsto"]));
										if ($diferenca==0) 
											$diferenca=1;						

													
										$ondeDeveria=($ondeDeveriaHoje/$diferenca)*100;
										if ($ondeDeveria>100)
											$ondeDeveria=100;
										
										$ondeDeveriaTotal+=$ondeDeveria;
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
								
								
								
									$vp = h($projeto['Projeto']['custo'])*($ondeDeveriaMedia/100);
									$va= h($projeto['Projeto']['custo'])*($ondeEstaMedia/100);
									$idc= $va/h($projeto['Projeto']['gasto']);
									$ipd= $va/$vp;
								
							}
							?>
							<div class="button-area row-fluid">
								<?php if($adicionarAcao){?>
								<button class="btn btn-mini"  type="button" onclick="abrirModalAcao(<?php echo $projeto['Projeto']['id']; ?>)">Adicionar</button>
								<?php }?>
							</div>
							</ul>
						&nbsp;
						</td>
					</tr>
					<tr>
						<td><strong><?php echo __('Valor Planejado'); ?></strong></td>
						<td>$ <?php echo number_format($vp,2,'.',',');?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Valor Agregado'); ?></strong><abbr title='Isso mostra a você quanto($) seu projeto realmente agregou.'><span class="fa fa-question-circle fa-1g"></span></abbr></td>
						<td>$ <?php echo number_format($va,2,',','.'); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('IPD'); ?></strong></td>
						<td><?php echo number_format($ipd,2,',','.') ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('IPC'); ?></strong></td>
						<td><?php echo number_format($ipd,2,',','.') ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('VPR'); ?><abbr title='Esse indicador mostra em ($) o quanto seu projeto está adiantado ou atrasado.'><span class="fa fa-question-circle fa-1g"></span></abbr></strong></td>
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
	        data: [<?php echo (($ondeEstaMedia/$ondeDeveriaMedia)*100)?>],
	        
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
					<div class="graph-number-desc">Indicador da performance do projeto
						<span class="desc-arrow positive">+25% <span class="fa fa-caret-up"></span></span>
					</div>	
				</div><!-- /.box-graph-w-numbers -->
			</div><!-- /.span6 -->
			<div class="span6">
				<div class="box-graph-w-numbers">
					<div class="graph-number"><?php echo number_format(($qtdAcoesConcluidas/$qtdAcoes)*100,2,',','.'); ?><sup>%</sup></div>
					<div class="graph-number-desc">Percentual de ações concluídas do projeto
						<!--  <span class="desc-arrow negative">-8% <span class="fa fa-caret-down"></span></span>-->
					</div>
					<div id="container4" class="graph"></div>
					<div class="graph-number-desc">Andamento médio de suas ações
						<span class="desc-arrow positive">+50% <span class="fa fa-caret-up"></span></span>
					</div>
				</div><!-- /.box-graph-w-numbers -->
			</div><!-- /.span6 -->
		</div><!-- /.row-fluid -->
		
		<div class="tab-pane" id="tab2">
			<div id='indicadores<?php echo $projeto['Projeto']['id'];?>'><center><img src="<?php echo $this->webroot."img".DS."ajax-loader.gif" ?>" />Carregando indicadores...</center></div>
		</div>
		
<?php /*	
<div class="tab-pane" id="tab2">
				<table class="footable table table-hover table-condensed" id="indicadores">
						<thead>
						<tr>
							<th data-class="expand">Metas</th>
							<th data-hide="phone,tablet">Jan</th>
							<th data-hide="phone,tablet">Fev</th>
							<th data-hide="phone,tablet">Mar</th>
							<th data-hide="phone,tablet">Abri</th>
							<th data-hide="phone,tablet">Mai</th>
							<th data-hide="phone,tablet">Jun</th>
							<th data-hide="phone,tablet">Jul</th>
							<th data-hide="phone,tablet">Ago</th>
							<th data-hide="phone,tablet">Set</th>
							<th data-hide="phone,tablet">Out</th>
							<th data-hide="phone,tablet">Nov</th>
							<th data-hide="phone,tablet">Dez</th>
							<th data-hide="phone,tablet">Meta</th>
							<th data-hide="phone,tablet">Projeção</th>
							<th data-hide="phone,tablet"><?php echo $_SESSION['ano_selecionado_indicadores']-1; ?></th>
							<th data-hide="phone,tablet">Opções</th>
						</tr>
						</thead>
						<tbody>
					<?php 
						foreach($indicadoresFiltrados as $indicador){ ?>					
						<tr style="border-bottom: #bebec5 solid 1px;" data-tt-id="<?php echo $indicador['Indicador']['id']; ?>" <?php if($indicador['Pai']['id'] != null && !in_array($indicador['Pai']['id'])){ ?> data-tt-parent-id="<?php echo $indicador['Pai']['id']; ?>" <?php } ?>>
							<td onclick="javascript:habilitarForm(<?php echo $indicador['Indicador']['id']; ?>)">
								<a href="javascript:"><?php echo $indicador['Indicador']['titulo']; ?></a>&nbsp;
								<?php if($indicador['Pai']['id'] != null){?>
									<i class="icon-question-sign" title="Sub-indicador de <?php echo $indicador['Pai']['titulo']; ?>"></i>
								<?php } ?>
							</td>
							<?php foreach($indicador['TotalIndicador'] as $totalIndicador){
									if($totalIndicador['ano'] == $_SESSION['ano_selecionado_indicadores']){?>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['01'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['01'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['janeiro'] == 0){ ?>

									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 1;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['janeiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['janeiro'] > 0 && $totalIndicador['janeiro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['janeiro'] < 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 1;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['janeiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['janeiro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['janeiro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 1;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['janeiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 1;?>, true)"><span class='badge-indicador  succes' title="<?php echo $totalIndicador['janeiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['02'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['02'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['fevereiro'] == 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 2;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['fevereiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['fevereiro'] == 0 || $totalIndicador['fevereiro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['fevereiro'] < 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 2;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['fevereiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['fevereiro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['fevereiro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 2;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['fevereiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 2;?>, true)"><span class='badge-indicador  succes' title="<?php echo $totalIndicador['fevereiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['03'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['03'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['marco'] == 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 3;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['marco']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['marco'] == 0 || $totalIndicador['marco'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['marco'] < 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 3;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['marco']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['marco'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['marco'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 3;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['marco']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 3;?>, true)"><span class='badge-indicador  succes' title="<?php echo $totalIndicador['marco']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['04'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['04'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['abril'] == 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 4;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['abril']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['abril'] == 0 || $totalIndicador['abril'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['abril'] < 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 4;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['abril']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['abril'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['abril'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 4;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['abril']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 4;?>, true)"><span class='badge-indicador  succes' title="<?php echo $totalIndicador['abril']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['05'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['05'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['maio'] == 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 5;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['maio']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['maio'] == 0 || $totalIndicador['maio'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['maio'] < 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 5;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['maio']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['maio'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['maio'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 5;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['maio']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 5;?>, true)"><span class='badge-indicador  succes' title="<?php echo $totalIndicador['maio']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['06'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['06'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['junho'] == 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 6;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['junho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['junho'] == 0 || $totalIndicador['junho'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['junho'] < 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 6;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['junho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['junho'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['junho'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 6;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['junho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 6;?>, true)"><span class='badge-indicador  succes' title="<?php echo $totalIndicador['junho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['07'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['07'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['julho'] == 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 7;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['julho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['julho'] == 0 || $totalIndicador['julho'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['julho'] < 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 7;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['julho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['julho'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['julho'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 7;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['julho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 7;?>, true)"><span class='badge-indicador  succes' title="<?php echo $totalIndicador['julho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['08'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['08'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['agosto'] == 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 8;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['agosto']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['agosto'] == 0 || $totalIndicador['agosto'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['agosto'] < 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 8;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['agosto']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['agosto'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['agosto'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 8;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['agosto']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 8;?>, true)"><span class='badge-indicador  succes' title="<?php echo $totalIndicador['agosto']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['09'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['09'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['setembro'] == 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 9;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['setembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['setembro'] == 0 || $totalIndicador['setembro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['setembro'] < 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 9;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['setembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['setembro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['setembro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 9;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['setembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 9;?>, true)"><span class='badge-indicador  succes' title="<?php echo $totalIndicador['setembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['10'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['10'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['outubro'] == 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 10;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['outubro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['outubro'] == 0 || $totalIndicador['outubro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['outubro'] < 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 10;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['outubro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['outubro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['outubro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 10;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['outubro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 10;?>, true)"><span class='badge-indicador  succes' title="<?php echo $totalIndicador['outubro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['11'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['11'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['novembro'] == 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 11;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['novembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['novembro'] == 0 || $totalIndicador['novembro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['novembro'] < 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 11;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['novembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['novembro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['novembro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 11;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['novembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 11;?>, true)"><span class='badge-indicador  succes' title="<?php echo $totalIndicador['novembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['12'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['12'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['dezembro'] == 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 12;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['dezembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['dezembro'] == 0 || $totalIndicador['dezembro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['dezembro'] < 0){ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 12;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['dezembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['dezembro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['dezembro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 12;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['dezembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(1,<?php echo $indicador['Indicador']['id']; ?>, <?php echo 12;?>, true)"><span class='badge-indicador  succes' title="<?php echo $totalIndicador['dezembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td><?php echo Util::getMetaTotal($indicador); ?></td>
							<td><?php echo Util::getProjecao($indicador); ?></td>
							<td><?php echo Util::getMetaTotal($indicador, true); ?></td>
							<td><a href="javascript:exibirGrafico(<?php echo $indicador['Indicador']['id']; ?>)" id="exibir_grafico"><i class="icon-picture" title="Gráficos"></i></a></td>
							<form action="#" id="form_grafico_<?php echo $indicador['Indicador']['id']; ?>">
								<input type="hidden" name="data[Indicador][id]" value="<?php echo $indicador['Indicador']['id']; ?>" />
								<input type="hidden" name="data[Objetivo][id]" value="<?php echo $indicador['Indicador']['objetivo_id']; ?>" />
							</form>
							<?php } 
								} ?>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<?php foreach($indicadores as $indicador){ ?>
				<div class="row-fluid" style="display: none" id="grafico_<?php echo $indicador['Indicador']['id']; ?>">
					<div class="span8" id="exibir_grafico_<?php echo $indicador['Indicador']['id']; ?>" style="height:400px;">
					</div>					
				</div>
				<?php } ?>
			</div>
			*/ ?>
			<div id="dialog" title="Painel de Resumo" style="display: none">
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
        	
        	
        	var exibir_valores = "#exibir_valores_" + projetoId;
        	$(exibir_valores).click(function(){
        		var valores = "#valores_" + projetoId;
        		$(valores).slideToggle("slow");
        	});
        	
        }
    );
}

exibirIndicadores(<?php echo $projeto['Projeto']['id'];?>);

								
								
function abrirModalAcao(idProjeto){
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
				var action = <?php echo $this->webroot; ?> + "Acao/ajaxAdicionarComProjeto/" + idProjeto;
				$.post(
					action,
					$("#AcaoAjaxAdicionarComProjetoForm").serialize(),
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
