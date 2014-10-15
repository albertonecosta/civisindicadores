<div class="container">
	<h4 class="title title-section">Projetos</h4>
	<?php echo $this->Form->create('Projeto'); ?>	
 		<fieldset class="projeto-fieldset">
 			<legend>Novo Projeto</legend>
 			<div class="row-fluid">
	  			<div class="span6"> 				
  				<?php
  					echo $this->Form->input('id');
					
					echo "<h4>Dados do Projeto</h4>";
					
					echo $this->Form->input('processo', array('label' => 'Código do Projeto','class'=>'input-large'));
					echo $this->Form->input('titulo', array('label' => 'Título','class'=>'input-xlarge'));
					echo $this->Form->input('programa_id', array('label' => 'Programa','class'=>'input-xlarge', 'empty' => 'Selecione o Programa','type' => 'select','options' => $programas));
					
					echo $this->Form->input('descricao', array('label' => 'Descrição', 'class'=>'input-xlarge textarea'));
					
					echo $this->Form->input('motivacao', array('label' => 'Motivações','class'=>'input-xlarge textarea'));
					
					echo $this->Form->input('url_projeto', array('label' => 'Site do Projeto','class'=>'input-xlarge'));
					
					echo $this->Form->input('tamanho', array('label' => 'Tamanho','class'=>'input-xlarge', 'empty' => 'Selecione o Tamanho','type' => 'select','options' => $tamanho));
					echo $this->Form->input('perspectiva_temporal', array('label' => 'Perspectiva Temporal','class'=>'input-xlarge', 'empty' => 'Selecione a Perspectiva Temporal','type' => 'select','options' => $perspectiva_temporal));
					echo $this->Form->input('complexidade', array('label' => 'Complexidade','class'=>'input-xlarge', 'empty' => 'Selecione a Complexidade','type' => 'select','options' => $complexidade));
					echo $this->Form->input('importancia_politica', array('label' => 'Importância','class'=>'input-xlarge', 'empty' => 'Selecione a Importância Política','type' => 'select','options' => $importancia_politica));
					
					echo $this->Form->input('objetivos', array('label' => 'Alinhamento Estratégico',
															   'class'=>'input-xlarge',
															   'type' => 'select', 
															    'multiple' => 'multiple',
															    'options' => $objetivos,															    
															    'div' => array(
														        	'class' => 'input label-block'
														    	)));										
					
					
				?>
			</div>
			<div class="span6">
				<?php
					echo "<h4>Partes Interessadas/Envolvidas (Stakeholders)</h4>";
					
					echo $this->Form->input('area_executora', array('label' => 'Área Executora','class'=>'input-xlarge'));
					echo $this->Form->input('usuario_id', array('label' => 'Responsável (Líder do Projeto)','class'=>'input-xlarge', 'empty' => 'Selecione o Responsável','type' => 'select','options' => $usuarios));					
					
					echo $this->Form->input('area_cliente', array('label' => 'Área Cliente','class'=>'input-xlarge'));
					echo $this->Form->input('patrocinadores', array('label' => 'Clientes',
																'class'=>'input-xlarge',
																'type' => 'select',
																'multiple' => 'multiple',
																'options' => $pessoas,																
																'div' => array(
																		'class' => 'input label-block'
																)));
					
					
					echo $this->Form->input('patrocinador', array('label' => 'Patrocinador','class'=>'input-xlarge'));
					echo $this->Form->input('parceiros', array('label' => 'Parceiros','class'=>'input-xlarge textarea'));
					
					
					echo "<br /><h4>Planejamento</h4>";
					
					echo $this->Form->input('data_inicio_previsto', array('label' => 'Data de Início','type' => 'text','class'=>'input-xlarge data datepicker'));
					echo $this->Form->input('data_fim_previsto', array('label' => 'Previsão de Fim','type' => 'text','class'=>'input-xlarge data datepicker'));
					
					echo $this->Form->input('custo', array('label' => 'Custo previsto','type' => 'text','class'=>'input-xlarge money'));
					
					echo "<br /><h4>Acompanhamento</h4>";
					
					echo $this->Form->input('gasto', array('label' => 'Gasto até o momento','type' => 'text','class'=>'input-xlarge money'));
					
					echo $this->Form->input('saude_projeto', array('label' => 'Saúde do Projeto','class'=>'input-xlarge', 'empty' => 'Selecione a Saúde do Projeto','type' => 'select','options' => $saude_projeto));
					echo $this->Form->input('situacao', array('label' => 'Situação','class'=>'input-xlarge', 'empty' => 'Selecione a Situação','type' => 'select','options' => $situacao));
					
					echo $this->Form->input('risco', array('label' => 'Riscos','class'=>'input-xlarge textarea'));
					echo $this->Form->input('resultado', array('label' => 'Resultados','class'=>'input-xlarge textarea'));
					
					echo $this->Form->input('concluido', array('label' => 'Concluído','type' => 'select','class'=>'input-xlarge', 'options' => array(Util::COMPLETO => 'Sim', Util::INCOMPLETO => 'Não'), 'empty' => 'Selecione'));
					echo $this->Form->input('data_conclusao', array('label' => 'Data de Conclusão','type' => 'text','class'=>'input-xlarge data datepicker'));
					
					/*
					echo "<fieldset>";
					echo "<legend>Notificações</legend>";
					
					echo $this->Form->input('email_acao', array('label' => 'Enviar email de atualização de Ações','type' => 'select','class'=>'input-xlarge', 'options' => array(Util::ENVIAR_EMAIL => 'Sim', Util::NAO_ENVIAR_EMAIL => 'Não'), 'empty' => 'Selecione'));
					echo $this->Form->input('email_tarefa', array('label' => 'Enviar email de atualização de Tarefas','type' => 'select','class'=>'input-xlarge', 'options' => array(Util::ENVIAR_EMAIL => 'Sim', Util::NAO_ENVIAR_EMAIL => 'Não'), 'empty' => 'Selecione'));
					
					echo "</fieldset>";
					*/
				?>
			</div>
  			</div>
 			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
 		</fieldset>
</div>

<script type="text/javascript" src="<?php echo $this->base?>/js/libs/jquery.lwMultiSelect.min.js"></script>
<script type="text/javascript" src="<?php echo $this->base?>/js/jquery-te-1.4.0.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo $this->base?>/css/jquery-te-1.4.0.css">
<script type="text/javascript" src="<?php echo $this->base?>/js/libs/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="<?php echo $this->base?>/js/libs/jquery.maskedinput.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
	//initialize the element
    $('#ProjetoObjetivos').lwMultiSelect();
    $('#ProjetoPatrocinadores').lwMultiSelect();
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
