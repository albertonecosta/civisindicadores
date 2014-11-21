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
	<?php echo $this->Form->create('Objetivo'); ?>	
 		<fieldset>
 			<legend>Cadastro Objetivo</legend>
 			<div class="row">
  			<div class="span12">  				
  				<?php
  					echo $this->Form->input('id', array('type' => 'hidden'));
					echo $this->Form->input('titulo', array('class'=>'input-xlarge'));
					echo $this->Form->input('ordem', array('class'=>'input-xlarge', 'empty' => 'Selecione a Ordem','type' => 'select','options' => $ordem));
					echo $this->Form->input('dimensao_id', array('class'=>'input-xlarge', 'empty' => 'Selecione a Dimensão','type' => 'select','options' => $dimensoes));
					echo $this->Form->input('ano', array('class'=>'input-xlarge', 'empty' => 'Ano','type' => 'select','options' => Util::anos()));
					echo $this->Form->input('tipo', array('class'=>'input-xlarge', 'empty' => 'Selecione o tipo do objetivo','type' => 'select','options' => array(Util::TIPO_PADRAO => 'Padrão', Util::TIPO_MEDIDA => 'Medida')));
					echo $this->Form->input('objetivo_id', array('label' => 'A que objetivo esta medida está associada?','div' => array('id' => 'objetivo_id'),'class'=>'input-xlarge', 'empty' => 'Selecione o objetivo','type' => 'select','options' => $objetivos));
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
<script type="text/javascript">
    jQuery(document).ready(function($){
		var valor = $("#ObjetivoTipo").val();
		if(valor == <?php echo Util::TIPO_MEDIDA ?>){
			$("#objetivo_id").show();
		}else{
			$("#ObjetivoObjetivoId").val("");
			$("#objetivo_id").hide();
		}
		$("#ObjetivoTipo").click(function() {
			var valor = $(this).val();
            if(valor == <?php echo Util::TIPO_MEDIDA ?>){
            	$("#objetivo_id").show();
            }else{
            	$("#ObjetivoObjetivoId").val("");
            	$("#objetivo_id").hide();
            }
        })
    });
</script>

