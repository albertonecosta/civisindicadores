<div class="container">
	<?php echo $this->Form->create('Faixa'); ?>	
 		<fieldset>
 			<legend>Cadastro Faixa</legend>
 			<div class="row">
  			<div class="span12">  				
  				<?php
					echo $this->Form->input('titulo', array('class'=>'input-xlarge'));
					echo $this->Form->input('limite_vermelho', array('class'=>'input-xlarge float', 'type' => 'text'));
					echo $this->Form->input('limite_amarelo', array('class' => 'input-xlarge float', 'type' => 'text'));
				?>
  			</div>
 			</div>
 			<div class="row">
 				<div class="span12">
 					<div class="form-actions">
  						<button type="submit" class="btn btn-primary">Salvar</button>
					</div>
 				</div>
 			</div>
 		</fieldset>
</div>
