<div class="row-fluid">
	<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th>Identificação do problema</th>
				<th>Estratificação do problema</th>
				<th>Causas Internas</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<?php echo $anomalia['Anomalia']['identificacao_problema']; ?>
				</td>
				<td>
					<?php echo $anomalia['Anomalia']['estratificacao_problema']; ?>
				</td>
				<td>
					<?php echo $anomalia['Anomalia']['causas_internas']; ?>
				</td>
			</tr>
		</tbody>
		<thead>
			<tr>
				<th>#</th>
				<th>Local, data e status</th>
				<th>Causas Externas</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					#
				</td>
				<td>
					<?php echo $anomalia['Anomalia']['data']; ?> - <?php echo $anomalia['Anomalia']['status'] == Util::ATIVO ? "Ativo" : "Inativo" ; ?>
				</td>
				<td>
					<?php echo $anomalia['Anomalia']['causas_externas']; ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="row-fluid">
		<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th>Ação corretiva</th>
				<th>Como?</th>
				<th>Quem?</th>
				<th>Quando?</th>
				<th>Status?</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($anomalia['Acao'] as $acao){?>
			<tr>
				<td>
					<?php echo $acao['titulo']; ?>
				</td>
				<td>
					<?php echo $acao['observacao'];?>
				</td>
				<td>
					<?php 
						foreach($responsaveis as $responsavel){
							if($responsavel['Responsavel']['acao_id'] == $acao['id']){
								echo $responsavel['Responsavel']['nome'];
							}
						}
					?>
				</td>
				<td>
					Início: <br>
					<?php echo $acao['data_inicio_previsto'];?><br>
					Fim:<br>
					<?php echo $acao['data_fim_previsto'];?>
				</td>
				<td>
					<?php echo Util::getStatus($acao['status']); ?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>