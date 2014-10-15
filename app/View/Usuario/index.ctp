<script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });
  $("#index").treetable({ expandable: true});
</script>
<div class="container">
	<br />
	 
	<h4>Usuários</h4>		
	<?php
		echo $this->FilterForm->create('',array('class' => 'well form-search'));
	?>
	<div class="row">
		<div class="span6">
			<div class="input-append">
				<?php
					echo $this->FilterForm->input('filter1');		
				?>
				<button type="submit" class="btn"><i class="icon-search"></i>&nbsp;</button>
			</div>
		</div>
		<div class="span5">				
			<p><button class="btn btn-small btn-primary pull-right" type="button" onclick="location.href= '<?php echo $this->Html->url(array('controller' => 'Usuario', 'action' => 'adicionar'), true);?>' ">Adicionar</button></p>
		</div>
	</div>
	</form>
	 
	<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index">
		<thead>
			<tr>
				<th data-class="expand"><?php echo $this->Paginator->sort('Pessoa.titulo', 'Título'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Pessoa.email', 'Email'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Cargo.titulo', 'Cargo'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Setor.titulo', 'Setor'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Departamento.titulo', 'Departamento'); ?></th>
				<th><center><?php echo __('Ações'); ?></center></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($usuario as $usuario){?>
			<tr>
				<td><?php echo $this->Html->link($usuario['Pessoa']['titulo'], array('action' => 'visualizar', $usuario['Usuario']['id'])); ?>&nbsp;</td>
				<td><?php echo h($usuario['Pessoa']['email']); ?>&nbsp;</td>
				<td><?php echo h($usuario['Cargo']['titulo']); ?>&nbsp;</td>
				<td><?php echo h($usuario['Setor']['titulo']); ?>&nbsp;</td>
				<td><?php echo h($usuario['Departamento']['titulo']); ?>&nbsp;</td>
				<td width="7%" nowrap="nowrap">
					<center>
					<?php 
						echo $this->Html->link(
							__(""),
							array('action' => 'editar', $usuario['Usuario']['id']),
							array('class'=>'icon-edit')
						);
						echo "&nbsp;&nbsp;";
						echo $this->Form->postLink(
							__(""), 
							array('action' => 'excluir', $usuario['Usuario']['id']), 
							array('class'=>'icon-trash'),
							__(Util::MENSAGEM_DELETAR, $usuario['Usuario']['id'])
						); 
					?>
					</center>
				</td>
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