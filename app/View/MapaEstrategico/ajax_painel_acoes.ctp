<div class="row-fluid">
	<h4>Ações</h4>
	<hr>
	<ul class="nav nav-tabs nav-stacked">
	<?php
	if(isset($acoes)){
		foreach ($acoes as $value) {
		?>
			<li><?php echo $this->Html->link($value['Acao']['titulo'], array('controller' => 'Acao', 'action' => 'visualizar', $value['Acao']['id']), array('target' => '_blank')); ?></li>
		<?php
		}
	}
	?>
	<div class="row-fluid" style="margin-top: 10px;">
		<button class="btn btn-primary" type="button" onclick="javascript:formAcao(<?php echo $objetivo_id; ?>)">Adicionar</button>
	</div>
	</ul>	
</div>
