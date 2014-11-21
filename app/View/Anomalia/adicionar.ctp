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
	<?php echo $this->Form->create('Anomalia'); ?>	
 		<fieldset>
 			<legend>Cadastro Anomalia</legend>
 			<div class="row">
  			<div class="span12">  				
  				<?php
					echo $this->Form->input('identificacao_problema', array('label' =>'Identificação do problema','class'=>'input-xlarge jqte-test'));
					echo $this->Form->input('estratificacao_problema', array('label' =>'Estratificação do problema','class'=>'input-xlarge jqte-test'));
					echo $this->Form->input('causas_internas', array('label' =>'Causas internas','class'=>'input-xlarge jqte-test'));
					echo $this->Form->input('causas_externas', array('label' =>'Causas externas','class'=>'input-xlarge jqte-test'));
					echo $this->Form->input('data', array('label' =>'Data','class'=>'input-xlarge data', 'type' => 'text',));
					echo $this->Form->input('indicador_id', array('label' =>'Indicador','class'=>'input-xlarge data', 'options' => $indicadores));
					?>
					<label>Ação concluida?</label>
					<?php 
					echo $this->Form->input('concluido', array('legend' => false,'type' => 'radio', 'options' => array(Util::CONCLUIDO => 'sim', Util::NAO_CONCLUIDO => 'não')));
					echo $this->Form->input('data_conclusao', array('label' =>'Data de conclusão','class'=>'input-xlarge data', 'type' => 'text'));
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
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->base?>/js/jquery-te-1.4.0.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo $this->base?>/css/jquery-te-1.4.0.css">
<script>
	$('.jqte-test').jqte();
	
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
</script>
