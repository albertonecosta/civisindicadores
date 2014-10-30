<?php
/**
 *
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
 *
 */

// Carregamento das variáveis para controle de acesso
	$editar = $this->ControleDeAcesso->validaAcessoElemento('editar');
	$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir');
	$visualizarUsuario = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Usuario');
	$listarForum = $this->ControleDeAcesso->validaAcessoElemento('listar_forum');
	$adicionarForum = $this->ControleDeAcesso->validaAcessoElemento('adicionar_forum');
	
	$listarTarefa = $this->ControleDeAcesso->validaAcessoElemento('listar', 'Tarefa');
	$adicionarTarefa = $this->ControleDeAcesso->validaAcessoElemento('adicionar', 'Tarefa');
	$visualizarTarefa = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Tarefa');
?>
<div class="container">
		<legend>Visualizar Ação</legend>
	<div class="buttons">
		<?php
		if($editar){
		echo $this->Html->link(
					__("<i class='fa fa-edit'></i>Editar"),
					array('action' => 'editar', $acao['Acao']['id']),
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false)
				);
		echo "&nbsp;&nbsp;";
		}
		if($excluir){
		echo $this->Form->postLink(
					__("<i class='fa fa-trash'></i>Deletar"), 
					array('action' => 'excluir', $acao['Acao']['id']), 
					array('class'=>'btn btn-small btn-primary pull-right', 'escape' => false),
					__(Util::MENSAGEM_DELETAR, $acao['Acao']['id'])
				);
		}
		?>
	</div>
	<br />	
	<div class="row">
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($acao['Acao']['titulo']); ?></td>
					</tr>
									<tr>
						<td><strong><?php echo __('Marco'); ?></strong></td>
						<td> 
						<?php
						switch ($acao['Acao']['marco']){
							case (Util::ATIVO):
								echo "Sim";
								break;
							case (Util::INATIVO):
								echo "Não";
								break;
						
							default:
								break;
													} ?>
					</td>
					</tr>
									<tr>
						<td><strong><?php echo __('Prioridade'); ?></strong></td>
						<td><?php echo h($acao['Acao']['prioridade']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Data Inicial'); ?></strong></td>
						<td><?php echo h($acao['Acao']['data_inicio_previsto']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Data final'); ?></strong></td>
						<td><?php echo h($acao['Acao']['data_fim_previsto']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Lembrete'); ?></strong></td>
						<td><?php echo h($acao['Acao']['lembrete']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Responsável'); ?></strong></td>
						<td>
							<?php 
								if($visualizarUsuario){
									echo $this->Html->link($acao['Responsavel']['Pessoa']['titulo'], array('controller' => 'Usuario','action' => 'visualizar', $acao['Responsavel']['id']));
								}else{
									echo $acao['Responsavel']['Pessoa']['titulo'];
								}
							?>
						</td>
					</tr>
					<tr>
						<td><strong><?php echo __('Supervisor'); ?></strong></td>
						<td>
							<?php
								if($visualizarUsuario){
									echo $this->Html->link($acao['Supervisor']['Pessoa']['titulo'], array('controller' => 'Usuario','action' => 'visualizar', $acao['Supervisor']['id']));
								}else{
									echo $acao['Supervisor']['Pessoa']['titulo'];
								}
							?>
						</td>
					</tr>
					<tr>
						<td><strong><?php echo __('Status'); ?></strong></td>
						<td><?php 
							switch ($acao['Acao']['status']){
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
								case (Util::NAO_INICIADO):
									echo "Não Iniciada";
									break;
								case (Util::CANCELADO):
									echo "Cancelada";
									break;
								default:
									break;
							} ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Andamento'); ?></strong></td>
						<td><?php echo h($acao['Acao']['andamento']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Comentário'); ?></strong></td>
						<td><?php echo nl2br(($acao['Acao']['observacao'])); ?></td>
					</tr>
										<tr>
						<td><strong><?php echo __('Data de conclusão'); ?></strong></td>
						<td><?php echo h($acao['Acao']['data_conclusao']); ?></td>
					</tr>
					<?php if(isset($acao['Pai']['titulo'])){?>
					<tr>
						<td><strong><?php echo __('Subitem de?'); ?></strong></td>
						<td><?php echo $this->Html->link($acao['Pai']['titulo'], array('controller' => 'Acao','action' => 'visualizar', $acao['Pai']['id'])); ?></td>
					</tr>
					<?php } ?>
				</tbody>				
			</table>			
		</div>
	</div>

	<div class="row-fluid">
		<?php 
			$spanpost = "span12";
			if($listarForum || $adicionarForum){
				$spantarefa = "span6";
			}else{
				$spantarefa = "span12";
			}
		?>
		<?php if($adicionarTarefa || $listarTarefa){ $spanpost = "span6"; ?>
	
		<div class="<?php echo $spantarefa;?>">
			<div class="box box-border box-tasks">
				<div class="box-title">
					<h3 class="title"><span class="icon fa fa-tasks"></span> Tarefas</h3>
				</div>
				<div class="box-content">
					
					<?php if($listarTarefa){?>
				
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
						<?php foreach($tarefas as $tarefa){ ?>
						<tr>
							<?php 
							
									switch ($tarefa['Tarefa']['status']){
										case (Util::NAO_INICIADO):
											$tarefaStatus= "Não Iniciada";
											break;
										case (Util::EM_ANDAMENTO):
											$tarefaStatus= "Em Andamento";
											break;
										case (Util::AGUARDANDO_OUTRA_PESSOA):
											$tarefaStatus= "Aguardando outra pessoa";
											break;
										case (Util::CONCLUIDO):
											$tarefaStatus= "Concluída";
											break;
										case (Util::CANCELADO):
											$tarefaStatus= "Cancelada";
											break;
										default:
											$tarefaStatus = "";
											break;
									} 
							
							$titulo = $tarefa['Tarefa']['data_inicio_previsto'] . " - " . $tarefa['Tarefa']['titulo'] . " - " .$tarefaStatus. " - ". $tarefa['Responsavel']['Pessoa']['titulo']; ?>
							<td>
							<?php 
								if($visualizarTarefa){
									echo $this->Html->link($titulo, array('controller' => 'Tarefa', 'action' => 'visualizar', $tarefa['Tarefa']['id']));
								}else{
									echo $titulo;
								}
							?>
							</td>
						</tr>
						<?php } ?>
					</table>
					
					<?php }?>
					
					<?php if($adicionarTarefa){?>
					
					<div class="post-container">
						<legend>Criar Tarefa</legend>
						
						<form action="<?php echo $this->webroot; ?>Tarefa/adicionarNaAcao/<?php echo $acao_id;?>" id="TarefaAdicionarNaAcaoForm" method="post" accept-charset="utf-8">
							<?php
								echo $this->Form->input('Tarefa.titulo', array('label' => 'Título','class'=>'input-xlarge'));
								echo $this->Form->input('Tarefa.prioridade', array('class'=>'input-xlarge', 'type' => 'select', 'values' => $prioridades));
								echo $this->Form->input('Tarefa.data_inicio_previsto', array('label' => 'Data Inicial','type' => 'text','class'=>'input-xlarge data datepicker'));
								echo $this->Form->input('Tarefa.data_fim_previsto', array('label' => 'Data Final','type' => 'text','class'=>'input-xlarge data datepicker'));
								echo $this->Form->input('Tarefa.lembrete', array('label' => 'Lembrete','type' => 'text','class'=>'input-xlarge data datepicker'));
								echo $this->Form->input('Tarefa.responsavel_id', array('label' => 'Responsável','class'=>'input-xlarge', 'empty' => 'Selecione o Responsável','type' => 'select','options' => $usuarios));
								echo $this->Form->input('Tarefa.supervisor_id', array('label' => 'Supervisor','class'=>'input-xlarge', 'empty' => 'Selecione o Supervisor','type' => 'select','options' => $usuarios));
								echo $this->Form->input('Tarefa.status', array('label' => 'Status','class'=>'input-xlarge', 'empty' => 'Selecione o Status','type' => 'select','options' => $status));			
								echo $this->Form->input('Tarefa.data_conclusao', array('label' => 'Data de Conclusão','type' => 'text','class'=>'input-xlarge data datepicker'));
								echo $this->Form->input('Tarefa.comentario', array('label' => 'Comentário', 'class'=>'input-xlarge'));
								echo $this->Form->input('Tarefa.arquivo', array('class'=>'input-xlarge', 'type' => 'file'));
								echo $this->Form->input('Tarefa.arquivo_dir', array('type' => 'hidden'));
								echo $this->Form->input('Tarefa.acao_id', array('type'=>'hidden','value' => $acao_id));
							?>
							
		 					<div class="form-actions">
		  						<input type="submit" class="btn btn-primary">
							</div>

			 			</form>
			 			
					</div>
					<?php }?>
					
				</div><!-- /.box-content -->
				
				
				
			</div><!-- /.box-tasks -->
		</div><!-- /.span6 -->
		
		<?php }?>
		
		<?php if($listarForum || $adicionarForum){?>
		<div class="<?php echo $spanpost;?>">
			<div class="box box-border box-forum">
				<div class="box-title">
					<h3 class="title"><span class="icon fa fa-comments"></span> Fórum</h3>
				</div>
				<div class="box-content">
					<?php if($listarForum){?>
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed table-forum table-forum-inner">
						<?php foreach($posts as $post){ ?>
						<tr>
							<td>
							
							<small class="date"><?php echo $post['Post']['created'];?></small>
							<span class="by">Criado por: <?php echo $post['Usuario']['Pessoa']['titulo'];?></span>
							<p><?php echo nl2br($post['Post']['mensagem'])?></p>
							
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
								<form action="<?php echo $this->webroot; ?>Post/adicionarNaAcao" id="PostResponderNaAcaoForm" method="post" accept-charset="utf-8">
									<?php echo $this->Form->input("Post.acao_id", array('type' => 'hidden', 'value' => $acao['Acao']['id'])); ?>
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
					<?php }?>
					<?php if($adicionarForum){?>
					<div class="post-container">
						<legend>Criar um novo post</legend>
						
						<form action="<?php echo $this->webroot; ?>Post/adicionarNaAcao" id="PostAdicionarNaAcaoForm" method="post" accept-charset="utf-8">
							<?php
								echo $this->Form->input("Post.acao_id", array('class'=>'input-xlarge', 'type' => 'hidden', 'value' => $acao['Acao']['id']));
								echo $this->Form->input("Post.mensagem", array('class'=>'input-xlarge'));
								echo $this->Form->input("Post.receber_email", array('label' =>'Desejo receber um Email quando alguém responder','type' => 'checkbox', 'checked'));			
							?>
							
		 					<div class="form-actions">
		  						<input type="submit" class="btn btn-primary">
							</div>

			 			</form>
					</div>
					<?php }?>
				</div><!-- /.box-content -->
			</div><!-- /.box-forum -->
		</div><!-- /.span6 -->
		<?php }?>
	</div><!-- /.row -->

</div>