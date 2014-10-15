<div class="container">
	<h4 class="title title-section">Programas</h4>
	<?php echo $this->Form->create('Programa'); ?>	
 		<fieldset class="programa-fieldset">
 			<legend>Novo Programa</legend>
 			<div class="row-fluid">
	  			<div class="span6"> 				
	  				<?php
						echo $this->Form->input('titulo', array('label' => 'Título','class'=>'input-xlarge'));
						echo $this->Form->input('descricao', array('label' => 'Descrição','class'=>'input-xlarge'));
						echo $this->Form->input('data_inicio', array('label' => 'Data de Início','type' => 'text','class'=>'input-xlarge data datepicker'));
						echo $this->Form->input('data_fim', array('label' => 'Data de Fim','type' => 'text','class'=>'input-xlarge data datepicker'));
					?>
				</div>
  			</div>
 			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
 		</fieldset>
</div>
