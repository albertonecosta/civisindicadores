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

// Carregamento de variáveis para controle de acesso
	$visualizarAtividade = $this->ControleDeAcesso->validaAcessoElemento('visualiza', 'Atividade');
	$adicionarAtividade = $this->ControleDeAcesso->validaAcessoElemento('adicionar', 'Atividade');
?>
<div class="container">
	<legend>Visualizar Anomalia</legend>
	<div class="row">
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Justificativa'); ?></strong></td>
						<td><?php echo h($anomalia['Anomalia']['identificacao_problema']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Data'); ?></strong></td>
						<td><?php echo h($anomalia['Anomalia']['data']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Causas Internas'); ?></strong></td>
						<td><?php echo h($anomalia['Anomalia']['causas_internas']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Causas Externas'); ?></strong></td>
						<td><?php echo h($anomalia['Anomalia']['causas_externas']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Atividades Associadas'); ?></strong></td>
						<td>
							<ul class="list-inner">
							
							<?php
							//var_dump($acoes[0][0]);
							//die();
							if($anomalia['Atividade']){
								foreach ($anomalia['Atividade'] as $key => $value) {
								?>
								
									<li>
									<div class="wrapper">
									<div class="text">
									<?php
									if($value["status"]==5){
										echo '<span class="icon-check fa fa-check-square-o"></span>';
									}
									
									 
										if($value['marco']==1){
										?>
											
											
											<abbr style='font-size: 16px;' title='<?php echo $value["data_inicio_previsto"]." a ".$value["data_fim_previsto"]?>'>
											<?php 
												if($visualizarAtividade){
													echo $this->Html->link($value['titulo'], array('controller' => 'Atividade', 'action' => 'visualizar', $value['id']));
												}else{
													echo $value['titulo'];
												}
											?>
											</abbr>
											 
										<?php }else{ ?>
										
											<abbr style='font-size: 16px;' title='<?php echo $value["data_inicio_previsto"]." a ".$value["data_fim_previsto"]?>'>
											<?php 
											if($visualizarAtividade){
												echo "&nbsp;&nbsp;&nbsp;".$this->Html->link($value['titulo'], array('controller' => 'Atividade', 'action' => 'visualizar', $value['id']));
											}else{
												echo "&nbsp;&nbsp;&nbsp;".$value['titulo'];
											}
											?>
											<abbr>
										 <?php 
										 }
										?>	
										
																			
											<?php if($value["status"]==5){
													if (strtotime(Util::inverteData($value["data_conclusao"]))-strtotime(Util::inverteData($value["data_fim_previsto"]))>604800)
													$barraProgresso="progress progress-danger progress-striped";
													elseif (strtotime(Util::inverteData($value["data_fim_previsto"]))-strtotime(Util::inverteData($value["data_conclusao"]))<604800)
													$barraProgresso="progress progress-warning progress-striped";
													else
													$barraProgresso="progress progress-success progress-striped";
												}else{
													if (time()>strtotime(Util::inverteData($value["data_fim_previsto"])))
													$barraProgresso="progress progress-danger progress-striped";
													elseif (time()-604800>strtotime(Util::inverteData($value["data_fim_previsto"])))
													$barraProgresso="progress progress-warning progress-striped";
													else
													$barraProgresso="progress progress-success progress-striped";
												}
										
									
										
										?>
									</div>									
									<div class="<?php echo $barraProgresso; ?>">
									  <div class="bar" style="width: <?php echo $value["andamento"];?>;"></div>
									</div>
									</div>
									</li>
									<?php 
									}
										}
								
							 if($adicionarAtividade){
							?>
							<div class="row-fluid" style="margin-top: 10px;">
								<button class="btn btn-mini" type="button" onclick="abrirModal(<?php echo $anomalia['Anomalia']['id']; ?>)">Adicionar</button>
							</div>
							<?php }?>
							</ul>
						&nbsp;
						</td>
					</tr>
				</tbody>				
			</table>			
		</div>
	</div>
</div>
<div id="dialog" title="Cadastrar Ação" style="display: none">
</div>
<div id="painelAnomalias" title="Painel de Anomalias" style="display: none">
</div>
<script>
function abrirModal(idAnomalia){
	var action = "<?php echo $this->webroot;?>Atividade/ajaxAdicionar/" + idAnomalia;
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
				var action = <?php echo $this->webroot; ?> + "Atividade/ajaxAdicionar/" + idAnomalia;
				$.post(
					action,
					$("#AtividadeAjaxAdicionarForm").serialize(),
					function(data){
						alert(data);
						var url = <?php echo $this->webroot; ?> + "Anomalia/" + "visualizar/" + idAnomalia;
						$(window.document.location).attr('href',url);
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