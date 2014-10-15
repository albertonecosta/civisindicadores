<div class="container">
	<legend>Visualizar Post</legend>
	<div class="row">
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($post['Post']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Criado por'); ?></strong></td>
						<td><?php echo $this->Html->link($post['Usuario']['Pessoa']['titulo'], array('controller' => 'Usuario', 'action' => 'visualizar', $post['Usuario']['id'])); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Criado em:'); ?></strong></td>
						<td><?php echo h($post['Post']['created']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Modificado em:'); ?></strong></td>
						<td><?php echo h($post['Post']['modified']); ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<p>Mensagem:</p>
							<p><?php echo h($post['Post']['mensagem']); ?></p>
						</td>
					</tr>
				</tbody>				
			</table>			
		</div>
	</div>
	<legend>Respostas</legend>
	<div class="row">		
		<div class="span12">
			<?php foreach($filhos as $filho){ ?>
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($filho['Post']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Criado por'); ?></strong></td>
						<td><?php echo $this->Html->link($filho['Usuario']['Pessoa']['titulo'], array('controller' => 'Usuario', 'action' => 'visualizar', $post['Usuario']['id'])); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Criado em:'); ?></strong></td>
						<td><?php echo h($filho['Post']['created']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Modificado em:'); ?></strong></td>
						<td><?php echo h($filho['Post']['modified']); ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<p>Mensagem:</p>
							<p><?php echo h($filho['Post']['mensagem']); ?></p>
						</td>
					</tr>
				</tbody>				
			</table>
			<?php } ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<legend><small>Postar Comentário</small></legend>
			<form action="/indicadores/Post/adicionar" id="PostAdicionarForm" method="post" accept-charset="utf-8">
				<?php 
					echo $this->Form->input("Post.acao_id", array("type" => 'hidden', 'value' => $post['Acao']['id']));
					echo $this->Form->input("Post.post_id", array("type" => 'hidden', 'value' => $post['Post']['id']));
					echo $this->Form->input("Post.titulo", array('class'=>'input-xlarge'));
					echo $this->Form->input("Post.mensagem", array('class'=>'input-xlarge'));
					echo $this->Form->input("Post.receber_email", array('label' =>'Desejo receber um Email quando alguem responder','type' => 'checkbox', 'checked'));			
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