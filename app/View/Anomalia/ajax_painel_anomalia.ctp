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

?>
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