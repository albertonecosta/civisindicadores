<script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });
  $("#index").treetable({ expandable: true});
</script>
<div class="container">

	<h4 class="title title-section">Indicador</h4>

	<?php
		echo $this->FilterForm->create('',array('class' => 'well form-search'));
	?>
	<div class="list-actions row-fluid">
		
		<div class="list-actions-buttons pull-left">				
			<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->Html->url(array('controller' => 'Indicador', 'action' => 'adicionar'), true);?>' "><i class="fa fa-plus-circle"></i>Adicionar</button>
		</div><!-- /.list-actions -->
		<!-- Filtros -->
		<div class="list-filters pull-right">
			
			<div class="with-select">
				<?php
					echo $this->FilterForm->input('filter1', array('placeholder' => 'O que você procura?'));		
				?>
				<select name="" id="">
					<option value="">Filtrar em:</option>
					<option value="">Título</option>
				</select>
				<button type="submit" class="btn"><i class="icon-search fa fa-search"></i></button>
			</div>

		</div><!-- /.list-filters -->
		<!-- end Filtros -->	

	</div>
	</form>
	
	<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index">
		<thead>
			<tr>
				<th data-class="expand"><?php echo $this->Paginator->sort('titulo'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Responsavel.Pessoa.titulo','responsável'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Pai.titulo', 'Pai'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('tipo_calculo'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('desdobramento'); ?></th>
				<th class="actions"><center><?php echo __('Ações'); ?></center></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($indicador as $indicador){?>
			<tr>
				<td><?php echo $this->Html->link($indicador['Indicador']['titulo'], array('action' => 'visualizar', $indicador['Indicador']['id'])); ?>&nbsp;</td>
				<td><?php echo $this->Html->link($indicador['Responsavel']['Pessoa']['titulo'], array('controller' => 'Usuario','action' => 'visualizar', $indicador['Responsavel']['id'])); ?>&nbsp;</td>
				<td><?php echo $this->Html->link($indicador['Pai']['titulo'], array('action' => 'visualizar', $indicador['Pai']['id'])); ?>&nbsp;</td>
				<td><?php echo Util::getTipoCalculo($indicador['Indicador']['tipo_calculo']); ?>&nbsp;</td>
				<td><?php echo $indicador['Indicador']['desdobramento'] == Util::ATIVO ? 'Mensal' : 'Anual'; ?>&nbsp;</td>
				<td class="actions" width="7%" nowrap="nowrap">
					<?php 
						echo $this->Html->link(
							__(""),
							array('action' => 'editar', $indicador['Indicador']['id']),
							array('class'=>'icon-edit fa fa-edit')
						);
						echo "&nbsp;&nbsp;";
						echo $this->Form->postLink(
							__(""), 
							array('action' => 'excluir', $indicador['Indicador']['id']), 
							array('class'=>'icon-trash fa fa-trash-o'),
							__(Util::MENSAGEM_DELETAR, $indicador['Indicador']['id'])
						); 
					?>
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