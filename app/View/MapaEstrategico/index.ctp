<div id="mapa-estrategico" class="container">
	<h4 class="title title-section">Mapa Estratégico</h4>
	<form class="well form-search" action="<?php echo $this->webroot; ?>MapaEstrategico/index" method="post">		
		<div class="row">
			<div class="span11">
				<div class="input-append">
					<select name="data[Indicador][anos][]" class="input-xlarge" id="IndicadorAnos">
						<?php $anos = Util::anos(); ?>
						<?php foreach($anos as $key => $value){?>
							<option value="<?php echo $key; ?>" <?php echo $value == $anoSelecionado ? "selected='selected'" : '' ;?>><?php echo $value; ?></option>
						<?php } ?>
					</select>
					<button type="submit" class="btn"><i class="icon-search"></i>&nbsp;</button>
				</div>
			</div>
		  </div>		
	</form>
	<?php $count = 0;?>
	<?php foreach($dimensoes as $dimensao){?>
	<div class="row-fluid">
		<div class="span12">
			<ul class="thumbnails">
				<li class="span12">
					<div class="thumbnail">
						<div class="caption" >
							<h3><?php echo $dimensao['Dimensao']['titulo']; ?></h3>
							<hr>							
							<ul class="thumbnails" >
								<?php foreach($dimensao['Objetivo'] as $objetivo){ ?>
									<?php  if($objetivo['tipo'] == Util::TIPO_PADRAO){?>
									<li class="span2"  id="balao<?php echo $objetivo['id']; ?>">
										<a href="javascript:exibirIndicadores(<?php echo $objetivo['id']; ?>)" class="thumbnail mostrar">
											<p>											
												<?php echo $objetivo['titulo']; ?>																					
											</p>
										</a>
									</li>
									<?php } ?>
								<?php }?>
							</ul>
							<?php
								$ordem = array(); 
								foreach($dimensao['Objetivo'] as $objetivo){
									$ordem[$objetivo['id']] = $objetivo['id'];
								}
							 	ksort($ordem);
							 	
							 	foreach($ordem as $id=>$value){ ?>
									<div id="indicadores<?php echo $id; ?>" style="display: none;">
									</div>
								<?php }
							?>
						</div>						
					</div>					
				</li>				
			</ul>
		</div>
	</div>
	<?php } ?>	
</div>
<!-- essa div de ações fica nessa view, pois não pode ser renderizada nas views de indicadores -->
<div id="dialogAcoes" title="Painel de Ações" style="display: none">
</div>
<div id="dialog" title="Painel de Resumo" style="display: none">
</div>
<div id="teste" title="Painel de Ações">
</div>
<script type="text/javascript" src="<?php echo $this->base;?>/js/libs/highcharts.js"></script>
<script type="text/javascript">
function exibirIndicadores(objetivoId){
	var div = "#indicadores" + objetivoId;
	var balao = "#balao" + objetivoId;
	var background_balao = $(balao).css("background-color");
	$.get(
        "<?php echo $this->webroot;?>MapaEstrategico/indicadores/"+objetivoId,
        null,
        function(data) {
            $(div).html(data);
            
            $(div).slideToggle("slow");
            if(background_balao == 'rgba(0, 0, 0, 0)'){
		    	$(balao).css("background-color", "#E6E6FA");
		    }else{
		    	$(balao).css("background-color", "");
		    }
		    
        	var medida_id = "#medidas" + objetivoId;
        	$(medida_id).slideToggle("slow");
        	
        	
        	
        	var exibir_valores = "#exibir_valores_" + objetivoId;
        	$(exibir_valores).click(function(){
        		var valores = "#valores_" + objetivoId;
        		$(valores).slideToggle("slow");
        		
        		var atualizar_valores = "#atualizar_valores_" + objetivoId;
        		$(atualizar_valores).click(function(e){
        			e.preventDefault();
        			var form = "#MapaEstrategicoSalvarForm" + objetivoId;
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

function exibirGrafico(objetivoId, indicadorId){
	
	var action = "<?php echo $this->webroot;?>MapaEstrategico/ajaxGrafico?IdIndicador=" + indicadorId;
	var form_grafico = "#form_grafico_" + indicadorId;
	$.post(
		action,
		$(form_grafico).serialize(),
		function(data){
			
			var grafico = "#grafico_" + objetivoId + "_" + indicadorId;
			var mostrarGrafico = "exibir_grafico_" + objetivoId + "_" + indicadorId;			
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

//Função descontinuada, agora, usamos o treetable, na view indicadores
function exibirFilhos(objetivoId, indicadorId){
	var action = "<?php echo $this->webroot;?>MapaEstrategico/recuperarIndicadoresFilhos";
	$.post(
		action,
		{objetivo_id: objetivoId, indicador_id: indicadorId},
		function(data){
			$.each(data, function(index, value){
				var id = "#indicador_"+ objetivoId + "_" + value;
				$(id).slideToggle("slow");
			});
		},
		"json"
	);	
}

function abrirModal(objetivoId, indicadorId, mes, comDialog){
	var action = "<?php echo $this->webroot;?>MapaEstrategico/ajaxPainelResumo";
	$.post(
		action,
		{objetivo_id: objetivoId, indicador_id: indicadorId, mes: mes},
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

function abrirModalAcoes(objetivoId, comDialog){
	var action = "<?php echo $this->webroot;?>MapaEstrategico/ajaxPainelAcoes";
	$.post(
		action,
		{objetivo_id: objetivoId},
		function(data){
			$("#dialogAcoes").html(data);
			if(comDialog == true){
				$("#dialogAcoes").dialog({
					height: 400,
			    	width: 350,
			    	modal: true
				});
			}
			
		}
	);
}

function formAcao(idObjetivo){
	var action = "<?php echo $this->webroot;?>Acao/ajaxAdicionarComObjetivo";
	$.get(
		action,
		{id_objetivo: idObjetivo},
		function(data){
			$("#dialogAcoes").html("");
			$("#dialogAcoes").html(data);
			$("#salvar").click(function(){
				var action = <?php echo $this->webroot; ?> + "Acao/ajaxAdicionarComObjetivo";
				$.post(
					action,
					$("#AcaoAjaxAdicionarComObjetivoForm").serialize(),
					function(data){
						alert(data);
						if(data == "<?php echo Util::REGISTRO_ADICIONADO_SUCESSO; ?>"){
							abrirModalAcoes(idObjetivo, false);
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
$(document).ready(function(){
});
</script>