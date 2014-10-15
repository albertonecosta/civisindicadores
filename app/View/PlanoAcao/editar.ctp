<div class="container">
	<?php echo $this->Form->create('PlanoAcao'); ?>	
 		<fieldset>
 			<legend>Cadastro Plano Ação</legend>
 			<div class="row">
  			<div class="span12">  				
  				<?php
  					echo $this->Form->input('id');
					echo $this->Form->input('titulo', array('class'=>'input-xlarge'));
					echo $this->Form->input('acoes', array('label' => 'Ações','class'=>'input-xlarge','type' => 'select','multiple' => 'multiple','options' => $acoes, 'selected' => $selected));
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
