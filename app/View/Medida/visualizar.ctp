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

// Carregamento das variáveis para controle de acesso
$editar = $this->ControleDeAcesso->validaAcessoElemento('editar');
$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir');
?>
<div class="container">
	<legend>Visualizar Ações</legend>
	<div class="buttons">
		<?php
		if($editar){
			echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $medida['Medida']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
			echo "&nbsp;&nbsp;";
		}
		if($excluir){
			echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $medida['Medida']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $medida['Medida']['id'])
				);
		}
		?>
	</div>
	<br />
	<div class="row">
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><strong><?php echo h($medida['Medida']['titulo']); ?></strong></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Prioridade'); ?></strong></td>
						<td><?php echo h($medida['Medida']['prioridade']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Meta no PDTI'); ?></strong></td>
						<td>
						
						<table border="1">
							<tbody>
								<tr>									
									<th>Prazo</th>
									<th>Indicador</th>
									<th>Meta</th>
								</tr>
								<tr>
									<td><?php echo h($medida['Medida']['pdti_prazo']); ?></td>
									<td><?php echo h($medida['Medida']['pdti_indicador']); ?></td>
									<td><?php echo h($medida['Medida']['pdti_valor_meta']); ?></td>
								</tr>
							</tbody>
						</table>
						
						
						
						</td>
					</tr>
					<!-- tr>
						<td><strong><?php echo __('Ordem'); ?></strong></td>
						<td><?php echo h($medida['Medida']['ordem']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Dimensao'); ?></strong></td>
						<td><?php echo h($medida['Dimensao']['titulo']); ?></td>
					</tr -->
					<tr>
						<td><strong><?php echo __('Status'); ?></strong></td>
						<td><?php 
						
						$status_medida = $medida['Medida']['status_medida'];
						$statusNome = "";
						switch ($status_medida) {
							case Util::NAO_INICIADO:
								$statusNome = "Não Iniciado";
								break;
							case Util::EM_ANDAMENTO:
								$statusNome = "Em andamento";
								break;
							case Util::AGUARDANDO_OUTRA_PESSOA:
								$statusNome = "Aguardando outra pessoa";
								break;
							case Util::CONCLUIDO:
								$statusNome = "Concluído";
								break;
							case Util::CANCELADO:
								$statusNome = "Cancelado";
								break;
							case Util::NAO_CONCLUIDO:
								$statusNome = "Não Concluído";
								break;
						}
						
						
						echo h($statusNome); ?></td>
					</tr>				
					
					<tr>
						<td><strong><?php echo __('Situação'); ?></strong></td>
						<td><?php 

						$situacao = $medida['Medida']['situacao'];
						$situacaoNome = "";
						$situacaoNomeLabel = "";
						
						switch ($situacao) {
						    case Util::NAO_INFORMADO:
						        $situacaoNome = "<img src='".$this->base."/img/quadrado_cinza.png' title='Não Informado'>";
								$situacaoNomeLabel = "Não Informado";
						        break;
						    case Util::ADEQUADO:
						        $situacaoNome = "<img src='".$this->base."/img/quadrado_verde.png' title='Adequado'>";
								$situacaoNomeLabel = "Adequado";
						        break;
						    case Util::ATENCAO:
						        $situacaoNome = "<img src='".$this->base."/img/quadrado_amarelo.png' title='Atenção'>";
								$situacaoNomeLabel = "Atenção";
						        break;
					        case Util::CONCLUIDO:
					        	$situacaoNome = "<img src='".$this->base."/img/quadrado_azul.png' title='Concluído'>";
								$situacaoNomeLabel = "Concluído";
					        	break;
				        	case Util::PREOCUPANTE:
				        		$situacaoNome = "<img src='".$this->base."/img/quadrado_vermelho.png' title='Preocupante'>";
								$situacaoNomeLabel = "Preocupante";
				        		break;
						}
				
						echo $situacaoNome; ?> <?php echo $situacaoNomeLabel; ?></td>
					</tr>
					<?php
							
					
					function cleanUpTags($str){
						$order   = array("\r\n", "\n", "\r");
						$replace = "<br />";
						return str_replace($order, $replace, strip_tags($str));
					}
					
					?>
					<tr>
						<td><strong><?php echo __('Andamento'); ?></strong></td>
						<td><?php echo h($medida['Medida']['andamento']); ?></td>
					</tr>
					
					<tr>
						<td><strong><?php echo __('Descrição da Situação'); ?></strong></td>
						<td><?php echo cleanUpTags(($medida['Medida']['situacao_desc'])); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Resultados'); ?></strong></td>
						<td><?php echo cleanUpTags(($medida['Medida']['resultado'])); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Providências'); ?></strong></td>
						<td><?php echo cleanUpTags(($medida['Medida']['providencia'])); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Restrições'); ?></strong></td>
						<td><?php echo cleanUpTags(($medida['Medida']['restricao'])); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Riscos'); ?></strong></td>
						<td><?php echo cleanUpTags(($medida['Medida']['riscos'])); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Observações'); ?></strong></td>
						<td><?php echo cleanUpTags(($medida['Medida']['observacoes'])); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Última Atualização'); ?></strong></td>
						<td><?php echo cleanUpTags(($medida['Medida']['data_ultima_atualizacao'])); ?></td>
					</tr>
					
					<tr>
						<td><strong><?php echo __('Projetos Relacionados'); ?></strong></td>
						<td>
							<!-- Projetos -->
							<ul class="list-inner">
							<?php

							if(isset($projetos[$medida['Medida']['id']])){
								foreach ($projetos[$medida['Medida']['id']] as $key => $value) {

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
					</tr>
				</tbody>				
			</table>			
		</div>
	</div>
</div>

<div style="display: none">
<div id="indicadores<?php echo $medida['Medida']['id']; ?>" style="display: none">
</div>
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

exibirIndicadores(<?php echo $medida['Medida']['id']; ?>);

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