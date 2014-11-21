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
<h4 class="title title-section">Marcador</h4>
	<?php echo $this->Form->create('Marcador'); ?>	
 		<fieldset class="projeto-fieldset">
 			<legend>Novo Marcador</legend>
 			<div class="row-fluid">
	  			<div class="span6"> 				
	  				<?php
					echo $this->Form->input('titulo', array('class'=>'input-xlarge'));
					echo $this->Form->input('descricao', array('label' => 'Descrição','class'=>'input-xlarge jqte-test'));
				
					?>
  			</div>
  				<div class="span6">
  				<?php
					echo $this->Form->input('objetivo_id', array('label' => 'Ações',
							'class'=>'input-xlarge',
							'type' => 'select',
							'multiple' => 'multiple',
							'options' => $objetivos,
							'div' => array(
									'class' => 'input label-block'
							)));
					?>
				</div>
  			</div>
 			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Salvar</button>
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

<script type="text/javascript" src="<?php echo $this->base?>/js/libs/jquery.lwMultiSelect.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
	//initialize the element
    $('#MarcadorObjetivoId').lwMultiSelect();
  });
</script>
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
