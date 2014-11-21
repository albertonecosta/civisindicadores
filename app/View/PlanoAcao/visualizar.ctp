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
	<legend>Visualizar Plano Ação</legend>
	<div class="row">
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($planoAcao['PlanoAcao']['titulo']); ?></td>
					</tr>
					<?php if(count($planoAcao['AcaoPlanoAcao']) > 0){?>
					<tr>
						<td><strong><?php echo __('Ações'); ?></strong></td>						
						<td><ul><?php
							foreach($planoAcao['AcaoPlanoAcao'] as $acoes){
								echo "<li>".$acoes['Acao']['titulo']."</li>";
							}											
						?></ul></td>						
					</tr>
					<?php } ?>
				</tbody>				
			</table>			
		</div>
	</div>
</div>