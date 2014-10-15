<div class="container">
	<?php echo $this->Form->create('Setor'); ?>	
 		<fieldset>
 			<legend>Cadastro Setor</legend>
 			<div class="row">
  			<div class="span12">  				
  				<?php
  					echo $this->Form->input('id', array('type' => 'hidden'));
					echo $this->Form->input('titulo', array('label' => 'Título', 'class'=>'input-xlarge'));
					echo $this->Form->input('tipo', array('class'=>'input-xlarge', 'type' => 'select', 'options' => array(Util::TIPO_INFERIOR => 'Inferior', Util::TIPO_SUPERIOR => 'Superior')));
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
