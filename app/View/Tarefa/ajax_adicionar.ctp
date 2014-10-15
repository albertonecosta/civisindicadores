<div class="row-fluid">
	<?php echo $this->Form->create('Tarefa', array('type' => 'file')); ?>
 		<fieldset>
 			<legend>Cadastro Tarefa</legend>		
  				<?php
  					echo $this->Form->input('reuniao_id', array('type' => 'hidden', 'value' => $reuniao));
					echo $this->Form->input('titulo', array('label' => 'Título','class'=>'input-xlarge'));
					echo $this->Form->input('prioridade', array('class'=>'input-xlarge', 'type' => 'select', 'values' => $prioridades));
					echo $this->Form->input('data_inicio_previsto', array('label' => 'Data Inicial','type' => 'text','class'=>'input-xlarge data datepicker'));
					echo $this->Form->input('data_fim_previsto', array('label' => 'Data Final','type' => 'text','class'=>'input-xlarge data datepicker'));
					echo $this->Form->input('lembrete', array('label' => 'Lembrete','type' => 'text','class'=>'input-xlarge data datepicker'));
					echo $this->Form->input('responsavel_id', array('label' => 'Responsável','class'=>'input-xlarge', 'empty' => 'Selecione o Responsável','type' => 'select','options' => $usuarios));
					echo $this->Form->input('supervisor_id', array('label' => 'Supervisor','class'=>'input-xlarge', 'empty' => 'Selecione o Supervisor','type' => 'select','options' => $usuarios));
					echo $this->Form->input('status', array('label' => 'Status','class'=>'input-xlarge', 'empty' => 'Selecione o Status','type' => 'select','options' => $status));
					echo $this->Form->input('acao_id', array('label' => 'Ação','class'=>'input-xlarge', 'empty' => 'Selecione o Ação','type' => 'select','options' => $acoes));										
					echo $this->Form->input('data_conclusao', array('label' => 'Data de Conclusão','type' => 'text','class'=>'input-xlarge data datepicker'));
					echo $this->Form->input('comentario', array('label' => 'Comentário', 'class'=>'input-xlarge'));
					echo $this->Form->input('arquivo', array('class'=>'input-xlarge', 'type' => 'file'));
					echo $this->Form->input('arquivo_dir', array('type' => 'hidden'));
				?>
 			<div class="row">
 				<div class="span12">
 					<div class="form-actions">
  						<button type="button" class="btn btn-primary" id="salvar">Salvar</button>
					</div>
 				</div>
 			</div>
 		</fieldset>
 		<?php echo $this->Form->end(); ?>	
</div>
<?php
echo $this->Html->script('libs/geral');
?>
