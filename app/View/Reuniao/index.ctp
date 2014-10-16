<?php
	$adicionarReuniao = $this->ControleDeAcesso->validaAcessoElemento('adicionar', 'Reuniao');
	$visualizarReuniao = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Reuniao');
	$editarReuniao = $this->ControleDeAcesso->validaAcessoElemento('editar', 'Reuniao');
	$excluirReuniao = $this->ControleDeAcesso->validaAcessoElemento('excluir', 'Reuniao');
	$emailReuniao = $this->ControleDeAcesso->validaAcessoElemento('enviar_email', 'Reuniao');
	$imprimirReuniao = $this->ControleDeAcesso->validaAcessoElemento('imprimir', 'Reuniao');
	
	$visualizarProjeto = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Projeto');
	
	$visualizarTarefa = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Tarefa');
	$adicionarTarefa = $this->ControleDeAcesso->validaAcessoElemento('adicionar', 'Tarefa');
?>
<script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });
  $("#index").treetable({ expandable: true});
</script>
<div class="container">
	<br />
	<h4>Reuniões</h4>
	<form method="post" class="well form-search">
		<div class="list-actions row-fluid">
			<!-- Filtros -->
			<div class="list-filters pull-left">
				<div class="with-select">
					<input name="data[Reuniao][busca]" placeholder="O que você procura?" type="text" id="ReuniaoBusca">
					<?php $options = array('titulo' => 'Título', 'data' => 'Data', 'local' => 'Local');?>
					<select name="data[Reuniao][buscar_em]" id="ReuniaoBuscarEm">
						<option value="titulo">Filtrar em:</option>					
						<?php foreach($options as $key => $value){?>
						<option value="<?php echo $key; ?>"><?php echo $value;?></option>
						<?php } ?>
					</select>
					<button type="submit" class="btn"><i class="icon-search fa fa-search"></i></button>
				</div>
				<div class="filters-tags">
					<?php
					if(isset($_SESSION['Search']['Reuniao'])){
						if(count($_SESSION['Search']['Reuniao'])>0){
						?>
						<h4 class="title">Filtrado por:</h4>
						<?php
							foreach($_SESSION['Search']['Reuniao'] as $key => $temo_busca){
						?>
							<span class="type-tag"><?php echo $temo_busca['buscar_em']?>: <?php echo $temo_busca['busca']?><?php echo $this->Html->link("", array("action" => "excluirFiltro", $key), array("class" => "fa fa-times")); ?></span>
						<?php	
							}
						}
					}
					?>
				</div>
			</div><!-- /.list-filters -->
				<div class="list-actions-buttons pull-right">
				<?php if($adicionarReuniao){?>			
				<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->webroot; ?>Reuniao/adicionar' "><i class="fa fa-plus-circle"></i>Adicionar</button>
				<?php }?>
			</div><!-- /.list-actions -->
			<!-- end Filtros -->
		</div>
	</form>
	
	<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index">
		<thead>
			<tr>
				<th data-class="expand"><?php echo $this->Paginator->sort('titulo'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('data'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('local'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('hora_inicio', 'Horário'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('pauta'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Projeto.titulo', 'Projeto'); ?></th>
				<th data-hide="phone,tablet"><?php echo "Participantes"; ?></th>
				<th data-hide="phone,tablet"><?php echo "Tarefas"; ?></th>
				<?php if($editarReuniao || $excluirReuniao || $imprimirReuniao || $emailReuniao){?>
				<th><center><?php echo __('Ações'); ?></center></th>
				<?php }?>
			</tr>
		</thead>
		<tbody>
		<?php foreach($reuniao as $reuniao){?>
			<tr>
				<td>
					<?php 
						if($visualizarReuniao){
							echo $this->Html->link($reuniao['Reuniao']['titulo'], array('action' => 'visualizar', $reuniao['Reuniao']['id']));
						}else{
							echo $reuniao['Reuniao']['titulo'];
						} 
					?>
					&nbsp;
				</td>
				<td><?php echo $reuniao['Reuniao']['data']; ?>&nbsp;</td>
				<td><?php echo $reuniao['Reuniao']['local']; ?>&nbsp;</td>
				<td><?php echo $reuniao['Reuniao']['hora_inicio']; ?>&nbsp;</td>
				<td><?php echo $reuniao['Reuniao']['pauta']; ?>&nbsp;</td>
				<td>
					<?php 
					if($visualizarProjeto){
						echo $this->Html->link($reuniao['Projeto']['titulo'], array('controller' => 'Projeto', 'action' => 'visualizar', $reuniao['Projeto']['id']));
					}else{
						echo $reuniao['Projeto']['titulo'];
					} ?>
					&nbsp;
				</td>
				<td>
					<ul>
						<?php foreach($reuniao['Participantes'] as $value){?>
							<li><?php echo $value['titulo'] ?></li>
						<?php } ?>
					</ul>
					&nbsp;
				</td>
				<td>
					<ul class="nav nav-tabs nav-stacked">
					<?php
					if(isset($reuniao['Tarefa'])){
						foreach ($reuniao['Tarefa'] as $key => $value) {
						?>
							<li>
							<?php 
								if($visualizarTarefa){
									echo $this->Html->link($value['titulo'], array('controller' => 'Tarefa', 'action' => 'visualizar', $value['id']));
								}else{
									echo "<a href='javascript:void(0);'>" . $value['titulo'] . "</a>";
								}  
							?>
							</li>
						<?php
						}
					}
					?>
					<?php if($adicionarTarefa){?>
					<div class="row-fluid" style="margin-top: 10px;">
						<button class="btn btn-mini" type="button" onclick="abrirModal(<?php echo $reuniao['Reuniao']['id']; ?>)">Adicionar</button>
					</div>
					<?php }?>
					</ul>
					&nbsp;
				</td>
				<?php if($editarReuniao || $excluirReuniao || $imprimirReuniao || $emailReuniao){?>
				<td width="7%" nowrap="nowrap">
					<div class="row-fluid">
					<center>
					<?php 
					if($editarReuniao){
						echo $this->Html->link(
							__(""),
							array('action' => 'editar', $reuniao['Reuniao']['id']),
							array('class'=>'icon-edit')
						);
						echo "&nbsp;";
					}
					?>
					<?php if($emailReuniao){?>
					<a href="javascript:enviarEmail(<?php echo $reuniao['Reuniao']['id']; ?>)" title="Enviar email para os participantes"><i class="icon-envelope"></i></a>
					&nbsp;
					<?php }?>
					<?php
						if($imprimirReuniao){
						echo $this->Html->link(
							__(""),
							array('action' => 'imprimir', $reuniao['Reuniao']['id']),
							array('class'=>'icon-print')
						);
						echo "&nbsp;";
					}
					?>
					<?php
					if($excluirReuniao){
						echo $this->Form->postLink(
							__(""), 
							array('action' => 'excluir', $reuniao['Reuniao']['id']), 
							array('class'=>'icon-trash'),
							__(Util::MENSAGEM_DELETAR, $reuniao['Reuniao']['id'])
						); 
					}
					?>
					</center>
					</div>
					<div class="row-fluid">
						<center>
							<div style="display: none" id="enviar_email_<?php echo $reuniao['Reuniao']['id']; ?>"><img src="<?php echo $this->webroot."img".DS."ajax-loader.gif" ?>" /></div>
						</center>
					</div>
				</td>
				<?php } ?>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	
	<div class="row">
		<div class="span6">
			<small>
				<?php
				echo $this->Paginator->counter(array(
				'format' => __(Util::MENSAGEM_PADRAO_PAGINACAO)
				));
				?>
			</small>	
		</div>	
		<div class="span6">
				<div class="pagination pagination-mini pull-right" style="margin:0;">
				<ul>
				<?php
					echo $this->Paginator->prev(__(Util::ANTERIOR_PAGINACAO), array(
						'escape'=>false,
						'tag'=>'li'
					), '<a onclick="return false;">' . Util::ANTERIOR_PAGINACAO . '</a>', 
					array('class'=>'disabled prev','escape'=>false,'tag'=>'li'));
					
					echo $this->Paginator->numbers(
						array(
							'separator' => '',
							'currentClass' => 'active',
							'currentTag' => 'a',
							'tag'=>'li'
						)
					);
					
					echo $this->Paginator->next(__(Util::PROXIMO_PAGINACAO), array(
						'escape'=>false,
						'tag'=>'li'
					), '<a onclick="return false;">' . Util::PROXIMO_PAGINACAO . '</a>', 
					array('class'=>'disabled next','escape'=>false,'tag'=>'li'));
			
				?>
				</ul>
				</div>
			</div>
	</div>
</div>
<div id="dialog" title="Cadastrar Tarefa" style="display: none">
</div>
<script>
	function abrirModal(idReuniao){
		var action = "<?php echo $this->webroot;?>Tarefa/ajaxAdicionar/" + idReuniao;
		$.get(
			action,
			{},
			function(data){
				$("#dialog").html(data);
				$("#dialog").css("display", "block");
			    $("#dialog").dialog({
			    	height: 400,
			    	width: 380,
			    	modal: true
			    });
			    $("#salvar").click(function(){
					var action = <?php echo $this->webroot; ?> + "Tarefa/ajaxAdicionar/" + idReuniao;
					$.post(
						action,
						$("#TarefaAjaxAdicionarForm").serialize(),
						function(data){
							alert(data);
							$(window.document.location).attr('href',"<?php echo $this->webroot; ?>Reuniao");
						}
					);
				});
			}
		);
		
	}
	function enviarEmail(reuniao_id){
		var url = <?php echo $this->webroot; ?> + "Reuniao/enviar/" + reuniao_id;
		var id_icone = "#enviar_email_" + reuniao_id;
		$(id_icone).fadeIn();
		$.post(
			url,
			{reuniao_id: reuniao_id},
			function(data){
				alert(data);
				$(id_icone).fadeOut('fast');
			}
		);
	}
</script>
<?php 
//echo $this->element('sql_dump'); 
?>