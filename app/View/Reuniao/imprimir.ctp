<?php 
/**
 *
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL.odt", junto com este programa. Se não encontrar,
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
 *
 */

// Exibição de arquivos do bootstrap 
echo $this->Html->css('bootstrap.min');
echo $this->Html->css('bootstrap-responsive.min');
?>
<div class="container">
	<legend>Documento de reunião</legend>
	<div class="row-fluid" style="margin-bottom: 20px">
		<table class="table table-bordered">
			<tbody>
				<tr style="background-color: #f5f5f5">
					<td colspan="2">
						<b><?php echo $reuniao[0]['Reuniao']['titulo']; ?></b>
					</td>
				</tr>
				<tr>
					<td>
						<b>Local:</b>
					</td>
					<td>
						<?php echo $reuniao[0]['Reuniao']['local']; ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Data:</b>
					</td>
					<td>
						<?php echo $reuniao[0]['Reuniao']['data']; ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Pauta:</b>
					</td>
					<td>
						<?php echo $reuniao[0]['Reuniao']['pauta']; ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Horário de início:</b>
					</td>
					<td>
						<?php echo $reuniao[0]['Reuniao']['hora_inicio']; ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Horário de térimino:</b>
					</td>
					<td>
						<?php echo $reuniao[0]['Reuniao']['hora_fim']; ?>
					</td>
				</tr>
				<tr style="background-color: #f5f5f5">
					<td colspan="2">
						<b>Participantes:</b>
					</td>
				</tr>
				<?php foreach($reuniao[0]['Participantes'] as $participante){ ?>
					<tr>
						<td>
							<?php echo $participante['titulo']; ?>
						</td>
						<td>
							<?php echo $participante['email']; ?>
						</td>
					</tr>
				<?php } ?>
				<tr style="background-color: #f5f5f5">
					<td colspan="2">
						<b>Conhecimento:</b>
					</td>
				</tr>
				<?php foreach($reuniao[0]['Conhecedores'] as $conhecedor){ ?>
					<tr>
						<td>
							<?php echo $conhecedor['titulo']; ?>
						</td>
						<td>
							<?php echo $conhecedor['email']; ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="row-fluid">
		<table class="table table-bordered">
			<thead>
				<tr style="background-color: #f5f5f5">
					<th>Tarefas</th>
					<th>Início</th>
					<th>Fim</th>
					<th>Responsável</th>
				</tr>
			</thead>
			<tbody>
				
				<?php foreach($reuniao[0]['Tarefa'] as $tarefa){ ?>
					<tr>
						<td><?php echo $tarefa['titulo']; ?></td>
						<td><?php echo $tarefa['data_inicio_previsto']; ?></td>
						<td><?php echo $tarefa['data_fim_previsto']; ?></td>
						<td><?php echo $tarefa['Responsavel'][0]['titulo']; ?></td>
					</tr>	
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
