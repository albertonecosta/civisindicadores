<?php
	$adicionar = $this->ControleDeAcesso->validaAcessoElemento('adicionar');
	$visualizar = $this->ControleDeAcesso->validaAcessoElemento('visualizar');
	$editar = $this->ControleDeAcesso->validaAcessoElemento('editar');
	$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir');
	$grafico = $this->ControleDeAcesso->validaAcessoElemento('grafico');
	$visualizarDimensao = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Dimensao');
?>
<script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });
  $("#index").treetable({ expandable: true});
</script>
<div class="container">
	<br />
	<h4>Ações Estratégicas</h4>
	<form method="post" class="well form-search">
		<div class="list-actions row-fluid">
			<!-- Filtros -->
			<div class="list-filters pull-left">
				<div class="with-select">
					<input name="data[Medida][busca]" placeholder="O que você procura?" type="text" id="MedidaBusca">
					<?php $options = array('Medida.titulo' => 'Título','Medida.ano'=>'Ano','Medida.situacao'=>'Situação','Medida.prioridade'=>'Prioridade', 'Medida.data_ultima_atualizacao'=>'Última Atualização');?>
					<select name="data[Medida][buscar_em]" id="MedidaBuscarEm">
						<option value="Medida.titulo">Filtrar em:</option>					
						<?php foreach($options as $key => $value){?>
						<option value="<?php echo $key; ?>"><?php echo $value;?></option>
						<?php } ?>
					</select>
					<button type="submit" class="btn"><i class="icon-search fa fa-search"></i></button>
				</div>
				<div class="filters-tags">
					<?php
					if(isset($_SESSION['Search']['Medida'])){
						if(count($_SESSION['Search']['Medida'])>0){
						?>
						<h4 class="title">Filtrado por:</h4>
						<?php
							foreach($_SESSION['Search']['Medida'] as $key => $temo_busca){
						?>
							<span class="type-tag"><?php echo $options[$temo_busca['buscar_em']]?>: <?php echo $temo_busca['busca']?><?php echo $this->Html->link("", array("action" => "excluirFiltro", $key), array("class" => "fa fa-times")); ?></span>
						<?php	
							}
						}
					}
					?>
				</div>
			</div><!-- /.list-filters -->
				<div class="list-actions-buttons pull-right">
				<?php if($adicionar){?>			
				<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->webroot; ?>medida/adicionar' "><i class="fa fa-plus-circle"></i>Adicionar</button>
				<?php }?>
			</div><!-- /.list-actions -->
			<!-- end Filtros -->
		</div>
	</form>
	
	<?php if($grafico){?>
	<p><a href="javascript: void(0);" onclick="$('#TargetGraphic').slideToggle('slow');">Exibir Gráfico</a></p>
	
	<div id="TargetGraphic" style="display: none">
		<?php 
		$parametros = array();
		$medidas = $medida;
		foreach($medidas as $medidas){
			
			switch ($medidas['Medida']['situacao']) {
				case Util::NAO_INFORMADO:
					$situacao = 0;
					break;
				case Util::ADEQUADO:
					$situacao = 1;
					break;
				case Util::ATENCAO:
					$situacao = 2;
					break;
				case Util::CONCLUIDO:
					$situacao = 4;
					break;
				case Util::PREOCUPANTE:
					$situacao = 3;
					break;
				default:
					$situacao = '';					
			}
			$parametros[] = $medidas['Medida']['titulo'].'|'.$medidas['Medida']['prioridade'].'|'.$medidas['Medida']['andamento'].'|'.$situacao.'|'.$medidas['Medida']['id'];
		}
		$parametros = implode(';', $parametros);
		?>
		
		<iframe src="http://<?php echo $_SERVER['HTTP_HOST'] . $this->base; ?>/graficos/ver_alvo.php?base=<?php echo $this->base;?>&showscale=1&width=400&height=400&table_data=<?php echo $parametros;?>" width="100%" height="440" style="border: 0px;" scrolling="no"> </iframe>
	</div>
	<?php }?>
	
	<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index">
		<thead>
			<tr>
				<th data-hide="phone,tablet" width='10'><?php echo $this->Paginator->sort('Medida.situacao', 'Situação'); ?></th>
				<th data-class="expand"><?php echo $this->Paginator->sort('Medida.prioridade', 'Prioridade'); ?></th>
				<th data-class="expand"><?php echo $this->Paginator->sort('Medida.titulo', 'Título'); ?></th>
				
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Dimensao.titulo', 'Dimensão'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Medida.data_ultima_atualizacao', 'Atualização'); ?></th>
				<!--th data-hide="phone,tablet"><?php echo $this->Paginator->sort('ano'); ?></th-->
				<!--th data-hide="phone,tablet"><?php echo __('Projetos associados'); ?></th-->
				<?php if($editar || $excluir){?>
				<th><center><?php echo __('Ações'); ?></center></th>
				<?php }?>
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach($medida as $medida){?>
			<tr>
				<td><?php $situacao = $medida['Medida']['situacao']; 
				$situacaoNome = "";
				switch ($situacao) {
				    case Util::NAO_INFORMADO:
				        $situacaoNome = "<img src='".$this->base."/img/quadrado_cinza.png' style='margin-left:20px' title='Não Informado'>";
				        break;
				    case Util::ADEQUADO:
				        $situacaoNome = "<img src='".$this->base."/img/quadrado_verde.png' style='margin-left:20px' title='Adequado'>";
				        break;
				    case Util::ATENCAO:
				        $situacaoNome = "<img src='".$this->base."/img/quadrado_amarelo.png' style='margin-left:20px' title='Atenção'>";
				        break;
			        case Util::CONCLUIDO:
			        	$situacaoNome = "<img src='".$this->base."/img/quadrado_azul.png' style='margin-left:20px' title='Concluído'>";
			        	break;
		        	case Util::PREOCUPANTE:
		        		$situacaoNome = "<img src='".$this->base."/img/quadrado_vermelho.png' style='margin-left:20px' title='Preocupante'>";
		        		break;
				}
				
				echo  $situacaoNome;
				?>&nbsp;</td>
				<td><?php echo $medida['Medida']['prioridade'];?></td>
				<td>
					<?php
					if($visualizar){
						echo $this->Html->link($medida['Medida']['titulo'], array('action' => 'visualizar', $medida['Medida']['id']));
					}else{
						echo $medida['Medida']['titulo'];
					}
					?>&nbsp;
				</td>
				<td>
					<?php
					if($visualizarDimensao){
						echo $this->Html->link($medida['Dimensao']['titulo'], array('controller' => 'Dimensao','action' => 'visualizar', $medida['Dimensao']['id']));
					}else{
						echo $medida['Dimensao']['titulo'];
					}
					?>&nbsp;
				</td>
				<td><?php echo $medida['Medida']['data_ultima_atualizacao'];?></td>
				<!--td><?php echo $medida['Medida']['ano'];?></td-->
				<!--td class="no-padding">
					<ul class="list-inner">
					<?php
					
					if(isset($projetos[$medida['Medida']['id']])){
						foreach ($projetos[$medida['Medida']['id']] as $key => $value) {

							if($value["Projeto"]['status'] != Util::INATIVO){
							
						?>
							<li>
								<div class="wrapper">
								<div class="text">
									<?php
									if($value["Projeto"]["concluido"]==1){
										echo '<span class="icon-check fa fa-check-square-o"></span>';
									}
									
									?>
										<abbr>
										<?php echo $this->Html->link($value["Projeto"]['titulo'], array('controller' => 'Projeto', 'action' => 'visualizar', $value["Projeto"]['id'])); ?>	
										</abbr>
									
									</div>									
								</div>
							</li>
						<?php
							}
						}
					}
					?>
					</ul>
					
				</td-->
				<?php if($editar || $excluir){?>
				<td width="7%" nowrap="nowrap">
					<center>
					<?php 
						if($editar){
						echo $this->Html->link(
							__(""),
							array('action' => 'editar', $medida['Medida']['id']),
							array('class'=>'icon-edit')
						);
						echo "&nbsp;&nbsp;";
						}
						if($excluir){
						echo $this->Form->postLink(
							__(""), 
							array('action' => 'excluir', $medida['Medida']['id']), 
							array('class'=>'icon-trash'),
							__(Util::MENSAGEM_DELETAR, $medida['Medida']['id'])
						);	
						}			
					?>
					</center>
				</td>
				<?php }?>
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