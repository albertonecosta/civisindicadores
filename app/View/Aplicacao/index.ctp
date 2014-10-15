<div class="row-fluid">
	<div class="span3">
		<div class="application-bar">
			<div class="application-user">
				<div class="sector"><?php echo $_SESSION["Auth"]["User"]["Cargo"]["titulo"];?></div>
				<div class="application-user-wrap clearfix">
					<figure class="image">
						<img src="<?php echo $this->webroot."files/usuario/".$_SESSION["Auth"]["User"]['diretorio_imagem_perfil']."/"."pequeno_".$_SESSION["Auth"]["User"]['imagem_perfil']; ?>" alt="">
					</figure>
					<span class="welcome">Olá,</span>
					<strong class="name">
					<?php 
						
						echo $_SESSION["Auth"]["User"]["Pessoa"]["titulo"];
					?>
					</strong>
					<a href="<?php echo $this->base?>/usuario/logout" class="logout" title="Sair">(Sair)</a>
				</div>
			</div><!-- /.application-user -->

			<div class="application-user-actions">
				<!-- <a href="<?php echo $this->base?>/Usuario/Visualizar" title="Configurações"><i class="fa fa-cog"></i></a>-->
				<a href="<?php echo $this->base?>/Tarefa" title="Tarefas"><i class="fa fa-tasks"></i></a>
				<a href="<?php echo $this->base?>/Reuniao" title="Reuniões"><i class="fa fa-calendar"></i></a>
				<a href="<?php echo $this->base?>/Organograma" title="Organograma"><i class="fa fa-sitemap"></i></a>
			</div><!-- /.application-user-actions -->
			
			<ul class="application-user-list-highlight">
				<li>
					<a href="<?php echo $this->base?>/projeto" title="">
						<span class="fa fa-caret-right"></span> 
						<span class="text">Projetos</span>
					</a>
				</li>
				<li>
					<a href="<?php echo $this->base?>/acao" title="">
						<span class="fa fa-caret-right"></span> 
						<span class="text">Atividades</span>
					</a>
				</li>
				<li>
					<a href="<?php echo $this->base?>/tarefa" title="">
						<span class="fa fa-caret-right"></span> 
						<span class="text">Tarefas</span>
					</a>
				</li>
			</ul><!-- /.application-user-list-highlight -->
			<!--
			<div class="application-widget calendar">
				<div class="application-widget-header">Reuniões</div>
				<div class="application-widget-content">
					<ul>
						<li>
							<span class="date">
								<span class="day">21</span>
								<span class="month">FEV</span>
							</span>
							<span class="desc">
								<span class="sub">09:30</span>
								<p>Reunião de Planejamento</p>
							</span>
						</li>
						<li>
							<span class="date">
								<span class="day">24</span>
								<span class="month">FEV</span>
							</span>
							<span class="desc">
								<span class="sub">14:30</span>
								<p>Polisys - SIAPA</p>
							</span>
						</li>
					</ul>
				</div>
			</div>
			-->
			<!-- /.application-widget -->

			<div class="application-widget messages">
				<div class="application-widget-header">Últimos Comentários </div>
				<div class="application-widget-content">
					<ul>
					
					
					<?php 
						foreach($posts as $post){
						//var_dump($post);
								/**
								* Link para página do projeto
								*/
								//echo $this->Html->link( $projeto["titulo"], array('controller' => 'Projeto', 'action' => 'visualizar', $id));
								?>
						<li class="new">
							<a href="<?php echo $this->base?>/">
								<span class="actions">
									<span class="ball"></span>
								</span>
								<span class="desc">
									<strong class="desc-title"><?php echo $post["mensagem"]?></strong>
									<p class="subject"><?php echo $post["pessoa"]?></p>
								</span>
								<span class="date">
									<span class="hour"><?php echo date("H:m",strtotime($post["created"]));?>h</span>
								</span>	
							</a>
						</li>
						<?php 
						 
} ?>
					
					
					</ul>
				</div>
			</div><!-- /.application-widget -->

		</div><!-- /.application-bar -->
	</div><!-- /.span3 -->
	<?php
		echo $this->Html->script(array('highcharts.js','modules/exporting.js', 'highcharts-more.js'));
	?>
	<div class="span9">
		<div class="row-fluid application-graphs">
			<div class="span6">
				<div class="box-graph-w-numbers">
					<div class="graph-number"><?php echo @$indicadores["QtdeAcoesEstrategicas"];?></div>
					<div class="graph-number-desc">Ações Estratégicas do PDTI
						<!-- <span class="desc-arrow negative">-5% <span class="fa fa-caret-down"></span></span>-->
					</div>
					<div id="container3" class="graph" ></div>
					<div class="graph-number-desc">Andamento das Ações Monitoradas
						<span class="desc-arrow positive"><?php echo @$indicadores["ExecucaoPDTI"];?>% <span class="fa fa-caret-up"></span></span>
					</div>	
				</div><!-- /.box-graph-w-numbers -->
			</div><!-- /.span6 -->
			<div class="span6">
				<div class="box-graph-w-numbers">
					<div class="graph-number"><?php echo @$indicadores["AcoesMonitoradas"];?></div>
					<div class="graph-number-desc">Ações Monitoradas
						<!--  <span class="desc-arrow negative">-8% <span class="fa fa-caret-down"></span></span>-->
					</div>
					<div id="container4" class="graph"></div>
					<div class="graph-number-desc">Percentual de Monitoramento do PDTI
						<span class="desc-arrow positive"><?php echo @$indicadores["PercentualAcoesMonitoradas"];?>%<span class="fa fa-caret-up"></span></span>
					</div>
				</div><!-- /.box-graph-w-numbers -->
			</div><!-- /.span6 -->
		</div><!-- /.row-fluid -->
		<div class="row-fluid application-graphs">
			<div class="span6">
				<div id="container1" style="min-width: 310px; height: 250px; margin: 0 auto"></div>
			</div><!-- /.span6 -->
			<div class="span6">
				<div id="container2" style="min-width: 310px; height: 250px; margin: 0 auto"></div>
			</div><!-- /.span6 -->
		</div><!-- /.applications-graphs -->
	
		<div class="row-fluid application-boxes">
			
			<div class="span6">
				<div class="box box-border box-tasks">
					<div class="box-title">
						<h3 class="title"><span class="icon fa fa-tasks"></span> Tarefas</h3>
					</div>
					<div class="box-content">
						<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed table-tasks">
						<?php 
						
						foreach($tarefas as $tarefa){	?>
							<tr>
								<td class="t-text"><?php echo $this->Html->link($tarefa['tarefa'], array('controller' => 'Tarefa', 'action' => 'visualizar', $tarefa['id'])) ?></td>
								<td class="t-label" data-hide="phone,tablet">
								<?php
								$diff = Util::difData(date("d/m/Y"), UTIL::inverteData($tarefa['data_fim_previsto']), 'D');
								if ($diff<0){
									echo '<span class="label label-important">Atrasada</span>';
								}elseif ($diff==0){
									echo '<span class="label label-warning">Hoje</span>';
								}elseif ($diff==1){
									echo '<span class="label label-info">Amanhã</span>';
								}elseif ($diff>1 and $diff<8){
									echo '<span class="label label-success">1 Semana</span>';
								}elseif ($diff>=8 and $diff<15){
									echo '<span class="label label-inverse">2 Semanas</span>';
								}elseif ($diff>=15){
									echo '<span class="label label-warning">+ 2 Semanas</span>';
								}
								?>
						
								
								</td>
								<td class="t-check" data-hide="phone,tablet"><a href="" title="Marcar"><span class="fa fa-check"></span></a></td>
								<td class="t-check" data-hide="phone,tablet"><a href="" title="Desmarcar"><span class="fa fa-times"></span></a></td>
							</tr>
							<?php } ?>
							
						</table>
					</div><!-- /.box-content -->
				</div><!-- /.box-tasks -->
			</div><!-- /.span6 -->
			<div class="span6">
				<div class="box box-border box-forum">
					<div class="box-title">
						<h3 class="title"><span class="icon fa fa-folder-open"></span> Projetos em andamento</h3>
					</div>
					
					<div class="box-content">
						<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
							<?php 
							/**
							* Leitura do array de projetos carregado com dados de projeto e atividades
							*/
							foreach($projetos as $id=>$projeto){?>
							<tr>
								<td>
								<?php 
								/**
								* Link para página do projeto
								*/
								echo $this->Html->link( $projeto["titulo"], array('controller' => 'Projeto', 'action' => 'visualizar', $id));
								/**
								* Cálculo do percentual de atividades conckuídas
								*/
								$total = array_sum($projeto);
								$percentual = @($projeto[5]/$total)*100;
								?>
									<div class="progress progress-danger progress-striped">
										  <div class="bar" style="width: <?php echo number_format($percentual,2,".",".")?>%;"><?php echo number_format($percentual,2,",",".")?>%</div>
									</div>
								</td>
							</tr>
							<?php } ?>
							
						</table>
					</div><!-- /.box-content -->
				</div><!-- /.box-forum -->
			</div><!-- /.span6 -->

		</div><!-- /.application-boxes -->
	</div><!-- /.span9 -->

</div><!-- /.row-fluid -->

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
	            from: 50,
	            to: 100,
	            color: '#55BF3B' // green
	        }, {
	            from: 10,
	            to: 50,
	            color: '#DDDF0D' // yellow
	        }, {
	            from: 0,
	            to: 10,
	            color: '#DF5353' // red
	        }]        
	    },
		
	    series: [{
	        name: 'Percentual',
	        data: [<?php echo @$indicadores["ExecucaoPDTI"];?>],
	        
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
		        max: 100,
		        
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
		            from: 50,
		            to: 100,
		            color: '#55BF3B' // green
		        }, {
		            from: 10,
		            to: 50,
		            color: '#DDDF0D' // yellow
		        }, {
		            from: 0,
		            to: 10,
		            color: '#DF5353' // red
		        }]        
		    },
		
		    series: [{
		        name: '',
		        data: [<?php echo @$indicadores["PercentualAcoesMonitoradas"];?>],
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

		$('#container1').highcharts({
	            title: {
	                text: 'Atividades',
	                x: -20 //center
	            },
	            subtitle: {
	                text: 'Previsão de conclusão das atividades',
	                x: -20
	            },
	            xAxis: {
	                categories: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
	                    'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
	            },
	            yAxis: {
	                title: {
	                    text: 'Quantidade'
	                },
	                plotLines: [{
	                    value: 0,
	                    width: 1,
	                    color: '#808080'
	                }]
	            },
	            tooltip: {
	                valueSuffix: ''
	            },
	            credits: {
	                enabled: false
	            },
	            legend: {
	                layout: 'vertical',
	                align: 'right',
	                verticalAlign: 'middle',
	                borderWidth: 0
	            },
	            series: [{
	                name: 'Previsão de conclusões',
	                data: [<?php echo @$indicadores["acoesPrevistas"][1]?>,
	    	               <?php echo @$indicadores["acoesPrevistas"][2]?>,
	    	               <?php echo @$indicadores["acoesPrevistas"][3]?>,
	    	    	       <?php echo @$indicadores["acoesPrevistas"][4]?>,
	    	    	       <?php echo @$indicadores["acoesPrevistas"][5]?>,
	    	    	       <?php echo @$indicadores["acoesPrevistas"][6]?>,
	    	    	       <?php echo @$indicadores["acoesPrevistas"][7]?>,
							<?php echo @$indicadores["acoesPrevistas"][8]?>,
							<?php echo @$indicadores["acoesPrevistas"][9]?>,
							<?php echo @$indicadores["acoesPrevistas"][10]?>,
							<?php echo @$indicadores["acoesPrevistas"][11]?>,
							<?php echo @$indicadores["acoesPrevistas"][12]?>]
	            }]
	        });

	var colors = Highcharts.getOptions().colors,
			            categories = [ 'Atividades'],
			            name = 'Browser brands',
			            data = [{
			                    y: 7.15,
			                    color: colors[3],
			                    drilldown: {
			                        name: 'Safari versions',
			                        categories: ['100%', '75%', '50%', '25%', '0%'],
			                        data: [5, 10, 2, 1, 2],
			                        color: colors[3]
			                    }
			                
			                }];
			    
			    
			        // Build the data arrays
			        var browserData = [];
			        var versionsData = [];
			        for (var i = 0; i < data.length; i++) {
			    
			            // add browser data
			            browserData.push({
			                name: categories[i],
			                y: data[i].y,
			                color: data[i].color
			            });
			    
			            // add version data
			            for (var j = 0; j < data[i].drilldown.data.length; j++) {
			                var brightness = 0.2 - (j / data[i].drilldown.data.length) / 5 ;
			                versionsData.push({
			                    name: data[i].drilldown.categories[j],
			                    y: data[i].drilldown.data[j],
			                    color: Highcharts.Color(data[i].color).brighten(brightness).get()
			                });
			            }
			        }
			    
			        // Create the chart
			        $('#container2').highcharts({
			        	  chart: {
			                  plotBackgroundColor: null,
			                  plotBorderWidth: null,
			                  plotShadow: false
			              },
			              title: {
			                  text: 'Status das atividades de todos os projetos'
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
			              series: [{
			                  type: 'pie',
			                  name: 'Browser share',
			                  data: [
			                      ['Concluídas',  <?php if (isset($indicadores["Status"][5])) echo $indicadores["Status"][5]; else echo "0";?>],
			                      ['Aguardando outra pessoa',  <?php if (isset($indicadores["Status"][4])) echo $indicadores["Status"][4]; else echo "0";?>],
			                      ['Em andamento',    <?php if (isset($indicadores["Status"][3])) echo $indicadores["Status"][3]; else echo "0";?>],
			                      ['Não Iniciada',   <?php if (isset($indicadores["Status"][2])) echo $indicadores["Status"][2]; else echo "0";?>],
			                      ['Cancelada',   <?php if (isset($indicadores["Status"][6])) echo $indicadores["Status"][6]; else echo "0";?>]
			                  ]
			              }]
			        });

});	

</script>