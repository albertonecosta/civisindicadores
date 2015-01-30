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
<div class="row-fluid">
	<?php echo $this->Form->create('Anomalia'); ?>	
 		<fieldset>
 			<legend>Cadastro Anomalia</legend>				
  				<?php
					echo $this->Form->input('identificacao_problema', array('label' =>'Identificação do problema','class'=>'input-xlarge'));
					echo $this->Form->input('estratificacao_problema', array('label' =>'Estratificação do problema','class'=>'input-xlarge'));
					echo $this->Form->input('causas_internas', array('label' =>'Causas internas','class'=>'input-xlarge'));
					echo $this->Form->input('causas_externas', array('label' =>'Causas externas','class'=>'input-xlarge'));
					echo $this->Form->input('data', array('label' =>'Data','class'=>'input-xlarge data datepicker', 'type' => 'text','value' => $data));
					//echo $this->Form->input('indicador_id', array('label' =>'Indicador','class'=>'input-xlarge data', 'options'=>$indicadores, 'value'=>$idIndicador));
					?>
					<div class="input select required">
						<label for="AnomaliaIndicadorId">Indicador</label>
						<?php foreach($indicadores as $id=>$indicador){?>
							<?php if($id != $idIndicador) continue;?>
							<?php echo "<input type='text' readonly=readonly value='{$indicador}' />";?>
						<?php }?>
						<input type="hidden" name="data[Anomalia][indicador_id]" value="<?php echo $idIndicador;?>" />
					</div>
 			<div class="row">
 				<div class="span12">
 					<div class="form-actions">
  						<button type="button" class="btn btn-primary" id="salvar">Salvar</button>
					</div>
 				</div>
 			</div>
 		</fieldset>
</div>
<?php
echo $this->Html->script('libs/jquery.maskedinput');
echo $this->Html->script('libs/jquery.maskMoney');
echo $this->Html->script('libs/jquery-ui.min');
echo $this->Html->script('libs/geral');
?>