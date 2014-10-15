
<div class="container">
	<?php echo $this->Form->create('Reuniao'); ?>	
 		<fieldset>
 			<legend>Cadastro Reunião</legend>
 			<div class="row">
	  			<div class="span6"> 
	  				<legend>Dados Gerais</legend> 				
	  				<?php
						echo $this->Form->input('Reuniao.titulo', array('class'=>'input-xlarge'));
						echo $this->Form->input('Reuniao.local', array('class'=>'input-xlarge'));
						echo $this->Form->input('Reuniao.projeto_id', array('class'=>'input-xlarge', 'options' => $projetos, 'empty' => 'Selecione'));
						echo $this->Form->input('Reuniao.data', array('type' => 'text', 'class'=>'input-xlarge ddata datepicker'));
						echo $this->Form->input('Reuniao.pauta', array('class'=>'input-xlarge jqte-test'));
						echo $this->Form->input('Reuniao.ata', array('class'=>'input-xlarge  jqte-test'));
						echo $this->Form->input('Reuniao.observacao', array('class'=>'input-xlarge jqte-test'));						
					?>
					
					<?php
						echo $this->Form->input('Reuniao.hora_inicio', array('class'=>'input-xlarge hora'));
						echo $this->Form->input('Reuniao.hora_fim', array('class'=>'input-xlarge hora'));
					?>
	  			</div>
	  			<div class="span6">
	  				<legend>Informações sobre participantes</legend>
	  				<?php
	  					echo $this->Form->input('ReuniaoParticipante.participantes', array('class'=>'input-xlarge', 'options' => $usuarios, 'multiple' => 'multiple'));
	  					echo $this->Form->input('ReuniaoConhecedor.conhecedores', array('class'=>'input-xlarge', 'options' => $usuarios, 'multiple' => 'multiple'));
	  					echo $this->Form->input('ReuniaoEmailExterno.emails', array('class'=>'input-xlarge', 'type' => 'textarea'));
					?>
					<span class="label label-warning" style="margin-bottom: 5px">Obs: Separe os emails com vírgula.</span>
					<?php
	  					echo $this->Form->input('Reuniao.convidados_externos', array('class'=>'input-xlarge'));
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
<script type="text/javascript" src="<?php echo $this->base?>/js/libs/geral.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->base?>/js/jquery-te-1.4.0.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo $this->base?>/css/jquery-te-1.4.0.css">

<script type="text/javascript">
  $(document).ready(function() {
    //initialize the element
    $('#ReuniaoParticipanteParticipantes').lwMultiSelect();
    $('#ReuniaoConhecedorConhecedores').lwMultiSelect();    
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