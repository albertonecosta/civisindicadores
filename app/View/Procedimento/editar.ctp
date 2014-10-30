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
	<?php echo $this->Form->create('Procedimento', array('type' => 'file')); ?>
 		<fieldset>
 			<legend>Cadastro Procedimento</legend>
 			<div class="row">
  			<div class="span12">  				
  				<?php
  					echo $this->Form->input('id', array('type' => 'hidden'));
					echo $this->Form->input('titulo', array('class'=>'input-xlarge'));
					echo $this->Form->input('resultado_esperado', array('class'=>'input-xlarge jqte-test'));
					echo $this->Form->input('passos', array('class'=>'input-xlarge jqte-test'));
					echo $this->Form->input('requisito', array('class'=>'input-xlarge jqte-test'));
					echo $this->Form->input('arquivo', array('class'=>'input-xlarge', 'type' => 'file'));
					echo $this->Form->input('usuario_id', array('label' => 'Patrocinador','class'=>'input-xlarge', 'options' => $usuarios));
				?>
				<label>Certificado</label>
				<?php 
					echo $this->Form->input('certificado', array('legend' => false,'type' => 'radio', 'options' => array(Util::ATIVO => 'sim', Util::INATIVO => 'não')));
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
