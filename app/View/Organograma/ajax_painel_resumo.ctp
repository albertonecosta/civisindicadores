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
<div class="row-fluid" style="margin-bottom: 20px;">
	<div class="span4">
		<center>
			<img class='novaImagem'  src="<?php echo $this->webroot."files/usuario/".$usuario['Usuario']['diretorio_imagem_perfil']."/"."medio_".$usuario['Usuario']['imagem_perfil']; ?>">
		</center>
	</div>
	<div class="span8">
		<dl>
			<dt>Nome:</dt>
			<dd><?php echo $usuario['Pessoa']['titulo']; ?></dd>
			<dt>Cargo:</dt>
			<dd><?php echo $usuario['Cargo']['titulo']; ?> (<?php echo $usuario['Setor']['titulo']; ?>)</dd>
		</dl>
		
		
	</div>
</div>
<div class="row-fluid">
	<div class="tabbable"> <!-- Only required for left/right tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab">Projetos</a></li>				
			<li><a href="#tab2" data-toggle="tab">Indicadores</a></li>
			<li><a href="#tab3" data-toggle="tab">Tarefas</a></li>
			<li><a href="#tab4" data-toggle="tab">Atividades</a></li>
			<li><a href="#tab5" data-toggle="tab">Anomalias</a></li>
			<li><a href="#tab6" data-toggle="tab">Descrição</a></li>
			<li><a href="#tab7" data-toggle="tab">Procedimentos</a></li>
		</ul>
		<div class="tab-content">
		<div class="tab-pane active" id="tab1">
				<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
					<thead>
						<th>Título</th>
						<th>Data de Início</th>
						<th>Data de Fim</th>
						<th>Custo</th>
					</thead>
					<tbody>
						<?php foreach($usuario['ProjetoResponsavel'] as $projeto){ ?>
							<tr>
								<td><?php echo $this->Html->link($projeto['titulo'], array('controller' => 'Projeto', 'action' => 'visualizar', $projeto['id']), array('target' => '_blank')); ?></td>
								<td><?php echo Util::inverteData($projeto['data_inicio_previsto']); ?></td>
								<td><?php echo Util::inverteData($projeto['data_fim_previsto']); ?></td>
								<td><?php echo $projeto['moeda']." ".number_format($projeto['custo'],2,',','.'); ?></td>
							</tr>
						<?php } ?>
					</tbody>					
				</table>
			</div>
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
						foreach($indicadores as $indicador){ ?>					
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

									<a href="javascript:resumoIndicador(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 1;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['janeiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['janeiro'] > 0 && $totalIndicador['janeiro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['janeiro'] < 0){ ?>
									
									<a href="javascript:resumoIndicador(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 1;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['janeiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['janeiro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['janeiro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:resumoIndicador(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 1;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['janeiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:resumoIndicador(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 1;?>, true)"><span class='badge-indicador  success' title="<?php echo $totalIndicador['janeiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['02'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['02'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['fevereiro'] == 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 2;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['fevereiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['fevereiro'] == 0 || $totalIndicador['fevereiro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['fevereiro'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 2;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['fevereiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['fevereiro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['fevereiro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 2;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['fevereiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 2;?>, true)"><span class='badge-indicador  success' title="<?php echo $totalIndicador['fevereiro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['03'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['03'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['marco'] == 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 3;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['marco']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['marco'] == 0 || $totalIndicador['marco'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['marco'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 3;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['marco']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['marco'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['marco'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 3;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['marco']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 3;?>, true)"><span class='badge-indicador  success' title="<?php echo $totalIndicador['marco']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['04'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['04'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['abril'] == 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 4;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['abril']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['abril'] == 0 || $totalIndicador['abril'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['abril'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 4;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['abril']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['abril'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['abril'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 4;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['abril']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 4;?>, true)"><span class='badge-indicador  success' title="<?php echo $totalIndicador['abril']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['05'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['05'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['maio'] == 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 5;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['maio']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['maio'] == 0 || $totalIndicador['maio'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['maio'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 5;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['maio']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['maio'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['maio'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 5;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['maio']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 5;?>, true)"><span class='badge-indicador  success' title="<?php echo $totalIndicador['maio']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['06'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['06'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['junho'] == 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 6;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['junho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['junho'] == 0 || $totalIndicador['junho'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['junho'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 6;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['junho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['junho'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['junho'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 6;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['junho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 6;?>, true)"><span class='badge-indicador  success' title="<?php echo $totalIndicador['junho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['07'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['07'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['julho'] == 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 7;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['julho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['julho'] == 0 || $totalIndicador['julho'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['julho'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 7;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['julho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['julho'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['julho'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 7;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['julho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 7;?>, true)"><span class='badge-indicador  success' title="<?php echo $totalIndicador['julho']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['08'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['08'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['agosto'] == 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 8;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['agosto']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['agosto'] == 0 || $totalIndicador['agosto'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['agosto'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 8;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['agosto']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['agosto'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['agosto'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 8;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['agosto']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 8;?>, true)"><span class='badge-indicador  success' title="<?php echo $totalIndicador['agosto']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['09'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['09'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['setembro'] == 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 9;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['setembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['setembro'] == 0 || $totalIndicador['setembro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['setembro'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 9;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['setembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['setembro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['setembro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 9;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['setembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 9;?>, true)"><span class='badge-indicador  success' title="<?php echo $totalIndicador['setembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['10'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['10'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['outubro'] == 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 10;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['outubro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['outubro'] == 0 || $totalIndicador['outubro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['outubro'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 10;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['outubro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['outubro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['outubro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 10;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['outubro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 10;?>, true)"><span class='badge-indicador  success' title="<?php echo $totalIndicador['outubro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['11'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['11'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['novembro'] == 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 11;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['novembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['novembro'] == 0 || $totalIndicador['novembro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['novembro'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 11;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['novembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['novembro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['novembro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 11;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['novembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 11;?>, true)"><span class='badge-indicador  success' title="<?php echo $totalIndicador['novembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php } ?>							
							</td>
							<td>
								<?php if(isset($indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['12'])){
									$anomalias = $indicador['TotalAnomalias'][$_SESSION['ano_selecionado_indicadores']]['12'];
								}else{
									$anomalias = 0;
								}?>
								<?php if($totalIndicador['dezembro'] == 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 12;?>, true)"><span class='badge-indicador' title="<?php echo $totalIndicador['dezembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if(($totalIndicador['dezembro'] == 0 || $totalIndicador['dezembro'] <= $indicador['Faixa']['limite_vermelho']) || $totalIndicador['dezembro'] < 0){ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 12;?>, true)"><span class='badge-indicador  important' title="<?php echo $totalIndicador['dezembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else if($totalIndicador['dezembro'] > $indicador['Faixa']['limite_vermelho'] && $totalIndicador['dezembro'] <= $indicador['Faixa']['limite_amarelo']){?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 12;?>, true)"><span class='badge-indicador  warning' title="<?php echo $totalIndicador['dezembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
								<?php }else{ ?>
									
									<a href="javascript:abrirModal(<?php echo $indicador['Indicador']['id']; ?>, <?php echo 12;?>, true)"><span class='badge-indicador  success' title="<?php echo $totalIndicador['dezembro']; ?>%"><?php if ($anomalias>0) 	echo "<span class='sup'>$anomalias</span>";	?></span></a>
									
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
			<div class="tab-pane" id="tab3">
				<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
					<thead>
						<th>Título</th>
						<th>Responsável</th>
						<th>Data Inicio</th>
						<th>Data Fim</th>
						<th>Status</th>
					</thead>
					<tbody>
						<?php foreach($usuario['TarefaResponsavel'] as $tarefa){ ?>
							<tr>
								<td><?php echo $this->Html->link($tarefa['titulo'], array('controller' => 'Tarefa', 'action' => 'visualizar', $tarefa['id']), array('target' => '_blank')); ?></td>
								<td><?php echo $this->Html->link($usuario['Pessoa']['titulo'], array('controller' => 'Usuario', 'action' => 'visualizar', $usuario['Usuario']['id']), array('target' => '_blank')); ?></td>
								<td><?php echo Util::inverteData($tarefa['data_inicio_previsto']); ?></td>
								<td><?php echo Util::inverteData($tarefa['data_fim_previsto']); ?></td>
								<td><?php echo Util::getStatus($tarefa['status']); ?></td>
							</tr>
						<?php } ?>
					</tbody>					
				</table>
			</div>
			<div class="tab-pane" id="tab4">
				<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
					<thead>
						<th>Título</th>
						<th>Responsável</th>
						<th>Data Inicio</th>
						<th>Data Fim</th>
						<th>Concluído</th>
					</thead>
					<tbody>
						<?php foreach($usuario['AtividadeResponsavel'] as $atividade){ ?>
							<tr>
								<td><?php echo $this->Html->link($atividade['titulo'], array('controller' => 'Atividade', 'action' => 'visualizar', $atividade['id']), array('target' => '_blank')); ?></td>
								<td><?php echo $this->Html->link($usuario['Pessoa']['titulo'], array('controller' => 'Usuario', 'action' => 'visualizar', $usuario['Usuario']['id']), array('target' => '_blank')); ?></td>
								<td><?php echo Util::inverteData($atividade['data_inicio_previsto']); ?></td>
								<td><?php echo Util::inverteData($atividade['data_fim_previsto']); ?></td>
								<td><?php echo $atividade['concluido'] == Util::COMPLETO ? "Sim" : "Não"; ?></td>
							</tr>
						<?php } ?>
					</tbody>					
				</table>				
			</div>
			<div class="tab-pane" id="tab5">
				<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
					<thead>
						<th>Justificativa</th>
						<th>Data</th>
						<th>Causas internas</th>
						<th>Atividades</th>
					</thead>
					<tbody>
						<?php foreach($anomaliasAssociadas as $anomalia){
								foreach ($anomalia as $key => $value) { ?>
						<tr>
							<td><?php echo $value['identificacao_problema']; ?></td>
							<td><?php echo $value['data']; ?></td>
							<td><?php echo $value['causas_internas']; ?></td>
							<td width="7%" nowrap="nowrap" align="center">
								
								<a href="javascript:abrirPainelAnomalia(<?php echo $value['id']; ?>)"><i class="icon-fullscreen" title="Painel de Anomalia"></i></a>
								
							</td>
						</tr>
						<?php }
							} ?>
					</tbody>					
				</table>
			</div>
			<div class="tab-pane" id="tab6">
				<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
					<thead>
						<th>Nome</th>
						<th>Setor</th>
						<th>Cargo</th>
						<th>Descrição do cargo</th>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $this->Html->link($usuario['Pessoa']['titulo'], array('controller' => 'Usuario', 'action' => 'visualizar', $usuario['Usuario']['id']), array('target' => '_blank')); ?></td>
							<td><?php echo $usuario['Setor']['titulo']; ?></td>
							<td><?php echo $usuario['Cargo']['titulo']; ?></td>
							<td><?php echo $usuario['Cargo']['descricao']; ?></td>
						</tr>
					</tbody>					
				</table>
			</div>
			<div class="tab-pane" id="tab7">
				<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
					<thead>
						<th>Título</th>
						<th>Resultado Esperado</th>
						<th>Passos</th>
						<th>Requisitos</th>
						<th>Patrocinador</th>
					</thead>
					<tbody>
						<?php foreach($usuario['Procedimento'] as $procedimento){ ?>
							<tr>
								<td><?php echo $this->Html->link($procedimento['titulo'], array('controller' => 'Procedimento', 'action' => 'visualizar', $procedimento['id']), array('target' => '_blank')); ?></td>
								<td><?php echo $procedimento['resultado_esperado']; ?></td>
								<td><?php echo $procedimento['passo']; ?></td>
								<td><?php echo $procedimento['requisito']; ?></td>
								<td><?php echo $this->Html->link($usuario['Pessoa']['titulo'], array('controller' => 'Usuario', 'action' => 'visualizar', $usuario['Usuario']['id']), array('target' => '_blank')); ?></td>
							</tr>
						<?php } ?>
					</tbody>					
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/indicadores/theme/Cakestrap/js/libs/highcharts.js"></script>
<script>
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
</script>