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
		<button class="btn btn-primary" onclick="javascript:abrirModal(<?php echo $indicador['Indicador']['usuario_id'] ?>, true)">Voltar</button>
	</div>
</div>