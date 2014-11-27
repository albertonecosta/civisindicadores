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
	<legend>Documento de Projeto</legend>
	<div class="row-fluid" style="margin-bottom: 20px">
		<table class="table table-bordered">
			<tbody>
				<tr style="background-color: #f5f5f5">
					<td colspan="2">
						<b><?php echo $projeto[0]['Projeto']["processo"]; ?> - <?php echo $projeto[0]['Projeto']['titulo']; ?></b>
					</td>
				</tr>
				<tr>
					<td>
						<b>Responsável:</b>
					</td>
					<td>
						<?php echo $projeto[0]['Responsavel']["login"]; ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Custo:</b>
					</td>
					<td>
						<?php echo $projeto[0]['Projeto']["custo"]; ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Gasto até o momento:</b>
					</td>
					<td>
						<?php echo $projeto[0]['Projeto']["gasto"]; ?>
					</td>
				</tr>

				<tr>
					<td>
						<b>Programa:</b>
					</td>
					<td>
						<?php echo $projeto[0]['Programa']["titulo"]; ?>
					</td>
				</tr>				<tr>
					<td>
						<b>Descrição:</b>
					</td>
					<td>
						<?php echo nl2br($projeto[0]['Projeto']['descricao']); ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Motivação:</b>
					</td>
					<td>
						<?php echo nl2br($projeto[0]['Projeto']['motivacao']); ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Resultados:</b>
					</td>
					<td>
						<?php echo nl2br($projeto[0]['Projeto']['resultado']); ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Data de início:</b>
					</td>
					<td>
						<?php echo $projeto[0]['Projeto']['data_inicio_previsto']; ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Data de Término:</b>
					</td>
					<td>
						<?php echo $projeto[0]['Projeto']['data_fim_previsto']; ?>
					</td>
				</tr>
			
			</tbody>
		</table>
	</div>
	<div class="row-fluid" style="margin-bottom: 20px">
		<table class="table table-bordered">
		<thead>
				<tr style="background-color: #f5f5f5">
					<th>Atividades</th>
					<th>Início</th>
					<th>Fim</th>
					<th>Status</th>
					<th>Andamento</th>
					<th>Responsável</th>
				</tr>
			</thead>
			<tbody>
				
				<?php 
				if (count($projeto[0]['Atividade'])){
				foreach($projeto[0]['Atividade'] as $atividade){ 
						if($atividade['status'] != Util::INATIVO){
				
							if($atividade["status"]==5){
								if (strtotime(Util::inverteData($atividade["data_conclusao"]))-strtotime(Util::inverteData($atividade["data_fim_previsto"]))>604800)
								$barraProgresso="progress progress-danger progress-striped";
								elseif (strtotime(Util::inverteData($atividade["data_fim_previsto"]))-strtotime(Util::inverteData($atividade["data_conclusao"]))<604800)
								$barraProgresso="progress progress-warning progress-striped";
								else
								$barraProgresso="progress progress-success progress-striped";
							}else{
								if (time()>strtotime(Util::inverteData($atividade["data_fim_previsto"])))
								$barraProgresso="progress progress-danger progress-striped";
								elseif (time()-604800>strtotime(Util::inverteData($atividade["data_fim_previsto"])))
								$barraProgresso="progress progress-warning progress-striped";
								else
								$barraProgresso="progress progress-success progress-striped";
							}
				?>
					<tr>
						<td><?php
							$titulo='';
							if($atividade["status"]==5){
								$titulo.= $atividade['titulo'];
								$titulo.= "<span class='icon-check fa fa-check-o'></span>";
							}else{
								$titulo=$atividade['titulo'];
							}
							if($atividade['marco']==1){
								echo "<strong>$titulo</strong>";						
							}else{
								echo "&nbsp;&nbsp;&nbsp;$titulo";
							}
						?>
						</td>
						<td><?php echo $atividade['data_inicio_previsto']; ?></td>
						<td><?php echo $atividade['data_fim_previsto']; ?></td>
						<td>
						<?php 
							switch ($atividade['status']){
								case (Util::ATIVO):
									echo "Ativo";
									break;
								case (Util::INATIVO):
									echo "Inativo";
									break;
								case (Util::NAO_INICIADO):
									echo "Não Iniciada";
									break;
								case (Util::EM_ANDAMENTO):
									echo "Em Andamento";
									break;
								case (Util::AGUARDANDO_OUTRA_PESSOA):
									echo "Aguardando outra pessoa";
									break;
								case (Util::CONCLUIDO):
									echo "Concluída";
									break;
								case (Util::CANCELADO):
									echo "Cancelada";
									break;
								default:
									break;
							} ?>
						</td>
						<td><?php
							if($atividade["status"]==5){
								if (strtotime(Util::inverteData($atividade["data_conclusao"]))-strtotime(Util::inverteData($atividade["data_fim_previsto"]))>604800)
								$barraProgresso="progress progress-danger progress-striped";
								elseif (strtotime(Util::inverteData($atividade["data_fim_previsto"]))-strtotime(Util::inverteData($atividade["data_conclusao"]))<604800)
								$barraProgresso="progress progress-warning progress-striped";
								else
								$barraProgresso="progress progress-success progress-striped";
							}else{
								if (time()>strtotime(Util::inverteData($atividade["data_fim_previsto"])))
								$barraProgresso="progress progress-danger progress-striped";
								elseif (time()-604800>strtotime(Util::inverteData($atividade["data_fim_previsto"])))
								$barraProgresso="progress progress-warning progress-striped";
								else
								$barraProgresso="progress progress-success progress-striped";
							}
							?><div class="<?php echo $barraProgresso; ?>">
							  <div class="bar" style="width: <?php echo $atividade["andamento"];?>;"></div>
							</div>						
						</td>
						<td><?php echo $atividade['Responsavel'][0]['titulo']; ?></td>
					</tr>	
				<?php }
					}
				}	 
				?>
			</tbody>
		</table>
	</div>
</div>

