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

