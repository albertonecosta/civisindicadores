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
	<h4 class="title title-section">Programas</h4>
	<?php echo $this->Form->create('Programa'); ?>	
 		<fieldset class="programa-fieldset">
 			<legend>Novo Programa</legend>
 			<div class="row-fluid">
	  			<div class="span6"> 				
	  				<?php
						echo $this->Form->input('titulo', array('label' => 'Título','class'=>'input-xlarge'));
						echo $this->Form->input('descricao', array('label' => 'Descrição','class'=>'input-xlarge'));
						echo $this->Form->input('data_inicio', array('label' => 'Data de Início','type' => 'text','class'=>'input-xlarge data datepicker'));
						echo $this->Form->input('data_fim', array('label' => 'Data de Fim','type' => 'text','class'=>'input-xlarge data datepicker'));
					?>
				</div>
  			</div>
 			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
 		</fieldset>
</div>
