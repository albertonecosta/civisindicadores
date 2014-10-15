<div class="container">
	<h4 class="title title-section">Programas</h4>
	<?php echo $this->Form->create('Programa'); ?>	
 		<fieldset>
 			<legend>Editar Programa</legend>
 			<div class="row">
  			<div class="span6"> 				
  				<?php
  					echo $this->Form->input('id');
					echo $this->Form->input('titulo', array('label' => 'Título','class'=>'input-xlarge'));
					echo $this->Form->input('descricao', array('label' => 'Descrição', 'class'=>'input-xlarge'));
					echo $this->Form->input('data_inicio', array('label' => 'Data de Início','type' => 'text','class'=>'input-xlarge data datepicker'));
					echo $this->Form->input('data_fim', array('label' => 'Data de Fim','type' => 'text','class'=>'input-xlarge data datepicker'));
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

