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
					
					<label>Ação concluida?</label>
					<?php 
					echo $this->Form->input('concluido', array('legend' => false,'type' => 'radio', 'options' => array(Util::CONCLUIDO => 'sim', Util::NAO_CONCLUIDO => 'não')));
					echo $this->Form->input('data_conclusao', array('label' =>'Data de conclusão','class'=>'input-xlarge data datepicker', 'type' => 'text'));
				?>
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