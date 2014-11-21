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
	<h4>Ações</h4>
	<hr>
	<ul class="nav nav-tabs nav-stacked">
	<?php
	if(isset($acoes)){
		foreach ($acoes as $value) {
		?>
			<li><?php echo $this->Html->link($value['Acao']['titulo'], array('controller' => 'Acao', 'action' => 'visualizar', $value['Acao']['id']), array('target' => '_blank')); ?></li>
		<?php
		}
	}
	?>
	<div class="row-fluid" style="margin-top: 10px;">
		<button class="btn btn-primary" type="button" onclick="javascript:formAcao(<?php echo $objetivo_id; ?>)">Adicionar</button>
	</div>
	</ul>	
</div>
