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
?>
<script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });
  $("#indicadores").treetable({ expandable: true});
  $("#metas").treetable({ expandable: true});
  $("#realizados").treetable({ expandable: true});
</script>

<?php if(empty($objetivoPaiId)){ $objetivoPaiId = $projetoId; }?>

<style>
	.exibir_valores{
		margin-right: 10px; 
		margin-bottom: 10px; 
		float: right
	}
</style>
<ul class="thumbnails">
	<li class="span12">
		<div class="thumbnail">
			<?php if(count($indicadores) == 0){?>
					<p>Sem indicadores</p>					
			<?php }else{?>
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
							<th class="actions" data-hide="phone,tablet">Opções</th>
						</tr>
						</thead>
						<tbody>
					<?php 
						$bloqueados = array();
						$_SESSION['bloqueados'] = array();
						foreach($indicadores as $indicador){ ?>
						<?php
							$autorizado = false;
							foreach($indicador['IndicadorAutorizadoVisualizar'] as $value){
								if($value['usuario_id'] == $id_usuario_logado){
									$autorizado = true;									
								}
							}
							if(!$autorizado){
								$bloqueados[] = $indicador['Indicador']['id'];
								$_SESSION['bloqueados'][] = $indicador['Indicador']['id'];
							}
						?>
						<?php
							if($autorizado){
						?>						
						<tr style="border-bottom: #bebec5 solid 1px;" data-tt-id="<?php echo $objetivoPaiId . $indicador['Indicador']['id']; ?>" <?php if($indicador['Pai']['id'] != null && !in_array($indicador['Pai']['id'], $bloqueados)){ ?> data-tt-parent-id="<?php echo $objetivoPaiId . $indicador['Pai']['id']; ?>" <?php } ?>>
							<td onclick="javascript:habilitarForm(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>)">
								<a href="javascript:"><?php echo $indicador['Indicador']['titulo']; ?></a>&nbsp;
								<?php if($indicador['Pai']['id'] != null && in_array($indicador['Pai']['id'], $_SESSION['bloqueados'])){?>
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
									
									<?php foreach($indicador['IndicadorRealizado'] as $realizado){
										if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
											if($realizado['janeiro'] != "0,00"){ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 1;?>, true)">
												<span class='badge-indicador important' title="<?php echo $totalIndicador['janeiro']; ?>%">
												<?php 
												if ($anomalias>0)
													echo "<span class='sup'>$anomalias</span>"; 
												?>
												</span>
											</a>
									<?php	
											}else{ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 1;?>, true)">
												<span class='badge-indicador' title="<?php echo $totalIndicador['janeiro']; ?>%">
												<?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?>
												</span>
											</a>
									<?php }
										}
									}?>
									
								<?php }else if(($totalIndicador['janeiro'] > 0 && $totalIndicador['janeiro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['janeiro'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 1;?>, true)">
										<span class='badge-indicador important' title="<?php echo $totalIndicador['janeiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span>
									</a>
									
								<?php }else if($totalIndicador['janeiro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['janeiro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 1;?>, true)"><span class='badge-indicador warning' title="<?php echo $totalIndicador['janeiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 1;?>, true)"><span class='badge-indicador success' title="<?php echo $totalIndicador['janeiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['02'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['02'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['fevereiro'] == 0){ ?>
									
									<?php foreach($indicador['IndicadorRealizado'] as $realizado){
										if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
											if($realizado['fevereiro'] != "0,00"){ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 2;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['fevereiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php	
											}else{ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 2;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['fevereiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php }
										}
									}?>
									
								<?php }else if(($totalIndicador['fevereiro'] == 0 || $totalIndicador['fevereiro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['fevereiro'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 2;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['fevereiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['fevereiro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['fevereiro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 2;?>, true)"><span class='badge-indicador warning' title="<?php echo $totalIndicador['fevereiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 2;?>, true)"><span class='badge-indicador success' title="<?php echo $totalIndicador['fevereiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['03'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['03'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['marco'] == 0){ ?>
									
									<?php foreach($indicador['IndicadorRealizado'] as $realizado){
										if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
											if($realizado['marco'] != "0,00"){ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 3;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['marco']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php	
											}else{ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 3;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['marco']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php }
										}
									}?>
									
								<?php }else if(($totalIndicador['marco'] == 0 || $totalIndicador['marco'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['marco'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 3;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['marco']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['marco'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['marco'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 3;?>, true)"><span class='badge-indicador warning' title="<?php echo $totalIndicador['marco']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 3;?>, true)"><span class='badge-indicador success' title="<?php echo $totalIndicador['marco']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['04'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['04'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['abril'] == 0){ ?>
									
									<?php foreach($indicador['IndicadorRealizado'] as $realizado){
										if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
											if($realizado['abril'] != "0,00"){ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 4;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['abril']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php	
											}else{ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 4;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['abril']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php }
										}
									}?>
									
								<?php }else if(($totalIndicador['abril'] == 0 || $totalIndicador['abril'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['abril'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 4;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['abril']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['abril'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['abril'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 4;?>, true)"><span class='badge-indicador warning' title="<?php echo $totalIndicador['abril']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 4;?>, true)"><span class='badge-indicador success' title="<?php echo $totalIndicador['abril']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['05'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['05'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['maio'] == 0){ ?>
									
									<?php foreach($indicador['IndicadorRealizado'] as $realizado){
										if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
											if($realizado['maio'] != "0,00"){ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 5;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['maio']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php	
											}else{ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 5;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['maio']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php }
										}
									}?>
									
								<?php }else if(($totalIndicador['maio'] == 0 || $totalIndicador['maio'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['maio'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 5;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['maio']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['maio'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['maio'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 5;?>, true)"><span class='badge-indicador warning' title="<?php echo $totalIndicador['maio']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 5;?>, true)"><span class='badge-indicador success' title="<?php echo $totalIndicador['maio']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['06'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['06'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['junho'] == 0){ ?>
									
									<?php foreach($indicador['IndicadorRealizado'] as $realizado){
										if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
											if($realizado['junho'] != "0,00"){ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 6;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['junho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php	
											}else{ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 6;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['junho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php }
										}
									}?>
									
								<?php }else if(($totalIndicador['junho'] == 0 || $totalIndicador['junho'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['junho'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 6;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['junho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['junho'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['junho'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 6;?>, true)"><span class='badge-indicador warning' title="<?php echo $totalIndicador['junho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 6;?>, true)"><span class='badge-indicador success' title="<?php echo $totalIndicador['junho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['07'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['07'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['julho'] == 0){ ?>
									
									<?php foreach($indicador['IndicadorRealizado'] as $realizado){
										if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
											if($realizado['julho'] != "0,00"){ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 7;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['julho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php	
											}else{ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 7;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['julho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php }
										}
									}?>
									
								<?php }else if(($totalIndicador['julho'] == 0 || $totalIndicador['julho'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['julho'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 7;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['julho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['julho'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['julho'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 7;?>, true)"><span class='badge-indicador warning' title="<?php echo $totalIndicador['julho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 7;?>, true)"><span class='badge-indicador success' title="<?php echo $totalIndicador['julho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['08'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['08'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['agosto'] == 0){ ?>
									
									<?php foreach($indicador['IndicadorRealizado'] as $realizado){
										if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
											if($realizado['agosto'] != "0,00"){ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 8;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['agosto']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php	
											}else{ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 8;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['agosto']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php }
										}
									}?>
									
								<?php }else if(($totalIndicador['agosto'] == 0 || $totalIndicador['agosto'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['agosto'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 8;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['agosto']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['agosto'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['agosto'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 8;?>, true)"><span class='badge-indicador warning' title="<?php echo $totalIndicador['agosto']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 8;?>, true)"><span class='badge-indicador success' title="<?php echo $totalIndicador['agosto']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['09'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['09'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['setembro'] == 0){ ?>
									
									<?php foreach($indicador['IndicadorRealizado'] as $realizado){
										if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
											if($realizado['setembro'] != "0,00"){ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 9;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['setembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php	
											}else{ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 9;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['setembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php }
										}
									}?>
									
								<?php }else if(($totalIndicador['setembro'] == 0 || $totalIndicador['setembro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['setembro'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 9;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['setembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['setembro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['setembro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 9;?>, true)"><span class='badge-indicador warning' title="<?php echo $totalIndicador['setembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 9;?>, true)"><span class='badge-indicador success' title="<?php echo $totalIndicador['setembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['10'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['10'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['outubro'] == 0){ ?>
									
									<?php foreach($indicador['IndicadorRealizado'] as $realizado){
										if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
											if($realizado['outubro'] != "0,00"){ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 10;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['outubro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php	
											}else{ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 10;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['outubro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php }
										}
									}?>
									
								<?php }else if(($totalIndicador['outubro'] == 0 || $totalIndicador['outubro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['outubro'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 10;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['outubro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['outubro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['outubro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 10;?>, true)"><span class='badge-indicador warning' title="<?php echo $totalIndicador['outubro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 10;?>, true)"><span class='badge-indicador success' title="<?php echo $totalIndicador['outubro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['11'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['11'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['novembro'] == 0){ ?>
									
									<?php foreach($indicador['IndicadorRealizado'] as $realizado){
										if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
											if($realizado['novembro'] != "0,00"){ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 11;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['novembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php	
											}else{ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 11;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['novembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php }
										}
									}?>
									
								<?php }else if(($totalIndicador['novembro'] == 0 || $totalIndicador['novembro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['novembro'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 11;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['novembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['novembro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['novembro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 11;?>, true)"><span class='badge-indicador warning' title="<?php echo $totalIndicador['novembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 11;?>, true)"><span class='badge-indicador success' title="<?php echo $totalIndicador['novembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['12'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['12'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['dezembro'] == 0){ ?>
									
									<?php foreach($indicador['IndicadorRealizado'] as $realizado){
										if($realizado['ano'] == $_SESSION['ano_selecionado_indicadores']){
											if($realizado['dezembro'] != "0,00"){ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 12;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['dezembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php	
											}else{ ?>
											<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 12;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['dezembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									<?php }
										}
									}?>									

								<?php }else if(($totalIndicador['dezembro'] == 0 || $totalIndicador['dezembro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['dezembro'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 12;?>, true)"><span class='badge-indicador important' title="<?php echo $totalIndicador['dezembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['dezembro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['dezembro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 12;?>, true)"><span class='badge-indicador warning' title="<?php echo $totalIndicador['dezembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>, <?php echo 12;?>, true)"><span class='badge-indicador success' title="<?php echo $totalIndicador['dezembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td><?php echo Util::getMetaTotal($indicador); ?></td>
							<td><?php echo Util::getProjecao($indicador); ?></td>
							<td><?php echo Util::getMetaTotal($indicador, true); ?></td>
							<td class="actions"><a href="javascript:exibirGrafico(<?php echo $objetivoPaiId; ?>, <?php echo $indicador['Indicador']['id']; ?>)" id="exibir_grafico"><i class="fa fa-bar-chart-o" title="Gráficos"></i></a></td>
							<form action="#" id="form_grafico_<?php echo $indicador['Indicador']['id']; ?>">
								<input type="hidden" name="data[Indicador][id]" value="<?php echo $indicador['Indicador']['id']; ?>" />
								<input type="hidden" name="data[Objetivo][id]" value="<?php echo $indicador['Indicador']['objetivo_id']; ?>" />
							</form>
							<?php } 
								} ?>
						</tr>
						<?php
							}
						?>
					<?php } ?>
					</tbody>
				</table>
				<?php foreach($indicadores as $indicador){ ?>
				<div class="row-fluid" style="display: none" id="grafico_<?php echo $objetivoPaiId; ?>_<?php echo $indicador['Indicador']['id']; ?>">
					<div class="span11" id="exibir_grafico_<?php echo $objetivoPaiId; ?>_<?php echo $indicador['Indicador']['id']; ?>" style="height:400px;">
					</div>					
				</div>
				<?php } ?>
				<div class="row-fluid">
					<div class="span10"></div>
					<div class="span2" >
						<button class="btn btn-primary exibir_valores" id="exibir_valores_<?php echo $objetivoPaiId; ?>">Exibir Valores</button>
					</div>					
				</div>
				<div class="row-fluid" id="form_indices_<?php echo $objetivoPaiId; ?>">
					<form action="<?php echo $this->webroot;?>MapaEstrategico/salvar" id="MapaEstrategicoSalvarForm<?php echo $objetivoPaiId; ?>">
						<div class="row-fluid" style='display: none' id="valores_<?php echo $objetivoPaiId; ?>">
						<div class="span12">
							<table class="footable table table-hover table-condensed" id="metas">
								<thead>
								<tr>
									<th data-class="expand">Meta</th>
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
								</tr>
								</thead>
								<tbody>
								<?php foreach($indicadores as $indicador){ ?>
									<?php
										$autorizadoMeta = "readonly";
										foreach($indicador['IndicadorResponsavelMeta'] as $value){
											
											if($value['usuario_id'] == $id_usuario_logado){
												$autorizadoMeta = "";
												break;																
											}else{
												$autorizadoMeta = "readonly";													
											}
										}
									?>
									<?php if(count($indicador['Filhos']) > 0 ){
										$apenasLeitura = "readonly";										
									}else{
										$apenasLeitura = "";
									} ?>
									<?php if(!in_array($indicador['Indicador']['id'], $bloqueados)){ ?>
										<?php if($indicador['Pai']['id'] == null  || in_array($indicador['Pai']['id'], $bloqueados)){ ?>
										<tr style="border-bottom: #bebec5 solid 1px" data-tt-id="<?php echo $objetivoPaiId . $indicador['Indicador']['id']; ?>" <?php if($indicador['Pai']['id'] != null && !in_array($indicador['Pai']['id'], $bloqueados)){ ?> data-tt-parent-id="<?php echo $objetivoPaiId . $indicador['Pai']['id']; ?>" <?php } ?>>
											<?php 
											if(count($indicador['IndicadorMeta']) > 0){
												foreach($indicador['IndicadorMeta'] as $indicadorMeta){
													if($indicadorMeta['ano'] == $_SESSION['ano_selecionado_indicadores']){											
											?>										
												<td>
													<input type="hidden" name="data[<?php echo $indicador['Indicador']['id']; ?>][Indicador][id]" value="<?php echo $indicador['Indicador']['id']; ?>" />
													<input type="hidden" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][id]" value="<?php echo $indicadorMeta['id']; ?>" />
													<input type="hidden" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][indicador_id]" value="<?php echo $indicadorMeta['indicador_id']; ?>" />
													<input type="hidden" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][ano]" value="<?php echo $indicadorMeta['ano']; ?>" />
													<?php echo $indicador['Indicador']['titulo']; ?>&nbsp;
													<?php if($indicador['Pai']['id'] != null && in_array($indicador['Pai']['id'], $_SESSION['bloqueados'])){?>
														<i class="icon-question-sign" title="Sub-indicador de <?php echo $indicador['Pai']['titulo']; ?>"></i>
													<?php } ?>
												</td>
												<?php 
												if($indicador['Indicador']['tipo'] == Util::ATIVO){
													$indicadorMeta["janeiro"] = (int)$indicadorMeta["janeiro"];
													$indicadorMeta["fevereiro"] = (int)$indicadorMeta["fevereiro"];
													$indicadorMeta["marco"] = (int)$indicadorMeta["marco"];
													$indicadorMeta["abril"] = (int)$indicadorMeta["abril"];
													$indicadorMeta["maio"] = (int)$indicadorMeta["maio"];
													$indicadorMeta["junho"] = (int)$indicadorMeta["junho"];
													$indicadorMeta["julho"] = (int)$indicadorMeta["julho"];
													$indicadorMeta["agosto"] = (int)$indicadorMeta["agosto"];
													$indicadorMeta["setembro"] = (int)$indicadorMeta["setembro"];
													$indicadorMeta["outubro"] = (int)$indicadorMeta["outubro"];
													$indicadorMeta["novembro"] = (int)$indicadorMeta["novembro"];
													$indicadorMeta["dezembro"] = (int)$indicadorMeta["dezembro"];
												}
												?>
												<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][janeiro]" value="<?php echo $indicadorMeta['janeiro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
												<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][fevereiro]" value="<?php echo $indicadorMeta['fevereiro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
												<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][marco]" value="<?php echo $indicadorMeta['marco']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
												<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][abril]" value="<?php echo $indicadorMeta['abril']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
												<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][maio]" value="<?php echo $indicadorMeta['maio']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
												<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][junho]" value="<?php echo $indicadorMeta['junho']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
												<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][julho]" value="<?php echo $indicadorMeta['julho']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
												<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][agosto]" value="<?php echo $indicadorMeta['agosto']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
												<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][setembro]" value="<?php echo $indicadorMeta['setembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
												<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][outubro]" value="<?php echo $indicadorMeta['outubro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
												<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][novembro]" value="<?php echo $indicadorMeta['novembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
												<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorMeta][dezembro]" value="<?php echo $indicadorMeta['dezembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
											<?php
													}
												}
											}
											?>
										</tr>
										<?php } ?>
									<?php } ?>
								<?php } ?>
								</tbody>
							</table>
						</div>
						<div class="row-fluid">
							<div class="span12">
								<table class="footable table table-hover table-condensed" id="realizados">
									<thead>
									<tr>
										<th data-class="expand">Realizado</th>
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
									</tr>
									</thead>
									<tbody>
									<?php foreach($indicadores as $indicador){ ?>
										<?php
											$autorizadoRealizado = "readonly";
											foreach($indicador['IndicadorResponsavelRealizado'] as $value){
												
												if($value['usuario_id'] == $id_usuario_logado){
													$autorizadoRealizado = "";
													break;																
												}else{
													$autorizadoRealizado = "readonly";													
												}
											}
										?>
										<?php if(count($indicador['Filhos']) > 0 ){
											$apenasLeitura = "readonly";
										}else{
											$apenasLeitura = "";
										} ?>
										<?php if(!in_array($indicador['Indicador']['id'], $bloqueados)){ ?>
											<?php if($indicador['Pai']['id'] == null || in_array($indicador['Pai']['id'], $bloqueados)){ ?>
											<tr style="border-bottom: #bebec5 solid 1px" data-tt-id="<?php echo $objetivoPaiId . $indicador['Indicador']['id']; ?>" <?php if($indicador['Pai']['id'] != null && !in_array($indicador['Pai']['id'], $bloqueados)){ ?> data-tt-parent-id="<?php echo $objetivoPaiId . $indicador['Pai']['id']; ?>" <?php } ?>>
												<?php 
												if(count($indicador['IndicadorRealizado']) > 0){
													foreach($indicador['IndicadorRealizado'] as $indicadorRealizado){
													if($indicadorRealizado['ano'] == $_SESSION['ano_selecionado_indicadores']){	
														
												?> 
													<td>
														<input type="hidden" name="data[<?php echo $indicador['Indicador']['id']; ?>][Indicador][id]" value="<?php echo $indicador['Indicador']['id']; ?>" />
														<input type="hidden" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][id]" value="<?php echo $indicadorRealizado['id']; ?>" />
														<input type="hidden" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][indicador_id]" value="<?php echo $indicadorRealizado['indicador_id']; ?>" />
														<input type="hidden" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][ano]" value="<?php echo $indicadorRealizado['ano']; ?>" />
														<?php echo $indicador['Indicador']['titulo']; ?>&nbsp;
														<?php if($indicador['Pai']['id'] != null && in_array($indicador['Pai']['id'], $_SESSION['bloqueados'])){?>
															<i class="icon-question-sign" title="Sub-indicador de <?php echo $indicador['Pai']['titulo']; ?>"></i>
														<?php } ?>
													</td>
													<?php 
													if($indicador['Indicador']['tipo'] == Util::ATIVO){
														$indicadorRealizado["janeiro"] = (int)$indicadorRealizado["janeiro"];
														$indicadorRealizado["fevereiro"] = (int)$indicadorRealizado["fevereiro"];
														$indicadorRealizado["marco"] = (int)$indicadorRealizado["marco"];
														$indicadorRealizado["abril"] = (int)$indicadorRealizado["abril"];
														$indicadorRealizado["maio"] = (int)$indicadorRealizado["maio"];
														$indicadorRealizado["junho"] = (int)$indicadorRealizado["junho"];
														$indicadorRealizado["julho"] = (int)$indicadorRealizado["julho"];
														$indicadorRealizado["agosto"] = (int)$indicadorRealizado["agosto"];
														$indicadorRealizado["setembro"] = (int)$indicadorRealizado["setembro"];
														$indicadorRealizado["outubro"] = (int)$indicadorRealizado["outubro"];
														$indicadorRealizado["novembro"] = (int)$indicadorRealizado["novembro"];
														$indicadorRealizado["dezembro"] = (int)$indicadorRealizado["dezembro"];
													}
													?>
													<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][janeiro]" value="<?php echo $indicadorRealizado['janeiro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
													<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][fevereiro]" value="<?php echo $indicadorRealizado['fevereiro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
													<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][marco]" value="<?php echo $indicadorRealizado['marco']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
													<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][abril]" value="<?php echo $indicadorRealizado['abril']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
													<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][maio]" value="<?php echo $indicadorRealizado['maio']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
													<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][junho]" value="<?php echo $indicadorRealizado['junho']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
													<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][julho]" value="<?php echo $indicadorRealizado['julho']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
													<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][agosto]" value="<?php echo $indicadorRealizado['agosto']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
													<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][setembro]" value="<?php echo $indicadorRealizado['setembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
													<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][outubro]" value="<?php echo $indicadorRealizado['outubro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
													<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][novembro]" value="<?php echo $indicadorRealizado['novembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
													<td><input type="text" class="input-mini <?php echo $indicador['Indicador']['tipo'] == Util::ATIVO ? '' : 'float'; ?>" name="data[<?php echo $indicador['Indicador']['id']; ?>][IndicadorRealizado][dezembro]" value="<?php echo $indicadorRealizado['dezembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
												<?php
														}
													}
												}
												?>
											</tr>
											<?php } ?>
										<?php } ?>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span10"></div>
							<div class="span2" >
								<button class="btn btn-primary exibir_valores" id="atualizar_valores_<?php echo $objetivoPaiId; ?>">Atualizar Valores</button>
							</div>
						</div>
					</form>
				</div>
			<?php } ?>
		</div>
	</li>
</ul>
<!-- <div class="row-fluid">
	<h4>Medidas</h4>
	<hr>
</div> -->
<!-- Carregamos as medidas do objetivo selecionado pelo usuario e identificamos essa div com sua id para não bugar quando o usuarios clicar pra esconder -->
<div id="medidas<?php echo $objetivoPaiId; ?>" style="display: none">
	<?php if(count($objetivos) > 0){?>
	<h4>Ações</h4>
	<hr>
	<?php } ?>
	<div class="row-fluid">
		<ul class="thumbnails">
			<?php foreach($objetivos as $objetivo){?>
			<li style='width:1000px;' id="balao<?php echo $objetivo['Objetivo']['id']; ?>">
				<a href="javascript:exibirIndicadores(<?php echo $objetivo['Objetivo']['id']; ?>)" class="thumbnail mostrar">
					<?php echo $objetivo['Objetivo']['titulo']; ?></a>	
					<!--<span class="span12" style='align:right'><button class="btn btn-mini" type="button" onclick="javascript:abrirModalAcoes(<?php echo $objetivo['Objetivo']['id']; ?>, true)">Ações</button></div>-->
			
				<div id="indicadores<?php echo $objetivo['Objetivo']['id']; ?>" style="display: none;">
				</div>
			</li>
			<?php 
			//$ordem[$objetivo['Objetivo']['id']] = $objetivo['Objetivo']['id'];
			} 
			
			?>
		</ul>
		
		<?php /* foreach($objetivos as $objetivo){ ?>
			<div id="indicadores<?php echo $objetivo['Objetivo']['id']; ?>" style="display: none;">
			</div>
		<?php }*/?>
		
		<?php
			$ordem = array(); 
			foreach($objetivos as $objetivo){
				$ordem[$objetivo['Objetivo']['id']] = $objetivo['Objetivo']['id'];
			}
		 	ksort($ordem);
		 	/*
		 	foreach($ordem as $id=>$value){ ?>
				<div id="indicadores<?php echo $id; ?>" style="display: none;">
				</div>
			<?php

			}
			*/
		?>
		
		
		
	</div>
</div>
<script>
	$(document).ready(function(){
		jQuery(".float").maskMoney({decimal:",",thousands:"."});
	});
</script>