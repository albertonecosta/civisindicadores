<div class="container">
<h4 class="title title-section">Marcador</h4>
	<?php echo $this->Form->create('Marcador'); ?>	
 		<fieldset class="projeto-fieldset">
 			<legend>Novo Marcador</legend>
 			<div class="row-fluid">
	  			<div class="span6"> 				
	  				<?php
					echo $this->Form->input('titulo', array('class'=>'input-xlarge'));
					echo $this->Form->input('descricao', array('label' => 'Descrição','class'=>'input-xlarge jqte-test'));
				
					?>
  			</div>
  				<div class="span6">
  				<?php
					echo $this->Form->input('objetivo_id', array('label' => 'Ações',
							'class'=>'input-xlarge',
							'type' => 'select',
							'multiple' => 'multiple',
							'options' => $objetivos,
							'div' => array(
									'class' => 'input label-block'
							)));
					?>
				</div>
  			</div>
 			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
 		</fieldset>
</div>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->base?>/js/jquery-te-1.4.0.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo $this->base?>/css/jquery-te-1.4.0.css">
<script>
	$('.jqte-test').jqte();
	
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
</script>

<script type="text/javascript" src="<?php echo $this->base?>/js/libs/jquery.lwMultiSelect.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
	//initialize the element
    $('#MarcadorObjetivoId').lwMultiSelect();
  });
</script>
<script>
	$('.jqte-test').jqte();
	
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
</script>
