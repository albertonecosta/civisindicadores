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
