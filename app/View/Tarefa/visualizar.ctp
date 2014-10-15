<div class="container">
	<legend>Visualizar Tarefa</legend>
	<div class="buttons">
		<?php
		echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $tarefa['Tarefa']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
		echo "&nbsp;&nbsp;";
		echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $tarefa['Tarefa']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $tarefa['Tarefa']['id'])
				);
		?>
	</div>
	<div class="row">
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($tarefa['Tarefa']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Prioridade'); ?></strong></td>
						<td><?php echo h($tarefa['Tarefa']['prioridade']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Data Inicial'); ?></strong></td>
						<td><?php echo h($tarefa['Tarefa']['data_inicio_previsto']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Data final'); ?></strong></td>
						<td><?php echo h($tarefa['Tarefa']['data_fim_previsto']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Lembrete'); ?></strong></td>
						<td><?php echo h($tarefa['Tarefa']['lembrete']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Responsável'); ?></strong></td>
						<td><?php echo $this->Html->link($tarefa['Responsavel']['Pessoa']['titulo'], array('controller' => 'Usuario','action' => 'visualizar', $tarefa['Responsavel']['id'])); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Supervisor'); ?></strong></td>
						<td><?php echo $this->Html->link($tarefa['Supervisor']['Pessoa']['titulo'], array('controller' => 'Usuario','action' => 'visualizar', $tarefa['Supervisor']['id']));?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Status'); ?></strong></td>
						<td><?php 
							switch ($tarefa['Tarefa']['status']){
								case (Util::ATIVO):
									echo "Ativo";
									break;
								case (Util::INATIVO):
									echo "Inativo";
									break;
								case (Util::EM_ANDAMENTO):
									echo "Em Andamento";
									break;
								case (Util::AGUARDANDO_OUTRA_PESSOA):
									echo "Aguardando outra pessoa";
									break;
								case (Util::CONCLUIDO):
									echo "Concluída";
									break;
								case (Util::CANCELADO):
									echo "Cancelada";
									break;
								default:
									break;
							} ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Atividade'); ?></strong></td>
						<td><?php echo $this->Html->link($tarefa['Acao']['titulo'], array('controller' => 'Acao','action' => 'visualizar', $tarefa['Acao']['id']));?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Data de conclusão'); ?></strong></td>
						<td><?php echo h($tarefa['Tarefa']['data_conclusao']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Comentário'); ?></strong></td>
						<td><?php echo ($tarefa['Tarefa']['comentario']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Arquivo'); ?></strong></td>
						<td><a href="<?php echo BASE.DS."files".DS."tarefa".DS.$tarefa['Tarefa']['arquivo_dir'].DS.$tarefa['Tarefa']['arquivo']; ?>"><?php echo $tarefa['Tarefa']['arquivo']; ?></a></td>
					</tr>
				</tbody>				
			</table>			
		</div>
	</div>
	<legend>Fórum</legend>
	<div class="row">
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<?php
				foreach($posts as $post){ ?>
				<tr>
					<td>
						<p><?php echo $post['Post']['created']; ?></p>
						<p><strong><?php echo nl2br($post['Post']['mensagem']); ?></strong></p>
						<p><small>Criado por: <?php echo $post['Usuario']['Pessoa']['titulo'];?></small></p>
						
						<?php if(count($post['Filhos'])){?>
						<p>
							<?php foreach($post['Filhos'] as $filho){?>
								<div style="margin-left:10px; padding-left: 10px; border-left: 1px solid #CCC;">
									<p><?php echo Util::inverteData($filho['created']); ?></p>
									<p><strong><?php echo nl2br($filho['mensagem']); ?></strong></p>
									<p><small>Respondido por: <?php echo $filho['Usuario']['Pessoa']['titulo'];?></small></p>
								</div>
							<?php }?>
						</p>
						<?php }?>
						
						<p>
							<form action="<?php echo $this->webroot; ?>Post/adicionarNaTarefa" id="PostResponderNaTarefaForm" method="post" accept-charset="utf-8">
								<?php echo $this->Form->input("Post.tarefa_id", array('type' => 'hidden', 'value' => $tarefa['Tarefa']['id'])); ?>
								<?php echo $this->Form->input("Post.post_id", array('type' => 'hidden', 'value' => $post['Post']['id'])); ?>
								<?php echo $this->Form->input("Post.mensagem", array('label'=>false,'class'=>'input-xlarge', 'style'=>'height: 40px', 'placeholder'=>'Responder *')); ?>
								<div>
									<input type="submit" class="btn btn-primary">
								</div>
							</form>
						</p>
						
					</td>
				</tr>
				<?php } ?>
			</table>
		</div>		
	</div>
	<div class="row-fluid">
		<div class="span6">
			<legend><small>Criar um novo post</small></legend>
			<form action="<?php echo $this->webroot; ?>Post/adicionarNaTarefa" id="PostAdicionarNaTarefaForm" method="post" accept-charset="utf-8">
				<?php
					echo $this->Form->input("Post.tarefa_id", array('type' => 'hidden', 'value' => $tarefa['Tarefa']['id']));
					echo $this->Form->input("Post.mensagem", array('class'=>'input-xlarge'));
					//echo $this->Form->input("Post.receber_email", array('label' =>'Desejo receber um Email quando alguém responder','type' => 'checkbox', 'checked'));			
				?>
			<div class="row">
 				<div class="span12">
 					<div class="form-actions">
  						<input type="submit" class="btn btn-primary">
					</div>
 				</div>
 			</div>
 			</form>
		</div>
	</div>
</div>