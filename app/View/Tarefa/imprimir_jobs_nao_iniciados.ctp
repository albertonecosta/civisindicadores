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
<div class="row-fluid">
	<legend>Jobs não iniciadas</legend>
	<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th><?php echo __('titulo'); ?></th>
				<th><?php echo __('data de início'); ?></th>
				<th><?php echo __('data final'); ?></th>
				<th><?php echo __('responsável'); ?></th>
				<th><?php echo __('supervisor'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($tarefa as $tarefa){?>
			<tr>
				<td><?php echo $tarefa['Tarefa']['titulo']; ?>&nbsp;</td>
				<td><?php echo $tarefa['Tarefa']['data_inicio_previsto']; ?>&nbsp;</td>
				<td><?php echo $tarefa['Tarefa']['data_fim_previsto']; ?>&nbsp;</td>
				<td><?php echo $tarefa['Responsavel']['Pessoa']['titulo']; ?>&nbsp;</td>
				<td><?php echo $tarefa['Supervisor']['Pessoa']['titulo']; ?>&nbsp;</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>