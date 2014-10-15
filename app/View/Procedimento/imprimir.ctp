<?php 
echo $this->Html->css('bootstrap.min');
echo $this->Html->css('bootstrap-responsive.min');
?>
<div class="container">
	<legend>Procedimento</legend>
	<div class="row-fluid">
		<table class="table table-bordered">
			<tbody>
				<tr style="background-color: #f5f5f5">
					<td>
						<b><center><?php echo $procedimento['Procedimento']['titulo']; ?></center></b>
					</td>
				</tr>
				<tr>
					<td><b>Passos:</b></td>
				</tr>
				<tr>
					<td><?php echo $procedimento['Procedimento']['passos']; ?></td>
				</tr>
				<tr>
					<td><b>Resultados esperados:</b></td>
				</tr>
				<tr>
					<td><?php echo $procedimento['Procedimento']['resultado_esperado']; ?></td>
				</tr>
				<tr>
					<td><b>Requisitos:</b></td>
				</tr>
				<tr>
					<td><?php echo $procedimento['Procedimento']['requisito']; ?></td>
				</tr>
				<tr>
					<td><b>Patrocinador:</b></td>
				</tr>
				<tr>
					<td><?php echo $procedimento['Patrocinador']['Pessoa']['titulo']; ?></td>
				</tr>
				<tr>
					<td><b>Certificado:</b></td>
				</tr>
				<tr>
					<td><?php echo $procedimento['Procedimento']['certificado'] == Util::ATIVO ? "sim" : "Não"; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
