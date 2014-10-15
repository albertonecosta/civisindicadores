<div class="container">
	<?php echo $this->Form->create('Departamento'); ?>	
 		<fieldset>
 			<legend>Cadastro Departamento</legend>
 			<div class="row">
  			<div class="span12">  				
  				<?php
  					echo $this->Form->input('id', array('type' => 'hidden'));
					echo $this->Form->input('titulo', array('class'=>'input-xlarge'));
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
