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
<div class="container">
	<h4 class="title title-section">Indicador</h4>
	<legend>Visualizar Indicador</legend>
	<div class="row">
		<div class="span12">
			<legend>Dados Básicos</legend>
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($indicador['Indicador']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Tipo'); ?></strong></td>
						<td><?php echo h($indicador['Indicador']['tipo']) == Util::ATIVO ? "Inteiro" : "Decimal"; ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Faixa'); ?></strong></td>
						<td><?php echo h($indicador['Faixa']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Resposável'); ?></strong></td>
						<td><?php echo h($indicador['Responsavel']['Pessoa']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Item superior'); ?></strong></td>
						<td><?php echo h($indicador['Pai']['titulo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Tipo do Calculo'); ?></strong></td>
						<td><?php echo Util::getTipoCalculo($indicador['Indicador']['tipo_calculo']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Desdobramento'); ?></strong></td>
						<td><?php echo $indicador['Indicador']['desdobramento'] == Util::ATIVO ? 'Mensal' : 'Anual'; ?></td>
					</tr>	
				</tbody>				
			</table>			
		</div>
		<div class="span12">
			<legend>Atribuições</legend>
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Ordem'); ?></strong></td>
						<td><?php echo h($indicador['Indicador']['ordem']); ?></td>
					</tr>
					<tr>
						<td><strong><?php echo __('Anos'); ?></strong></td>
						<td>
							<ul>
							<?php foreach ($anos as $key => $value) { ?>
								<li><?php echo $value;?></li>
							<?php } ?>
							</ul>
						</td>
					</tr>
					<tr>
						<td><strong><?php echo __('Quem irá visualizar'); ?></strong></td>
						<td>
							<ul>
							<?php foreach ($indicadorAutorizadoVisualizar as $key => $value) { ?>
								<li><?php echo $value['Usuario']['Pessoa']['titulo'];?></li>
							<?php } ?>
							</ul>
						</td>
					</tr>
					<tr>
						<td><strong><?php echo __('Quem irá colocar a meta'); ?></strong></td>
						<td>
							<ul>
							<?php foreach ($indicadorResponsavelMeta as $key => $value) { ?>
								<li><?php echo $value['Usuario']['Pessoa']['titulo'];?></li>
							<?php } ?>
							</ul>
						</td>
					</tr>
					<tr>
						<td><strong><?php echo __('Quem irá colocar o realizado'); ?></strong></td>
						<td>
							<ul>
							<?php foreach ($indicadorResponsavelrealizado as $key => $value) { ?>
								<li><?php echo $value['Usuario']['Pessoa']['titulo'];?></li>
							<?php } ?>
							</ul>
						</td>
					</tr>	
				</tbody>				
			</table>
		</div>
	</div>
</div>