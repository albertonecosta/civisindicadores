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
<?php 
//Lógica usada para saber se o indicador clicado pelo User tem filhos
if(count($indicadorPai['Filhos']) > 0 && !in_array($indicadorPai['Filhos'][0]['id'], $_SESSION['bloqueados'])){ 
?>
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
		<?php foreach($indicadorPai['Filhos'] as $indicador){ ?>
			<?php
				$autorizado = false;
				foreach($indicador['IndicadorAutorizadoVisualizar'] as $value){
					if($value['usuario_id'] == $id_usuario_logado){
						$autorizado = true;									
					}
				}
				if(!$autorizado){
					$bloqueados[] = $indicador['Indicador']['id'];
				}
			?>
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
			<?php if($autorizado){ ?>
			<tr style="border-bottom: #bebec5 solid 1px" data-tt-id="<?php echo $objetivoPaiId . $indicador['id']; ?>" <?php if($indicador['Pai']['id'] != null){ ?> data-tt-parent-id="<?php echo $objetivoPaiId . $indicador['Pai']['id']; ?>" <?php } ?>>
				<?php 
				if(count($indicador['IndicadorMeta']) > 0){
					foreach($indicador['IndicadorMeta'] as $indicadorMeta){
						if($indicadorMeta['ano'] == $ano){											
				?>										
					<td>
						<input type="hidden" name="data[<?php echo $indicador['id']; ?>][Indicador][id]" value="<?php echo $indicador['id']; ?>" />
						<input type="hidden" name="data[<?php echo $indicador['id']; ?>][Indicador][pai_id]" value="<?php echo $indicador['Pai']['id']; ?>" />
						<input type="hidden" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][id]" value="<?php echo $indicadorMeta['id']; ?>" />
						<input type="hidden" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][indicador_id]" value="<?php echo $indicadorMeta['indicador_id']; ?>" />
						<input type="hidden" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][ano]" value="<?php echo $indicadorMeta['ano']; ?>" />
						<?php echo $indicador['titulo']; ?>&nbsp;
						<?php if($indicador['Pai']['id'] != null && in_array($indicador['Pai']['id'], $_SESSION['bloqueados'])){?>
							<i class="icon-question-sign" title="Sub-item de <?php echo $indicador['Pai']['titulo']; ?>"></i>
						<?php } ?>
					</td>
					<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][janeiro]" value="<?php echo $indicadorMeta['janeiro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
					<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][fevereiro]" value="<?php echo $indicadorMeta['fevereiro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
					<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][marco]" value="<?php echo $indicadorMeta['marco']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
					<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][abril]" value="<?php echo $indicadorMeta['abril']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
					<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][maio]" value="<?php echo $indicadorMeta['maio']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
					<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][junho]" value="<?php echo $indicadorMeta['junho']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
					<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][julho]" value="<?php echo $indicadorMeta['julho']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
					<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][agosto]" value="<?php echo $indicadorMeta['agosto']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
					<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][setembro]" value="<?php echo $indicadorMeta['setembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
					<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][outubro]" value="<?php echo $indicadorMeta['outubro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
					<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][novembro]" value="<?php echo $indicadorMeta['novembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
					<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorMeta][dezembro]" value="<?php echo $indicadorMeta['dezembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
				<?php
						}
					}
				}
				?>
			</tr>
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
			<?php foreach($indicadorPai['Filhos'] as $indicador){ ?>
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
				<?php if($autorizado){ ?>
				<tr style="border-bottom: #bebec5 solid 1px" data-tt-id="<?php echo $objetivoPaiId . $indicador['id']; ?>" <?php if($indicador['Pai']['id'] != null){ ?> data-tt-parent-id="<?php echo $objetivoPaiId . $indicador['Pai']['id']; ?>" <?php } ?>>
					<?php 
					if(count($indicador['IndicadorRealizado']) > 0){
						foreach($indicador['IndicadorRealizado'] as $indicadorRealizado){
						if($indicadorRealizado['ano'] == $ano){	
							
					?> 
						<td>
							<input type="hidden" name="data[<?php echo $indicador['id']; ?>][Indicador][id]" value="<?php echo $indicador['id']; ?>" />
							<input type="hidden" name="data[<?php echo $indicador['id']; ?>][Indicador][pai_id]" value="<?php echo $indicador['Pai']['id']; ?>" />
							<input type="hidden" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][id]" value="<?php echo $indicadorRealizado['id']; ?>" />
							<input type="hidden" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][indicador_id]" value="<?php echo $indicadorRealizado['indicador_id']; ?>" />
							<input type="hidden" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][ano]" value="<?php echo $indicadorRealizado['ano']; ?>" />
							<?php echo $indicador['titulo']; ?>&nbsp;
							<?php if($indicador['Pai']['id'] != null && in_array($indicador['Pai']['id'], $_SESSION['bloqueados'])){?>
								<i class="icon-question-sign" title="Sub-item de <?php echo $indicador['Pai']['titulo']; ?>"></i>
							<?php } ?>
						</td>
						<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][janeiro]" value="<?php echo $indicadorRealizado['janeiro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
						<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][fevereiro]" value="<?php echo $indicadorRealizado['fevereiro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
						<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][marco]" value="<?php echo $indicadorRealizado['marco']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
						<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][abril]" value="<?php echo $indicadorRealizado['abril']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
						<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][maio]" value="<?php echo $indicadorRealizado['maio']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
						<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][junho]" value="<?php echo $indicadorRealizado['junho']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
						<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][julho]" value="<?php echo $indicadorRealizado['julho']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
						<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][agosto]" value="<?php echo $indicadorRealizado['agosto']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
						<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][setembro]" value="<?php echo $indicadorRealizado['setembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
						<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][outubro]" value="<?php echo $indicadorRealizado['outubro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
						<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][novembro]" value="<?php echo $indicadorRealizado['novembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
						<td><input type="text" class="input-mini float" name="data[<?php echo $indicador['id']; ?>][IndicadorRealizado][dezembro]" value="<?php echo $indicadorRealizado['dezembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
					<?php
							}
						}
					}
					?>
				</tr>
				<?php } ?>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</form>
<?php }else{ ?>
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
					<?
						$autorizado = false;
						foreach($indicadorPai['IndicadorAutorizadoVisualizar'] as $value){
							if($value['usuario_id'] == $id_usuario_logado){
								$autorizado = true;									
							}
						}
						if(!$autorizado){
							$bloqueados[] = $indicador['Indicador']['id'];
						}
					?>
					<?php
						$autorizadoMeta = "readonly";
						foreach($indicadorPai['IndicadorResponsavelMeta'] as $value){
							
							if($value['usuario_id'] == $id_usuario_logado){
								$autorizadoMeta = "";
								break;																
							}else{
								$autorizadoMeta = "readonly";													
							}
						}
					?>
					<?php if(count($indicadorPai['Filhos']) > 0 ){
						$apenasLeitura = "readonly";
					}else{
						$apenasLeitura = "";
					} ?>
					<tr style="border-bottom: #bebec5 solid 1px" data-tt-id="<?php echo $objetivoPaiId . $indicadorPai['Indicador']['id']; ?>" <?php if($indicadorPai['Pai']['id'] != null){ ?> data-tt-parent-id="<?php echo $objetivoPaiId . $indicadorPai['Pai']['id']; ?>" <?php } ?>>
						<?php 
						if(count($indicadorPai['IndicadorMeta']) > 0){
							foreach($indicadorPai['IndicadorMeta'] as $indicadorPaiMeta){
								if($indicadorPaiMeta['ano'] == $_SESSION['ano_selecionado_indicadores']){											
						?>										
							<td>
								<input type="hidden" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][Indicador][id]" value="<?php echo $indicadorPai['Indicador']['id']; ?>" />
								<input type="hidden" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][Indicador][pai_id]" value="<?php echo $indicadorPai['Pai']['id']; ?>" />
								<input type="hidden" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][id]" value="<?php echo $indicadorPaiMeta['id']; ?>" />
								<input type="hidden" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][indicador_id]" value="<?php echo $indicadorPaiMeta['indicador_id']; ?>" />
								<input type="hidden" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][ano]" value="<?php echo $indicadorPaiMeta['ano']; ?>" />
								<?php echo $indicadorPai['Indicador']['titulo']; ?>&nbsp;
								<?php if($indicadorPai['Pai']['id'] != null){?>
									<i class="icon-question-sign" title="Sub-item de <?php echo $indicadorPai['Pai']['titulo']; ?>"></i>
								<?php } ?>
							</td>
							<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][janeiro]" value="<?php echo $indicadorPaiMeta['janeiro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
							<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][fevereiro]" value="<?php echo $indicadorPaiMeta['fevereiro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
							<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][marco]" value="<?php echo $indicadorPaiMeta['marco']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
							<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][abril]" value="<?php echo $indicadorPaiMeta['abril']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
							<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][maio]" value="<?php echo $indicadorPaiMeta['maio']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
							<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][junho]" value="<?php echo $indicadorPaiMeta['junho']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
							<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][julho]" value="<?php echo $indicadorPaiMeta['julho']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
							<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][agosto]" value="<?php echo $indicadorPaiMeta['agosto']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
							<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][setembro]" value="<?php echo $indicadorPaiMeta['setembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
							<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][outubro]" value="<?php echo $indicadorPaiMeta['outubro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
							<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][novembro]" value="<?php echo $indicadorPaiMeta['novembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
							<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorMeta][dezembro]" value="<?php echo $indicadorPaiMeta['dezembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoMeta; ?>/></td>
						<?php
								}
							}
						}
						?>
					</tr>
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
						<?php
							$autorizadoRealizado = "readonly";
							foreach($indicadorPai['IndicadorResponsavelRealizado'] as $value){
								
								if($value['usuario_id'] == $id_usuario_logado){
									$autorizadoRealizado = "";
									break;																
								}else{
									$autorizadoRealizado = "readonly";													
								}
							}
						?>
						<?php if(count($indicadorPai['Filhos']) > 0 ){
							$apenasLeitura = "readonly";
						}else{
							$apenasLeitura = "";
						} ?>
						<tr style="border-bottom: #bebec5 solid 1px" data-tt-id="<?php echo $objetivoPaiId . $indicadorPai['Indicador']['id']; ?>" <?php if($indicadorPai['Pai']['id'] != null){ ?> data-tt-parent-id="<?php echo $objetivoPaiId . $indicadorPai['Pai']['id']; ?>" <?php } ?>>
							<?php 
							if(count($indicadorPai['IndicadorRealizado']) > 0){
								foreach($indicadorPai['IndicadorRealizado'] as $indicadorPaiRealizado){
								if($indicadorPaiRealizado['ano'] == $_SESSION['ano_selecionado_indicadores']){	
									
							?> 
								<td>
									<input type="hidden" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][Indicador][id]" value="<?php echo $indicadorPai['Indicador']['id']; ?>" />
									<input type="hidden" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][Indicador][pai_id]" value="<?php echo $indicadorPai['Pai']['id']; ?>" />
									<input type="hidden" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][id]" value="<?php echo $indicadorPaiRealizado['id']; ?>" />
									<input type="hidden" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][indicador_id]" value="<?php echo $indicadorPaiRealizado['indicador_id']; ?>" />
									<input type="hidden" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][ano]" value="<?php echo $indicadorPaiRealizado['ano']; ?>" />
									<?php echo $indicadorPai['Indicador']['titulo']; ?>&nbsp;
									<?php if($indicadorPai['Pai']['id'] != null){?>
										<i class="icon-question-sign" title="Sub-item de <?php echo $indicadorPai['Pai']['titulo']; ?>"></i>
									<?php } ?>
								</td>
								<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][janeiro]" value="<?php echo $indicadorPaiRealizado['janeiro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
								<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][fevereiro]" value="<?php echo $indicadorPaiRealizado['fevereiro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
								<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][marco]" value="<?php echo $indicadorPaiRealizado['marco']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
								<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][abril]" value="<?php echo $indicadorPaiRealizado['abril']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
								<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][maio]" value="<?php echo $indicadorPaiRealizado['maio']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
								<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][junho]" value="<?php echo $indicadorPaiRealizado['junho']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
								<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][julho]" value="<?php echo $indicadorPaiRealizado['julho']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
								<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][agosto]" value="<?php echo $indicadorPaiRealizado['agosto']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
								<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][setembro]" value="<?php echo $indicadorPaiRealizado['setembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
								<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][outubro]" value="<?php echo $indicadorPaiRealizado['outubro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
								<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][novembro]" value="<?php echo $indicadorPaiRealizado['novembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
								<td><input type="text" class="input-mini float" name="data[<?php echo $indicadorPai['Indicador']['id']; ?>][IndicadorRealizado][dezembro]" value="<?php echo $indicadorPaiRealizado['dezembro']; ?>" <?php echo $apenasLeitura; ?> <?php echo $autorizadoRealizado; ?>/></td>
							<?php
									}
								}
							}
							?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</form>
<?php } ?>
<div class="row-fluid">
<div class="span10"></div>
<div class="span2" >
	<button class="btn btn-primary exibir_valores" id="atualizar_valores_<?php echo $objetivoPaiId; ?>">Atualizar Valores</button>
</div>					
</div>
<?php
echo $this->Html->script('libs/jquery.maskedinput');
echo $this->Html->script('libs/jquery.maskMoney');
echo $this->Html->script('libs/jquery-ui.min');
echo $this->Html->script('libs/geral');
?>