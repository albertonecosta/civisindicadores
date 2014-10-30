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
?>
<div class="container">
	<?php echo $this->Form->create('Vinculo'); ?>	
 		<fieldset>
 			<legend>Cadastro Vínculo</legend>
 			<div class="row">
  			<div class="span12">  				
  				<?php
					echo $this->Form->input('titulo', array('class'=>'input-xlarge'));
				?>
  			</div>
 			</div>
 			<div class="row">
 				<div class="span12">
 					<div class="form-actions">
  						<button type="submit" class="btn btn-primary">Salvar</button>
					</div>
 				</div>
 			</div>
 		</fieldset>
</div>
