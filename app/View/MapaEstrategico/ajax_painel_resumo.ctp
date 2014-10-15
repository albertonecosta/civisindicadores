<?php $mes = Util::getMes($mes); ?>
<div class="row-fluid">
	<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th><?php echo $indicador['Indicador']['titulo']; ?></th>
				<th>Mês: <?php echo $mes; ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Meta:</td>
				<td><?php echo $indicador['IndicadorMeta'][strtolower($mes)]; ?></td>
			</tr>
			<tr>
				<td>Realizado:</td>
				<td><?php echo $indicador['IndicadorRealizado'][strtolower($mes)]; ?></td>
			</tr>
			<tr>
				<td>Desvio:</td>
				<td><?php echo Util::getDesvio($indicador['IndicadorMeta'][strtolower($mes)], $indicador['IndicadorRealizado'][strtolower($mes)]); ?></td>
			</tr>
		</tbody>	
	</table>
</div>
<div class="row-fluid">
	<h5>Anomalias</h5>
	<hr>
	<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
		<tbody>
			<?php foreach($indicador['Anomalia'] as $anomalia){ ?>
				<?php 
					$data = explode("/", $anomalia['data']);
					$dataMes = Util::getMes($data[1]);
				?>
				<?php if($dataMes == $mes){?>
				<tr>
					<td><?php echo $this->Html->link($anomalia['identificacao_problema'], array("controller" => "Anomalia", "action" => "visualizar", $anomalia['id']), array("target" => "_blank")); ?></td>
				</tr>
				<?php } ?>
			<?php } ?>
		</tbody>
	</table>
	<div class="form-actions">
		<button class="btn btn-primary" onclick="javascript:formAnomalia(<?php echo $indicador['Indicador']['objetivo_id'] ?>, <?php echo $indicador['Indicador']['id'] ?>, '<?php echo Util::getMes($mes, true); ?>')">Adicionar</button>
	</div>
</div>