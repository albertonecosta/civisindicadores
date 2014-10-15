<div class="container">
	<?php echo $this->Form->create('Acao'); ?>	
 		<fieldset>
 			<legend>Cadastro Atividade</legend>		
  				<?php
  					echo $this->Form->input('id');
					echo $this->Form->input('titulo', array('label' => 'O que?','class'=>'input-xlarge'));
					echo $this->Form->input('projeto_id', array('label' => 'Projeto','class'=>'input-xlarge', 'empty' => 'Selecione o Projeto','type' => 'select','options' => $projetos));
					echo $this->Form->input('marco', array('label' => 'Marco','type' => 'select','class'=>'input-xlarge', 'options' => array(Util::COMPLETO => 'Sim', Util::INCOMPLETO => 'Não'), 'empty' => 'Selecione'));
					echo $this->Form->input('prioridade', array('class'=>'input-xlarge', 'type' => 'select', 'values' => $prioridades));
					echo $this->Form->input('data_inicio_previsto', array('label' => 'Data Inicial','type' => 'text','class'=>'input-xlarge data datepicker'));
					echo $this->Form->input('data_fim_previsto', array('label' => 'Data Final','type' => 'text','class'=>'input-xlarge data datepicker'));
					echo $this->Form->input('lembrete', array('label' => 'Lembrete','type' => 'text','class'=>'input-xlarge data datepicker'));
					echo $this->Form->input('responsavel_id', array('label' => 'Responsável','class'=>'input-xlarge', 'empty' => 'Selecione o Responsável','type' => 'select','options' => $usuarios));
					echo $this->Form->input('supervisor_id', array('label' => 'Supervisor','class'=>'input-xlarge', 'empty' => 'Selecione o Supervisor','type' => 'select','options' => $usuarios));
					echo $this->Form->input('status', array('label' => 'Status','class'=>'input-xlarge', 'empty' => 'Selecione o Status','type' => 'select','options' => $status));
					echo $this->Form->input('andamento', array('label' => 'Andamento','class'=>'input-xlarge','type' => 'select','options' => $andamento));
					echo $this->Form->input('data_conclusao', array('label' => 'Data de Conclusão','type' => 'text','class'=>'input-xlarge data datepicker'));
				//	echo $this->Form->input('acao_id', array('label' => 'Subitem de?','class'=>'input-xlarge', 'empty' => 'Selecione','type' => 'select','options' => $acoes));
					echo $this->Form->input('observacao', array('label' => 'Comentário','class'=>'input-xlarge jqte-test'));
				?>
 			<div class="row">
 				<div class="span12">
 					<div class="form-actions">
  						<button type="submit" class="btn btn-primary">Salvar</button>
					</div>
 				</div>
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
