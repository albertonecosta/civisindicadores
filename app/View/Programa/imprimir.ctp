<?php 
echo $this->Html->css('bootstrap.min');
echo $this->Html->css('bootstrap-responsive.min');

?>
<div class="container">
	<legend>Documento de Programa</legend>
	<div class="row-fluid" style="margin-bottom: 20px">
		<table class="table table-bordered">
			<tbody>
				<tr style="background-color: #f5f5f5">
					<td colspan="2">
						<b><?php echo $programa[0]['Programa']['titulo']; ?></b>
					</td>
				</tr>
				<tr>
					<td>
						<b>Descrição:</b>
					</td>
					<td>
						<?php echo $programa[0]['Programa']['descricao']; ?>
					</td>
				</tr>
				
				<tr>
					<td>
						<b>Data de início:</b>
					</td>
					<td>
						<?php echo $programa[0]['Programa']['data_inicio']; ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Data de Término:</b>
					</td>
					<td>
						<?php echo $programa[0]['Programa']['data_fim']; ?>
					</td>
				</tr>
			
			</tbody>
		</table>
	</div>
	<div class="row-fluid" style="margin-bottom: 20px">
		<table class="table table-bordered">
		<thead>
				<tr style="background-color: #f5f5f5">
					<th>Projetos</th>
					<th>Início</th>
					<th>Fim</th>
					<th>Concluído</th>
				</tr>
			</thead>
			<tbody>
				
				<?php 
				
				foreach($projetos as $programa){ 
						if($programa['status'] != Util::INATIVO){
				
				?>
					<tr>
						<td>
							<?php
								echo $programa['titulo'];
							?>
						</td>
						<td><?php echo $programa['data_inicio_previsto']; ?></td>
						<td><?php echo $programa['data_fim_previsto']; ?></td>
						<td>
						<?php 
						
							switch ($programa['concluido']){
								case (Util::CONCLUIDO):
									echo "Concluída";
									break;
								case (Util::INATIVO):
									echo "Em Andamento";
									break;
								default:
									break;
							} ?>
						</td>
						
					</tr>	
				<?php }} ?>
			</tbody>
		</table>
	</div>
</div>

